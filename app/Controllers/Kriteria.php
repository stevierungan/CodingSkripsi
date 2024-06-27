<?php

namespace App\Controllers;

use App\Models\KriteriaModel;

class Kriteria extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->kriteria = new KriteriaModel();
    }

    public function index()
    {
        $kriteria = $this->kriteria->get_all_kriteria();

        foreach ($kriteria as $k => $v) {
            $jumlah_pc[$k] = $this->kriteria->get_jumlah_kriteria($v['kode']);
        }

        foreach ($kriteria as $k => $v) {
            foreach ($kriteria as $k2 => $v2) {
                $bobot = $this->kriteria->get_bobot_kriteria($v['kode'], $v2['kode'])['bobot'];

                $bobot_kriteria[$v['kode']][$v2['kode']] = [
                    'kode' => $v['kode'] . "==" . $v2['kode'],
                    'nilai' => $bobot,
                    'jumlah_pc' => $jumlah_pc[$k2]['bobot'],
                    'normalisasi' => $bobot / $jumlah_pc[$k2]['bobot'],
                    'nama' => $v['nama'],
                    // 'k2' => $k2
                ];
            }
        }

        foreach ($bobot_kriteria as $k => $v) {
            foreach ($v as $k2 => $v2) {
                $normalisasi[$k . '-' . $v2['nama']][] = $v2['normalisasi'];
            }

            $af = array_key_first($bobot_kriteria);
            $jumlah_dumdum[] = $bobot_kriteria[$af][$k]['jumlah_pc'];
        }

        $x = 0;
        $lamda_maks = 0;

        foreach ($normalisasi as $k => $v) {
            $lamda_maks = $lamda_maks + (array_sum($v) / 4 * $jumlah_dumdum[$x++]);
        }

        $ci = ($lamda_maks - count($kriteria)) / (count($kriteria) - 1);
        $cr = $ci / 0.9;

        $data = [
            'title' => 'Kriteria',
            'data_kriteria' => $this->kriteria->get_all_kriteria(),
            'pairwise_comparison' => $bobot_kriteria,
            'normalisasi' => $normalisasi,
            'jumlah_pc' => $jumlah_pc,
            'lamda_maks' => $lamda_maks,
            'ci' => $ci,
            'cr' => $cr
        ];

        return view('kriteria', $data);
    }

    public function tambah()
    {
        $input = $this->request;

        $data = [
            'kode' => $input->getPost('kode'),
            'nama' => $input->getPost('nama'),
            'jenis' => $input->getPost('jenis'),
        ];

        $kriteria = $this->kriteria->get_all_kriteria();

        for ($i = 0; $i < count($kriteria); $i++) {
            $kriteria1 = $kriteria[$i]['kode'];
            $kriteria2 = $data['kode'];
            $bobot = 0;

            $data_bobot[] =
                [
                    'kriteria1' => $kriteria1,
                    'kriteria2' => $kriteria2,
                    'bobot' => $bobot
                ];
        }

        for ($i = 0; $i <= count($kriteria); $i++) {
            $kriteria1 = $data['kode'];

            if ($i == count($kriteria)) {
                $kriteria2 = $data['kode'];
                $bobot = 1;
            } else {
                $kriteria2 = $kriteria[$i]['kode'];
                $bobot = 0;
            }

            $data_bobot[] =
                [
                    'kriteria1' => $kriteria1,
                    'kriteria2' => $kriteria2,
                    'bobot' => $bobot
                ];
        }

        if (!$this->kriteria->add_kriteria($data)) {
            $this->session->setFlashdata('pesan1', ['Data kriteria berhasil ditambahkan.', 'success']);
        } else {
            $this->session->setFlashdata('pesan1', ['Data kriteria gagal ditambahkan.', 'danger']);
        }

        if ($this->kriteria->add_bobot_kriteria($data_bobot)) {
            $this->session->setFlashdata('pesan2', ['Data bobot kriteria berhasil ditambahkan.', 'success']);
        } else {
            $this->session->setFlashdata('pesan2', ['Data bobot kriteria gagal ditambahkan.', 'danger']);
        }

        return redirect()->back();
    }

    public function delete($kode1 = 0)
    {
        $this->kriteria->delete_kriteria($kode1);

        $this->kriteria->delete_bobot_kriteria($kode1);

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

        $this->kriteria->update_kriteria($kode, $data);

        return redirect()->back();
    }

    public function detail($kode = 0)
    {
        $data = [
            'title' => 'Kriteria',
            'data_kriteria' => [$this->kriteria->detail_kriteria($kode)]
        ];

        return view('kriteria', $data);
    }

    public function ubah_bobot_kriteria()
    {
        $input = $this->request;

        $k1 = $input->getPost('bobot_kriteria1');
        $k2 = $input->getPost('bobot_kriteria2');
        $bobot = $input->getPost('bobot_nilai');

        $this->kriteria->ubah_bobot_kriteria($k1, $k2, $bobot);

        return redirect()->route('kriteria');
    }
}
