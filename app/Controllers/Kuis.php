<?php

namespace App\Controllers;

use App\Models\KuisModel;

use App\Controllers\BaseController;

class Kuis extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->kuis = new KuisModel();
        $this->_username = session('username');
    }

    public function index()
    {
        foreach ($this->kuis->get_soal() as $key => $value) {
            $data_kuis['soal'][] = $value;
            $data_kuis['jawaban'][$value['id']] = $this->kuis->get_jawaban($value['id']);
        }

        $data = [
            'title' => 'Kuis',
            'data_kuis' => $data_kuis
        ];

        return view('kuis', $data);
    }

    public function edit_kuis()
    {
        $input = $this->request;

        $id_soal = $input->getPost('id_soal');
        $soal = [
            'soal' => $input->getPost('soal')
        ];

        $jawaban = $input->getPost('jawaban');

        $this->kuis->edit_soal($id_soal, $soal);
        $this->kuis->edit_jawaban($jawaban);

        return redirect()->back();
    }

    public function get_soal_ajax()
    {
        if ($this->request->isAJAX()) {
            $id = service('request')->getPost('id_soal');

            $data = $this->kuis->get_soal_ajax($id);
        }

        $result = json_encode($data);

        return $result;
    }

    public function kuis_siswa()
    {
        foreach ($this->kuis->get_soal() as $k => $v) {
            $kuis[$k]['soal'] = $v['soal'];
            foreach ($this->kuis->get_jawaban($v['id']) as $k2 => $v2) {
                $kuis[$k]['jawaban'][] = $v2;
            }
        }

        $data = [
            'title' => 'Kuis',
            'kuis' => $kuis
        ];

        // dd($data);

        // dd($this->kuis->cek_nilai_kuis($this->_username));

        if (count($this->kuis->cek_nilai_kuis($this->_username)) > 0) {
            return view('kuis_passed', $data);
        } else {
            return view('kuis_siswa', $data);
        }
    }

    public function kuis_jawaban_siswa()
    {
        $input = $this->request;

        foreach ($input->getPost() as $key => $value) {
            if ($key != 'csrf_test_name') {
                $explode = explode("|", $value);

                $temp_data[] = [
                    'kodeAlternatif' => $explode[0],
                    'kodeKriteria' => $explode[1],
                    'bobot' => (int)$explode[2]
                ];
            }
        }

        foreach ($temp_data as $k => $v) {
            if ($v['kodeAlternatif'] == 'A01') {
                $data_new[$v['kodeKriteria']]['A01'][] = $v['bobot'];
            } elseif ($v['kodeAlternatif'] == 'A02') {
                $data_new[$v['kodeKriteria']]['A02'][] = $v['bobot'];
            } elseif ($v['kodeAlternatif'] == 'A03') {
                $data_new[$v['kodeKriteria']]['A03'][] = $v['bobot'];
            } else {
                $data_new[$v['kodeKriteria']]['A01'][] = $v['bobot'];
                $data_new[$v['kodeKriteria']]['A02'][] = $v['bobot'];
                $data_new[$v['kodeKriteria']]['A03'][] = $v['bobot'];
            }
        }

        foreach ($data_new as $k => $v) {
            foreach ($v as $k2 => $v2) {
                $nilai[$k][$k2] = array_sum($v2);
            }
        }

        foreach ($nilai as $k => $v) {
            if (!array_key_exists("A01", $v)) {
                $nilai[$k]['A01'] = 0;
            }

            if (!array_key_exists("A02", $v)) {
                $nilai[$k]['A02'] = 0;
            }

            if (!array_key_exists("A03", $v)) {
                $nilai[$k]['A03'] = 0;
            }
        }

        $data_kosong = [
            [
                'nis' => $this->_username,
                'kodeKriteria' => 'C01',
                'kodeAlternatif' => 'A01',
                'nilai' => 0
            ],
            [
                'nis' => $this->_username,
                'kodeKriteria' => 'C01',
                'kodeAlternatif' => 'A02',
                'nilai' => 0
            ],
            [
                'nis' => $this->_username,
                'kodeKriteria' => 'C01',
                'kodeAlternatif' => 'A03',
                'nilai' => 0
            ]
        ];

        $this->kuis->insert_nilai_kuis($data_kosong);

        foreach ($nilai as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $data[] = [
                    'nis' => $this->_username,
                    'kodeKriteria' => $key,
                    'kodeAlternatif' => $key2,
                    'nilai' => $value2
                ];
            }
        }

        // dd($data);

        if ($this->kuis->insert_nilai_kuis($data) > 0) {
            $this->session->setFlashdata('pesan', ['Berhasil mengerjakan kuis!', 'success']);

            return redirect()->to('kuis');
        } else {
            $this->session->setFlashdata('pesan', ['Gagal mengerjakan kuis!', 'danger']);

            return redirect()->to('kuis');
        }
    }

    public function debug()
    {
        // $kriteria = $this->nilai_siswa->get_kriteria();
        // $alternatif = $this->nilai_siswa->get_alternatif();
        // $nis = '09272829';

        // foreach ($kriteria as $k => $v) {
        //     foreach ($alternatif as $k2 => $v2) {
        //         $data[$v['kodeKriteria']][$v2['kodeAlternatif']] = $this->nilai_siswa->get_nilai($nis, $v['kodeKriteria'], $v2['kodeAlternatif']);
        //     }
        // }

        // foreach ($this->nilai_siswa->get_nilai_siswa($nis) as $k => $v) {
        //     $data2[$v['kode_kriteria']][$v['kode_alternatif']] = $v;
        // }

        // dd($this->nilai_siswa->get_nilai_siswa($nis), $data, $data2);

        $jawaban =
            [
                [
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 1,
                        'jawaban' => 'Belajar dengan keras untuk lulus ujian masuk',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 1,
                        'jawaban' => 'Menunjukan kelebihan atau bakat unikmu supaya tampil berbeda dari kandidat lain',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 1,
                        'jawaban' => 'Menulis essay pendaftaran yang mantap',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 1,
                        'jawaban' => 'Mendaftar universitas lain untuk cadangan',
                        'bobot' => 25
                    ],
                ],
                [
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 2,
                        'jawaban' => 'Kemampuan beradaptasi',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 2,
                        'jawaban' => 'Kerja Sama/ kerja tim',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 2,
                        'jawaban' => 'Komunikasi',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 2,
                        'jawaban' => 'Pemecahan / penyelesaian Masalah',
                        'bobot' => 25
                    ],
                ],
                [
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 3,
                        'jawaban' => 'Dokter',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 3,
                        'jawaban' => 'Pengusaha',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 3,
                        'jawaban' => 'Sastrawan',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 3,
                        'jawaban' => 'Seniman',
                        'bobot' => 25
                    ],
                ],
                [
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 4,
                        'jawaban' => 'Membuat project pribadi',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 4,
                        'jawaban' => 'Internetan / mencari informasi',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 4,
                        'jawaban' => 'Membaca buku atau menulis jurnal',
                        'bobot' => 25
                    ],
                    [
                        'kodeKriteria' => 'C02',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 4,
                        'jawaban' => 'Mencoba sejuta kegiatan tapi tidak ada serius dilakukan',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 5,
                        'jawaban' => 'Menghitung, serba menggunakan rumus',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 5,
                        'jawaban' => 'Menghafal',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 5,
                        'jawaban' => 'Mengarang',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 5,
                        'jawaban' => 'Menciptakan sesuatu yang baru',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 6,
                        'jawaban' => 'Diam dan di simpan sendiri',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 6,
                        'jawaban' => 'Cari faktanya lalu selesaikan',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 6,
                        'jawaban' => 'Diungkapkan disebuah tulisan atau karya',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 6,
                        'jawaban' => 'Cerita ke teman',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 7,
                        'jawaban' => 'Menggambar',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 7,
                        'jawaban' => 'Tampil didepan umum',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 7,
                        'jawaban' => 'Menulis dan membuat jurnal',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 7,
                        'jawaban' => 'Beraktivitas diluar ruangan',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 8,
                        'jawaban' => 'Menantang apa yang diajarkan oleh guru disekolah',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 8,
                        'jawaban' => 'Paling banyak teman dikelas',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 8,
                        'jawaban' => 'Pendiam, tapi sekali bicara susah berhenti.',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C03',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 8,
                        'jawaban' => 'Tidak suka absen/bo',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 9,
                        'jawaban' => 'Pencari solusi terbaik',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 9,
                        'jawaban' => 'Gampang bergaul dan santai',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 9,
                        'jawaban' => 'Jago berbicara dengan Bahasa yang tinggi',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 9,
                        'jawaban' => 'Detail dan sabar',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 10,
                        'jawaban' => 'Fisika',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 10,
                        'jawaban' => 'Sosiologi',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 10,
                        'jawaban' => 'Bahasa Inggris',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 10,
                        'jawaban' => 'Matematika',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 11,
                        'jawaban' => 'Cenderung diam',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 11,
                        'jawaban' => 'Berkumpul asik dengan teman sepemikiran',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 11,
                        'jawaban' => 'Lebih nyaman sendiri',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 11,
                        'jawaban' => 'Bisa bergabung dengan siapa saja',
                        'bobot' => 25
                    ],
                ],
                [
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A01',
                        'idSoal' => 12,
                        'jawaban' => 'Memikirkan kemungkinan yang akan terjadi',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A02',
                        'idSoal' => 12,
                        'jawaban' => 'Berani mengambil resiko',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => 'A03',
                        'idSoal' => 12,
                        'jawaban' => 'Membuat to do list yang baik dengan teliti',
                        'bobot' => 25
                    ],
                    [

                        'kodeKriteria' => 'C04',
                        'kodeAlternatif' => NULL,
                        'idSoal' => 12,
                        'jawaban' => 'Mencari cara baru agar tidak membosankan',
                        'bobot' => 25
                    ],
                ]
            ];


        foreach ($jawaban as $key => $value) {
            // foreach ($value as $key2 => $value2) {
            // $value['kodeKriteria'], 
            // $value['kodeAlternatif'], 
            // $value['idSoal'], 
            // $value['jawaban'], 
            // $value['bobot'], 

            $this->nilai_siswa->debug_insert($value);
            // }
        }

        // dd($jawaban);
    }
}
