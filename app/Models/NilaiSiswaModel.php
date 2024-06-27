<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiSiswaModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db = db_connect();
        $this->timestamp = date('Y-m-d G:i:s');
    }

    protected $table = 'nilai_siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nilai', 'nis', 'kodeKriteria', 'kodeAlternatif', 'created_at', 'updated_at'];

    public function get_siswa()
    {
        $query = $this->db->query(
            "SELECT b.* 
            FROM nilai_siswa a
            LEFT JOIN siswa b ON a.nis = b.nis
            GROUP BY b.nis"
        );

        $result = $query->getResultArray();
        // dd($result);
        return $result;
    }

    public function get_nilai($nis, $kriteria, $alternatif)
    {
        $query = $this->db->query("SELECT 
        -- a.id AS id_nilai, 
        a.nis AS nis, 
        b.kodeKriteria AS kode_kriteria, 
        b.kodeAlternatif AS kode_alternatif, 
        b.nilai AS nilai, 
        c.nama AS nama_kriteria, 
        d.nama AS nama_alternatif, 
        c.jenis AS jenis_kriteria
        FROM siswa a
        LEFT JOIN nilai_siswa b ON a.nis = b.nis
        LEFT JOIN kriteria c ON b.kodeKriteria = c.kode
        LEFT JOIN alternatif d ON b.kodeAlternatif = d.kode
        WHERE b.nis = $nis
        AND b.kodeKriteria = '$kriteria'
        AND b.kodeAlternatif = '$alternatif'
        -- AND c.jenis = 'Non Kuis'
        ");

        $result = $query->getRowArray();

        return $result;
    }

    public function get_nilai_siswa($nis)
    {
        $query = $this->db->query("SELECT 
        -- a.id AS id_nilai, 
        a.nis AS nis, 
        b.kodeKriteria AS kode_kriteria, 
        b.kodeAlternatif AS kode_alternatif, 
        b.nilai AS nilai, 
        c.nama AS nama_kriteria, 
        d.nama AS nama_alternatif, 
        c.jenis AS jenis_kriteria
        FROM siswa a
        LEFT JOIN nilai_siswa b ON a.nis = b.nis
        LEFT JOIN kriteria c ON b.kodeKriteria = c.kode
        LEFT JOIN alternatif d ON b.kodeAlternatif = d.kode
        WHERE b.nis = $nis
        AND c.jenis = 'Non Kuis'
        ");

        $result = $query->getResultArray();

        return $result;
    }

    public function add_nilai_siswa($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function update_nilai_siswa($data)
    {
        $nilai = $data['nilai'];
        $nis = $data['nis'];
        $kriteria = $data['kodeKriteria'];
        $alternatif = $data['kodeAlternatif'];

        $this->db->query(
            "UPDATE nilai_siswa
            SET 
                nilai = '$nilai',
                updated_at = '$this->timestamp'
            WHERE nis = '$nis'
            AND kodeKriteria = '$kriteria'
            AND kodeAlternatif = '$alternatif'
            "
        );

        $result = $this->db->affectedRows();

        return $result;
    }

    public function detail_nilai_siswa($nis, $kode_kriteria, $kode_alternatif)
    {
        $query = $this->db->query(
            "SELECT 
                a.id AS idNilai,
                a.nis AS nis, 
                a.nilai AS nilai, 
                -- a.kodeKriteria AS kodeKriteria, 
                -- a.kodeAlternatif AS kodeAlternatif, 
                b.nama AS nama, 
                c.nama AS namaKriteria, 
                d.nama AS namaAlternatif
            FROM nilai_siswa a
            JOIN siswa b ON a.nis = b.nis
            JOIN kriteria c ON a.kodeKriteria = c.kode
            JOIN alternatif d ON a.kodeAlternatif = d.kode
            WHERE a.nis = $nis
            AND a.kodeKriteria = '$kode_kriteria'
            AND a.kodeAlternatif = '$kode_alternatif'
            ORDER BY a.kodeAlternatif"
        );

        $result = $query->getRowArray();

        return $result;
    }

    public function get_kriteria()
    {
        $query = $this->db->query(
            "SELECT 
            a.kode AS kodeKriteria,
                CONCAT(a.kode, '-', a.nama) AS namaKriteria
            FROM kriteria a
            -- WHERE a.jenis = 'Non Kuis'
            "
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_alternatif()
    {
        $query = $this->db->query(
            "SELECT
            a.kode AS kodeAlternatif, 
            CONCAT(a.kode, '-', a.nama) AS namaAlternatif
            FROM aLternatif a"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function debug_insert($data)
    {
        $builder = $this->db->table('kuis_jawaban');
        $builder->insertBatch($data);
    }
}
