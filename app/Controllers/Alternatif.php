<?php

namespace App\Controllers;

use App\Models\AlternatifModel;

class Alternatif extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->alternatif = new AlternatifModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Alternatif',
            'data_alternatif' => $this->alternatif->get_all_alternatif()
        ];

        return view('alternatif', $data);
    }

    public function tambah()
    {
        $input = $this->request;

        $data = [
            'kode' => $input->getPost('kode'),
            'nama' => $input->getPost('nama')
        ];

        if (!$this->alternatif->add_alternatif($data)) {
            $this->session->setFlashdata('pesan', ['Data berhasil ditambahkan.', 'success']);
        } else {
            $this->session->setFlashdata('pesan', ['Data gagal ditambahkan.', 'danger']);
        }

        return redirect()->back();
    }

    public function delete($kode = 0)
    {
        $this->alternatif->delete_alternatif($kode);

        $this->session->setFlashdata('pesan', ['Data berhasil dihapus.', 'danger']);

        return redirect()->back();
    }

    public function edit()
    {
        $input = $this->request;

        $kode = $input->getPost('kode');

        $data = [
            'nama' => $input->getPost('nama'),
            'jenis' => $input->getPost('jenis'),
        ];

        $this->alternatif->update_alternatif($kode, $data);

        return redirect()->back();
    }

    public function detail($kode = 0)
    {
        $data = [
            'title' => 'Alternatif',
            'data_alternatif' => [$this->alternatif->detail_alternatif($kode)]
        ];

        return view('alternatif', $data);
    }
}
