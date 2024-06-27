<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Login extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->login = new LoginModel();
    }

    public function index()
    {
        $data = ['validation' => \Config\Services::validation()];

        // d(session('logged_in'));
        return view('login/login', $data);
    }

    public function authentication()
    {
        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password'));

        if (!$this->validate([
            'username' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => 'User ID tidak boleh kosong.',
                    'max_length' => 'User ID tidak boleh lebih dari 10 karakter.'
                ]
            ],
            'password' => [
                'rules' => 'required|max_length[8]|numeric',
                'errors' => [
                    'required' => 'Password tidak boleh kosong.',
                    'max_length' => 'Password tidak boleh lebih dari 8 karakter.',
                    'numeric' => 'Password harus angka.'
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();

            return redirect()->to('/login')->withInput()->with('validation', $validation);
        } else {
            $userdata = $this->login->autentikasi($username, $password);

            if (!$userdata) {
                $this->session->setFlashdata('pesan', ['Username atau Password salah!', 'danger']);

                return redirect()->to('/login');
            } else {
                $this->_sessdata = [
                    'username' => $userdata['username'],
                    'profil' => $userdata['profil'],
                    'role' => $userdata['role'],
                    'logged_in' => true,
                    'sessdata2' => 'test'
                ];

                $this->session->set($this->_sessdata);

                return redirect()->route("/");
            }
        }
    }

    public function sign_up()
    {
        $this->session->destroy();

        return redirect()->back();
    }

    public function logout()
    {
        $this->session->destroy();

        return redirect()->route('login');
    }
}
