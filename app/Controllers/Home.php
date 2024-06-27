<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (session('logged_in') != true) {
            return redirect()->to('login');
        }

        $data = [
            'title' => 'Home',
            'js' => ''
        ];

        return view('home', $data);
    }
}
