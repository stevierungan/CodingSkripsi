<?php

namespace App\Models;

use CodeIgniter\Model;

class KuisModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db = db_connect();
        $this->timestamp = date('Y-m-d G:i:s');
    }

    protected $allowedFields = [
        'id', 'soal', 'jawaban'
    ];

    public function get_kuis()
    {
        $query = $this->db->query(
            "SELECT 
                a.*,
                b.nama nama_kriteria, 
                c.nama nama_alternatif, 
                d.soal
            FROM ref_kuis_jawaban a
            LEFT JOIN kriteria b ON a.kodeKriteria = b.kode
            LEFT JOIN alternatif c ON a.kodeAlternatif = c.kode
            LEFT JOIN ref_kuis_soal d ON a.idSoal = d.id"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_soal()
    {
        $query = $this->db->query(
            'SELECT id, soal
            FROM ref_kuis_soal'
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function edit_soal($id, $soal)
    {
        $builder = $this->db->table('ref_kuis_soal');

        $builder->where('id', $id);
        $builder->update($soal);

        return $builder;
    }

    public function get_jawaban($soal)
    {
        $query = $this->db->query(
            "SELECT 
            a.id,
            a.kodeKriteria,
            a.kodeAlternatif,
            a.idSoal,
            a.jawaban,
            a.bobot,
            b.nama AS nama_kriteria,
            c.nama AS nama_alternatif
            FROM ref_kuis_jawaban a
            LEFT JOIN kriteria b ON a.kodeKriteria = b.kode
            LEFT JOIN alternatif c ON a.kodeAlternatif = c.kode
            WHERE a.idSoal = $soal"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function edit_jawaban($data)
    {
        $builder = $this->db->table('ref_kuis_jawaban');

        $builder->updateBatch($data, 'id');

        return $builder;
    }

    public function get_soal_ajax($id)
    {
        $query = $this->db->query(
            "SELECT a.*, b.nama nama_kriteria, c.nama nama_alternatif, d.soal
            FROM ref_kuis_jawaban a
            LEFT JOIN kriteria b ON a.kodeKriteria = b.kode
            LEFT JOIN alternatif c ON a.kodeAlternatif = c.kode
            LEFT JOIN ref_kuis_soal d ON a.idSoal = d.id
            WHERE a.idSoal = $id"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_alternatif()
    {
        $query = $this->db->query('SELECT kode FROM alternatif');

        $result = $query->getResultArray();

        return $result;
    }

    public function insert_nilai_kuis($data)
    {
        $builder = $this->db->table('nilai_siswa');
        $builder->insertBatch($data);

        return $this->db->affectedRows();
    }

    public function cek_nilai_kuis($nis)
    {
        $query = $this->db->query(
            "SELECT *
            FROM nilai_siswa
            WHERE kodeKriteria IN (
                SELECT kode FROM kriteria WHERE jenis = 'Kuis'
            )
            AND nis = $nis"
        );

        $result = $query->getResultArray();

        return $result;
    }
}
