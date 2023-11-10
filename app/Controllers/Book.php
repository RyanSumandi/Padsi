<?php

namespace App\Controllers;

use \App\Models\BookModel;
use \App\Models\CategoryModel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class Book extends BaseController
{
    private $bookModel, $catModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->catModel = new CategoryModel();
    }

    public function index()
    {
        $dataBook = $this->bookModel->getBook();
        //dd($dataBuku)
        $data = [
            'title' => 'Data Buku',
            'result' => $dataBook
        ];

        return view('book/index', $data);
    }

    public function detail($slug)
    {
        $dataBook = $this->bookModel->getBook($slug);
        $data = [
            'title' => 'Detail Buku',
            'result' => $dataBook
        ];
        return view('book/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Buku',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('book/create', $data);
    }

    public function save()
    {
        // Validasi Input
        $validation = \Config\Services::validation();

        $rules = [
            'title' => [
                'rules' => 'required|is_unique[book.title]',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'author' => 'required',
            'release_year' => 'required|integer',
            'price' => 'required|numeric',
            'discount' => 'permit_empty|decimal',
            'stock' => 'required|integer',
            'cover' =>
            [
                'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jepg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1 MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
                ],
            ];

            if (!$this->validate($rules)) {
                return redirect()->to('/book/create')->withInput();
                // $data = [
            //     'title' => 'Tambah Buku',
            //     'category' => $this->catModel->findAll(),
            //     'validation' => $this->validator
            // ];
            // return view('/komik/create', $data);
            }

        //Mengambil File sampul
        $fileSampul = $this->request->getFile('cover');
        //cek gambar, apakam masih lama
        if (
            $fileSampul->getError() == 4
            ) {
            $namaFile = $this->defaultImage;
        } else {
            // Generate nama file
            $namaFile = $fileSampul->getRandomName();
            // pindahkan file ke folder img di public
            $fileSampul->move(
                'img',
                $namaFile
            );
        }

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->bookModel->save([
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'discount' => $this->request->getVar('discount'),
            'stock' => $this->request->getVar('stock'),
            'cover' => $namaFile,
            'book_category_id' => $this->request->getVar('book_category_id'),
            'slug' => $slug,
        ]);

        session()->setFlashdata("msg", "Data berhasil ditambahkan!");
        return redirect()->to('/book');
    }

    public function edit($slug)
    {
        $dataBook = $this->bookModel->getBook($slug);
        // Jika data buku kosong
        if (empty($dataBook)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul buku $slug tidak ditemukan!");
        }

        $data = [
            'title' => 'Ubah Buku',
            'category' => $this->catModel->findAll(),
            'validation' => \Config\Services::validation(),
            'result' => $dataBook
        ];
        return view('book/edit', $data);    
    }

    public function update($id)
    {
        // cek judul
        $dataOld = $this->bookModel->getBook($this->request->getVar('slug'));
        if ($dataOld['title'] == $this->request->getVar('title')) {
            $rule_title = 'required';
        }  else {
            $rule_title = 'required|is_unique[book.title]';
        }

        //Validasi Input
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'title' => [
                'rules' => $rule_title,
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah ada'
                ]
            ],
            'author' => 'required',
            'release_year' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'permit_empty|decimal',
            'stock' => 'required|integer',
            'cover' =>
            [
                'rules' => 'uploaded[cover]|max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1 MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ])) {

            $data = [
                'title =>Edit Buku',
                'category' => $this->catModel->findAll(),
                'validation' => $this->validator
            ];
            // return view('/book/edit/' , $data);
            //return redirect()->to('/book/create' . $data)->withInput();
            // dd($this->request->getFile('sampul'));
            // dd(\Config\Services::validation()->getErrors());
            return redirect()->to('/book/edit/' . $this->request->getVar('slug'))->withInput();
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

        $slug = url_title($this->request->getVar('title'), '-', true);
        $this->bookModel->save([
            'book_id' => $id,
            'title' => $this->request->getVar('title'),
            'author' => $this->request->getVar('author'),
            'release_year' => $this->request->getVar('release_year'),
            'price' => $this->request->getVar('price'),
            'discount' => $this->request->getVar('discount'),
            'stock' => $this->request->getVar('stock'),
            'cover' => $namaFile,
            'book_category_id' => $this->request->getVar('book_category_id'),
            'slug' => $slug
        ]);

        session()->setFlashdata("msg", "Data berhasil diubah!");
        return redirect()->to('/book');
    }
    
    public function delete($id)
    {
        // Cari gambar by ID
        //$dataBuku = $this->bookModel->find($id);
        $this->bookModel->delete($id);

        // Jika sampulnya default
        // if ($dataBuku['sampul'] != $this->defaultImage) {
        //     // hapus gambar
        //     unlink('img/' . $dataBuku['sampul']);
        // }

        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/book');
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

            $dataOld = $this->bookModel->getBook($slug);
            //dd($dataOld);
            // if(isset($dataOld)) {
            //     if($dataOld['title'] != $value[1]) {

            //    }
            //  }


            if (!isset($dataOld)) {
                $this->bookModel->save([
                    'title' => $value[1],
                    'author' => $value[2],
                    'release_year' => $value[3],
                    'price' => $value[4],
                    'discount' => $value[5] ?? 0,
                    'stock' => $value[6],
                    'book_category_id' => $value[7],
                    'slug' => $slug,
                    'cover' => $namaFile
                ]);
            } else if ($dataOld['title'] != $value[1]) {
                $this->bookModel->save([
                    'title' => $value[1],
                    'author' => $value[2],
                    'release_year' => $value[3],
                    'price' => $value[4],
                    'discount' => $value[5] ?? 0,
                    'stock' => $value[6],
                    'book_category_id' => $value[7],
                    'slug' => $slug,
                    'cover' => $namaFile
                ]);
            }
        }
        session()->setFlashdata("msg", "Data berhasil diimport!");

        return redirect()->to('/book');
    }
}
