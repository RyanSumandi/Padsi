<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Auth extends Controller
{
    public function indexregister()
    {
        helper(['form']);
        $data = [];

        return view('auth/register', $data);
    }

    public function saveRegister()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|min_length[6]|max_length[50]
            valid_email|is_unique[user.user_email]',
            'password' => 'required|min_length[6]|max_length[200]',
            'pass_confirm' => 'matches[password]'

        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'user_name' => $this->request->getVar('username'),
                'user_email' => $this->request->getVar('email'),
                'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'user_created_at' => Time::now('America/Chicago', 'en_US'),
            ];
            $model->save($data);
            return redirect()->to('/login');
        } else {
            $data['validation'] = $this->validator;
            echo view('auth/register', $data);
        }   
    }

    public function indexlogin()
    {
        helper(['form']);
        echo view('auth/login');
    }

    public function auth()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('user_email', $email)->orwhere('user_name', $email)->first();

        if ($data) {
            $pass = $data['user_password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'user_id' => $data['id'],
                    'user_name' => $data['user_name'],
                    'user_email' => $data['user_email'],
                    'role' => $data['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login')->withInput();
            }
        } else {
            $session->setFlashdata('msg', 'Email atau Password Tidak Ada');
            return redirect()->to('/login')->withInput();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
