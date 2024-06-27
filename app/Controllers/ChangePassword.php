<?php

namespace App\Controllers;

use App\Models\ChangePasswordModel;

use App\Controllers\BaseController;

class ChangePassword extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->password = new ChangePasswordModel();
    }

    public function admin()
    {
        $data = [
            'title' => 'Change Password',
            'data_user' => $this->password->get_user()
        ];

        return view('change_password_a', $data);
    }

    public function user()
    {
        $data = [
            'title' => 'Change Password'
        ];

        return view('change_password_u', $data);
    }

    public function user_ubah_pw()
    {
        $input = $this->request;

        $username = session('username');
        $password = md5($input->getPost('password'));

        // dd($username, $password);
        $this->password->user_ubah_password($username, $password);

        return redirect()->to('change_password');
    }

    public function reset_password($username)
    {
        $password = md5(123);

        $this->password->user_ubah_password($username, $password);

        return redirect()->to('change_password');
    }
}
