<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\CustomerModel;
use App\Models\SaleModel;
use App\Models\SaleDetailModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Penjualan extends BaseController
{
    private $book, $cart, $cust, $sale, $saleDetail;
    public function __construct()
    {
        $this->book = new BookModel();
        $this->cust = new CustomerModel();
        $this->sale = new SaleModel();
        $this->saleDetail = new SaleDetailModel();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $this->cart->destroy();
        $dataBuku = $this->book->getBook();
        $dataCust = $this->cust->findAll();
        $data = [
            'title' => 'Penjualan',
            'dataKomik' => $dataBuku,
            'dataCust' => $dataCust,
        ];
        return view('penjualan/list', $data);
    }

    public function ShowCart()
    {
        //Fungsi untuk menampilkan Cart
        $output = '';
        $no = 1;
        foreach ($this->cart->contents() as $items) {
            $output .= '
            <tr>
            <td>' . $no++ . '</td>
            <td>' . $items['name'] . '</td>
            <td>' . $items['qty'] . '</td>
            <td>' . number_to_currency($items['price'], 'IDR', 'id_ID', 2) . '</td>
            <td>' . number_to_currency(($items['subtotal']), 'IDR', 'id_ID', 2) . '</td>
            <td>
            <button id="' . $items['rowid'] . '" qty="' . $items['qty'] . '"
            class="ubah_cart btn btn-warning btn-xs" title="Ubah Jumlah"><i class="fa 
            fa-edit"></i></button>
            <button type="button" id="' . $items['rowid'] . '" class="hapus_cart btn 
            btn-danger btn-xs"><i class="fa fa-trash" title="Hapus"></i></button>
            </td>
            </tr>
            ';
        }

        if (!$this->cart->contents()) {
            $output = '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        }
        return $output;
    }

    public function loadCart()
    {
        //load data
        echo $this->ShowCart();
    }

    public function addCart()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getVar('id'),
            'qty'       => $this->request->getVar('qty'),
            'price'     => $this->request->getVar('price'),
            'name'      => $this->request->getVar('name'),
        ));
        echo $this->showCart();
    }


    public function updateCart()
    {
        $this->cart->update(array(
            'rowid' => $this->request->getVar('rowid'),
            'qty'   => $this->request->getVar('qty')
        ));
        echo $this->showCart();
    }

    public function deleteCart($rowid)
    {
        //fungsi untuk menghapus item cart
        $this->cart->remove($rowid);
        echo $this->showCart();
    }

    public function getTotal()
    {
        $totalBayar = 0;
        foreach ($this->cart->contents() as $items) {
            $totalBayar += $items['subtotal'];
        }
        echo number_to_currency($totalBayar, 'IDR', 'id_ID', 2);
    }


    public function pembayaran()
    {
        // Mengecek apakah ada transaksi yang dilakukan
        if (!$this->cart->contents()) {
            // Transaksi kosong
            $response = [
                'status' => false,
                'msg' => "Tidak ada transaksi!",
            ];
            echo json_encode($response);
        } else {
            // Ada transaksi
            $totalBayar = 0;
            foreach ($this->cart->contents() as $items) {
                $totalBayar += $items['subtotal'];
            }

            $nominal = $this->request->getVar('nominal');
            $id = "J" . time();

            // Pengecekan apakah nominal yang dimasukan cukup atau kurang
            if ($nominal < $totalBayar) {
                $response = [
                    'status' => false,
                    'msg' => "Nominal Pembayaran Kurang!"
                ];
                echo json_encode($response);
            } else {
                // Jika nominal memenuhi menyimpan data
                // Di tabel sale dan sale_detail
                $this->sale->save([
                    'sale_id' => $id,
                    'user_id' => session()->user_id,
                    'customer_id' => $this->request->getVar('id-cust')
                ]);
                foreach ($this->cart->contents() as $items) {
                    $this->saleDetail->save([
                        'sale_id' => $id,
                        'book_id' => $items['id'],
                        'amount' => $items['qty'],
                        'price' => $items['price'],
                        'total_price' => $items['subtotal']
                    ]);

                    $book = $this->book->where(['book_id' => $items['id']])->first();
                    $this->book->save([
                        'book_id' => $items['id'],
                        'stock' => $book['stock'] - $items['qty'],
                    ]);
                }
                $this->cart->destroy();
                $kembalian = $nominal - $totalBayar;

                $response = [
                    'status' => true,
                    'msg' => "Pembayaran berhasil",
                    'data' => [
                        'kembalian' => number_to_currency(
                            $kembalian,
                            'IDR',
                            'id_ID',
                            2
                        )
                    ]
                ];
                echo json_encode($response);
            }
        }
    }

    public function report($tgl_awal=null, $tgl_akhir=null)
    {
        $_SESSION['tgl_awal'] = $tgl_awal == null ? date('Y-m-01') : $tgl_awal;
        $_SESSION['tgl_akhir'] = $tgl_akhir == null ? date('Y-m-t') : $tgl_akhir;

        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->sale->getReport($tgl1, $tgl2);
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
            'tanggal' => [
                'tgl_awal' => $tgl1,
                'tgl_akhir' =>$tgl2,
            ],
        ];
        return view('penjualan/report', $data);
    }

    public function exportPDF()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->sale->getReport($tgl1, $tgl2);
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
        ];
        $html = view('penjualan/exportPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-penjualan.pdf', 'I');
    }

    public function exportExcel()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION{'tgl_akhir'};

        $report = $this->sale->getReport($tgl1, $tgl2);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nota')
            ->setCellValue('C1', 'Tgl Transaksi')
            ->setCellValue('D1', 'User')
            ->setCellValue('E1', 'Customer')
            ->setCellValue('F1', 'Total');

        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $no++)
                ->setCellValue('B' . $rows, $value['sale_id'])
                ->setCellValue('C' . $rows, $value['tgl_transaksi'])
                ->setCellValue('D' . $rows, $value['firstname'] . ' ' . $value['lastname'])
                ->setCellValue('E' . $rows, $value['name_cust'])
                ->setCellValue('F' . $rows, $value['total']);
            $rows++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Penjualan';

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function filter()
    {
        $_SESSION['tgl_awal'] = $this->request->getVar('tgl_awal');
        $_SESSION['tgl_akhir'] = $this->request->getVar('tgl_akhir');
        return $this->report($_SESSION['tgl_awal'], $_SESSION['tgl_akhir']);
    }
}

                // Jika nominal memenuhi menyimpan data
                // Di tabel sale dan sale_detail