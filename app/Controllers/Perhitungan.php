<?php

namespace App\Controllers;

use App\Models\PerhitunganModel;
use App\Models\KriteriaModel;

class Perhitungan extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->perhitungan = new PerhitunganModel();
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
                $normalisasi[$k][] = $v2['normalisasi'];
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

        foreach ($normalisasi as $key => $value) {
            $jumlah_normalisasi[$key] = array_sum($value);
            $jumlah_bobot[$key] = array_sum($value) / 4;
        }

        // foreach ($this->perhitungan->get_siswa() as $k => $v) {
        //     foreach ($this->perhitungan->get_alternatif() as $k2 => $v2) {
        //         $nilai_rank = 0;

        //         foreach ($this->perhitungan->get_kriteria() as $k3 => $v3) {
        //             $nilai_rank = round((100 - $this->perhitungan->get_nilai($v['nis'], $v2['kodeAlternatif'], $v3['kodeKriteria'])['nilai']) * round($jumlah_bobot[$v3['kodeKriteria']], 2), 1) + $nilai_rank;
        //         }

        //         $data_siswa[$v['nis']][$v2['namaAlternatif']] = $nilai_rank;
        //     }
        // }

        if (count($this->perhitungan->get_siswa()) > 0) {
            foreach ($this->perhitungan->get_siswa() as $k => $v) {
                foreach ($this->perhitungan->get_alternatif_siswa($v['nis']) as $k2 => $v2) {
                    $nilai_rank = 0;

                    foreach ($this->perhitungan->get_kriteria_siswa($v['nis']) as $k3 => $v3) {
                        $nilai_rank = round((100 - $this->perhitungan->get_nilai($v['nis'], $v2['kodeAlternatif'], $v3['kodeKriteria'])['nilai']) * round($jumlah_bobot[$v3['kodeKriteria']], 2), 1) + $nilai_rank;
                    }

                    $data_siswa2[$v['nis']][$v2['kodeAlternatif']] = $nilai_rank;
                }
            }
        } else {
            $data_siswa2 = [];
        }

        $data = [
            'title' => 'Perhitungan',
            'data_siswa' => $data_siswa2
        ];

        return view('perhitungan', $data);
    }

    public function get_hasil_siswa()
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
                $normalisasi[$k][] = $v2['normalisasi'];
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

        foreach ($normalisasi as $key => $value) {
            $jumlah_normalisasi[$key] = array_sum($value);
            $jumlah_bobot[$key] = array_sum($value) / 4;
        }
        
        if (count($this->perhitungan->get_siswa_by_nim(session('username'))) > 0) {
            foreach ($this->perhitungan->get_siswa_by_nim(session('username')) as $k => $v) {
                foreach ($this->perhitungan->get_alternatif_siswa($v['nis']) as $k2 => $v2) {
                    $nilai_rank = 0;

                    foreach ($this->perhitungan->get_kriteria_siswa($v['nis']) as $k3 => $v3) {
                        $nilai_rank = round((100 - $this->perhitungan->get_nilai($v['nis'], $v2['kodeAlternatif'], $v3['kodeKriteria'])['nilai']) * round($jumlah_bobot[$v3['kodeKriteria']], 2), 1) + $nilai_rank;
                    }

                    $data_siswa2[$v['nis']][$v2['kodeAlternatif']] = $nilai_rank;
                }
                
                arsort($data_siswa2[session('username')]);
            }
        } else {
            $data_siswa2 = [];
        }

        $data = [
            'title' => 'Hasil',
            'data_siswa' => $data_siswa2,
            'data_alternatif' => $this->perhitungan->get_alternatif_siswa_new(session('username'))
        ];
        
// dd($data);
        return view('hasil_siswa', $data);
    }
}
