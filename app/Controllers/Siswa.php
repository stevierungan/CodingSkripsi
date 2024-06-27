<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Siswa extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->siswa = new SiswaModel();
    }

    public function index()
    {
        // if (session('logged_in') != true) {
        //     return redirect()->to('login');
        // }

        $data = [
            'title' => 'Siswa',
            'data_siswa' => $this->siswa->get_all_siswa()
        ];

        return view('siswa', $data);
    }

    public function tambah()
    {
        $input = $this->request;

        $data = [
            'nis' => $input->getPost('nis'),
            'nama' => $input->getPost('nama'),
            'jenis_kelamin' => $input->getPost('jenis_kelamin'),
            'asal_sekolah' => $input->getPost('asal_sekolah'),
            'email' => $input->getPost('email')
        ];

        $password = md5('123');

        $this->siswa->add_siswa_user($data['nis'], $password, $input->getPost('nama'));

        if (!$this->siswa->add_siswa($data)) {
            $this->session->setFlashdata('pesan', ['Data berhasil ditambahkan.', 'success']);
        } else {
            $this->session->setFlashdata('pesan', ['Data gagal ditambahkan.', 'danger']);
        }

        return redirect()->back();
    }

    public function delete($nis = 0)
    {
        $this->siswa->delete_siswa($nis);
        $this->siswa->delete_siswa_user($nis);
        $this->siswa->delete_siswa_nilai($nis);

        $this->session->setFlashdata('pesan', ['Data berhasil dihapus.', 'danger']);

        return redirect()->back();
    }

    public function edit()
    {
        $input = $this->request;

        $nis = $input->getPost('nis');

        $data = [
            'nama' => $input->getPost('nama'),
            'jenis_kelamin' => $input->getPost('jenis_kelamin'),
            'asal_sekolah' => $input->getPost('asal_sekolah'),
            'email' => $input->getPost('email')
        ];

        $this->siswa->update_siswa($nis, $data);

        return redirect()->back();
    }

    public function detail($nis = 0)
    {
        $data = [
            'title' => 'Siswa',
            'data_siswa' => [$this->siswa->detail_siswa($nis)]
        ];

        return view('siswa', $data);
    }
}
