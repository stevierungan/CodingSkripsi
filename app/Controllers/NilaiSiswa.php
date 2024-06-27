<?php

namespace App\Controllers;

use App\Models\NilaiSiswaModel;

class NilaiSiswa extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->nilai_siswa = new NilaiSiswaModel();
    }

    public function index()
    {
        // dd($this->nilai_siswa->get_siswa());
        $data = [
            'title' => 'Nilai Siswa',
            'data_siswa' => $this->nilai_siswa->get_siswa()
        ];

        return view('nilai_siswa', $data);
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {
            $nis = service('request')->getPost('nis');
            $kriteria = $this->nilai_siswa->get_kriteria();
            $alternatif = $this->nilai_siswa->get_alternatif();

            foreach ($kriteria as $k => $v) {
                foreach ($alternatif as $k2 => $v2) {
                    $data[$v['kodeKriteria']][$v2['kodeAlternatif']] = $this->nilai_siswa->get_nilai($nis, $v['kodeKriteria'], $v2['kodeAlternatif']);
                }
            }

            foreach ($this->nilai_siswa->get_nilai_siswa($nis) as $k => $v) {
                $data2[$v['kode_kriteria']][$v['kode_alternatif']] = $v;
            }

            $result = json_encode($data2);

            return $result;
        }
    }

    public function ubah_nilai()
    {
        $input = service('request')->getPost();
        $nis = $input['nis'];

        unset($input['csrf_test_name']);
        unset($input['nis']);

        foreach ($input as $key => $value) {
            $kri_alt = explode("/", $key);

            $data = [
                'nis' => $nis,
                'kodeKriteria' => $kri_alt[0],
                'kodeAlternatif' => $kri_alt[1],
                'nilai' => $value
            ];

            if ($this->nilai_siswa->get_nilai($nis, $kri_alt[0], $kri_alt[1]) != null) {
                if ($this->nilai_siswa->update_nilai_siswa($data)) {
                    $this->session->setFlashdata('pesan', ['Data berhasil diubah.', 'success']);
                } else {
                    $this->session->setFlashdata('pesan', ['Data gagal diubah.', 'danger']);
                }
            } else {
                if ($this->nilai_siswa->add_nilai_siswa($data)) {
                    $this->session->setFlashdata('pesan', ['Data berhasil diubah.', 'success']);
                } else {
                    $this->session->setFlashdata('pesan', ['Data gagal diubah.', 'danger']);
                }
            }
        }

        return redirect()->to('/nilai_siswa');
    }
}
