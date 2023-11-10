<?php

namespace App\Controllers;

use \App\Models\KomikModel;
use \App\Models\CategoryModelKomik;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Komik extends BaseController
{
    private $komikModel, $catModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->komikModel = new KomikModel();
        $this->catModel = new CategoryModelKomik();
    }

    public function index()
    {
        $dataKomik = $this->komikModel->getKomik();
        //dd($dataKomik);
        $data = [
            'title' => 'Data Komik',
            'result' => $dataKomik
        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $dataKomik = $this->komikModel->getKomik($slug);
        $data = [
            'title' => 'Detail Komik',
            'result' => $dataKomik
        ];
        return view('komik/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Komik',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }

    public function save()
    {
        // Validasi Input
        $validation = \Config\Services::validation();

        $rules = [
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah ada'
                ]
            ],
            'penulis' => 'required',
            'tahun_rilis' => 'required|numeric',
            'harga' => 'required|numeric',
            'diskon' => 'permit_empty|decimal',
            'stok' => 'required|integer',
            'cover' =>
            [
                'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/komik/create')->withInput();
            // $data = [
            //     'title' => 'Tambah Komik',
            //     'category' => $this->catModel->findAll(),
            //     'validation' => $this->validator
            // ];
            // return view('/komik/create', $data);
        }

        // Mengambil File Sampul
        $fileSampul = $this->request->getFile('cover');
        // Cek gambar, apakah masih gambar lama
        if (
            $fileSampul->getError() == 4
        ) {
            $namaFile = $this->defaultImage;
        } else {
            // Generate Nama File
            $namaFile = $fileSampul->getRandomName();
            // Pindahkan File ke Folder img di public
            $fileSampul->move(
                'img',
                $namaFile
            );
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'penulis' => $this->request->getVar('penulis'),
            'tahun_rilis' => $this->request->getVar('tahun_rilis'),
            'harga' => $this->request->getVar('harga'),
            'diskon' => $this->request->getVar('diskon'),
            'stok' => $this->request->getVar('stok'),
            'cover' => $namaFile,
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug
        ]);

        session()->setFlashdata("msg", "Komik berhasil ditambahkan!");
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $dataKomik = $this->komikModel->getKomik($slug);
        // Jika data komiknya kosong
        if (empty($dataKomik)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul komik $slug tidak ditemukan!");
        }

        $data = [
            'title' => 'Ubah Komik',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
            'result' => $dataKomik
        ];
        return view('komik/edit', $data);
    }

    public function update($id)
    {
        // Cek Judul
        $dataOld = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($dataOld['judul'] == $this->request->getVar('judul')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required|is_unique[komik.judul]';
        }

        // Validasi Input
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_title,
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah ada'
                ]
            ],
            'penulis' => 'required',
            'tahun_rilis' => 'required|numeric',
            'harga' => 'required|numeric',
            'diskon' => 'permit_empty|decimal',
            'stok' => 'required|integer',
            'cover' =>
            [
                'rules' => 'uploaded[cover]|max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ])) {

            $data = [
                'title' => 'Edit Buku',
                'category' => $this->catModel->findAll(),
                'validation' => $this->validator
            ];
            // return view('/book/edit/' , $data);
            //return redirect()->to('/book/create' . $data)->withInput();
            // dd($this->request->getFile('sampul'));
            // dd(\Config\Services::validation()->getErrors());
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $namaFileLama = $this->request->getVar('sampullama');
        // Mengambil File Sampul
        $fileSampul = $this->request->getFile('cover');
        // Cek gambar, apakah masih gambar lama
        if ($fileSampul->getError() == 4) {
            $namaFile = $namaFileLama;
        } else {
            // Generate Nama File
            $namaFile = $fileSampul->getRandomName();
            // Pindahkan File ke Folder img di public
            $fileSampul->move('img', $namaFile);

            // Jika sampulnya default
            if ($namaFileLama != $this->defaultImage && $namaFileLama != "") {
                // hapus gambar
                unlink('img/' . $namaFileLama);
            }
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'komik_id' => $id,
            'judul' => $this->request->getVar('judul'),
            'penulis' => $this->request->getVar('penulis'),
            'tahun_rilis' => $this->request->getVar('tahun_rilis'),
            'harga' => $this->request->getVar('harga'),
            'diskon' => $this->request->getVar('diskon'),
            'stok' => $this->request->getVar('stok'),
            'cover' => $namaFile,
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug
        ]);

        session()->setFlashdata("msg", "Komik berhasil diubah!");
        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // Cari gambar by ID
        //$dataKomik = $this->komikModel->find($id);
        $this->komikModel->delete($id);

        // Jika sampulnya default
        // if ($dataKomik['sampul'] != $this->defaultImage) {
        //     // hapus gambar
        //     unlink('img/' . $dataKomik['sampul']);
        // }

        session()->setFlashdata("msg", "Komik berhasil dihapus!");
        return redirect()->to('/komik');
    }

    public function importData()
    {
        $file = $this->request->getFile("file");
        $ext = $file->getExtension();
        if ($ext == "xls")
            $render = new Xls();
        else
            $render = new Xlsx();

        $spreadsheet = $render->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $key => $value) {
            if ($key == 0) continue;

            $namaFile = $this->defaultImage;
            $slug = url_title($value[1], '-', true);

            //Cek Judul

            $dataOld = $this->komikModel->getKomik($slug);
            //dd($dataOld);
            // if(isset($dataOld)) {
            //     if($dataOld['title'] != $value[1]) {

            //    }
            //  }


            if (!isset($dataOld)) {
                $this->komikModel->save([
                    'judul' => $value[1],
                    'penulis' => $value[2],
                    'tahun_rilis' => $value[3],
                    'harga' => $value[4],
                    'diskon' => $value[5] ?? 0,
                    'stok' => $value[6],
                    'komik_category_id' => $value[7],
                    'slug' => $slug,
                    'cover' => $namaFile
                ]);
            } else if ($dataOld['judul'] != $value[1]) {
                $this->komikModel->save([
                    'judul' => $value[1],
                    'penulis' => $value[2],
                    'tahun_rilis' => $value[3],
                    'harga' => $value[4],
                    'diskon' => $value[5] ?? 0,
                    'stok' => $value[6],
                    'komik_category_id' => $value[7],
                    'slug' => $slug,
                    'cover' => $namaFile
                ]);
            }
        }
        session()->setFlashdata("msg", "Data berhasil diimport!");

        return redirect()->to('/komik');
    }
}
