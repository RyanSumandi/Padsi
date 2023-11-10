<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $dataUser = $this->userModel->getUsers();
        $data = [
            'title' => 'Data User',
            'result' => $dataUser
        ];
        return view('user/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User'
        ];
        return view('user/create', $data);
    }

    public function save()
    {
        $users_myth = new UserModel();
        $users_myth->save([
            'firstname' => $this->request->getVar('firstname'),
            'lastname' => $this->request->getVar('lastname'),
            'user_name' => $this->request->getVar('username'),
            'user_email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
            'user_password' => password_hash(
                $this->request->getVar('password'),
                PASSWORD_DEFAULT
            ),

        ]);
        session()->setFlashdata("msg", "User berhasil ditambahkan!");
        return redirect()->to('/users');
    }

    public function edit($id)
    {
        $dataUser = $this->userModel->getUsers($id);
        $data = [
            'title' => 'Ubah User',
            'result' => $dataUser
        ];
        return view('user/edit', $data);
    }

    public function update($id)
    {
        $user_myth = new UserModel();
        $this->userModel->save([
            'id' => $id,
            'firstname' => $this->request->getVar('firstname'),
            'lastname' => $this->request->getVar('lastname'),
            'user_name' => $this->request->getVar('username'),
            'user_email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
        ]);
        session()->setFlashdata("msg", "Berhasil memperbarui user !");

        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/users');
    }
}
