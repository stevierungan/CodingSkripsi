<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db = db_connect();
    }

    public function get_siswa()
    {
        $query = $this->db->query(
            "SELECT b.nis, b.nama
            FROM nilai_siswa a
            LEFT JOIN siswa b ON a.nis = b.nis
            GROUP BY a.nis"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_siswa_by_nim($nim)
    {
        $query = $this->db->query(
            "SELECT b.nis, b.nama
            FROM nilai_siswa a
            LEFT JOIN siswa b ON a.nis = b.nis
            WHERE a.nis = '$nim'"
        );

        $result = $query->getResultArray();
        
        return $result;
    }

    // public function get_siswa()
    // {
    //     $query = $this->db->query(
    //         "SELECT a.nis, a.nama
    //         FROM siswa a"
    //     );

    //     $result = $query->getResultArray();

    //     return $result;
    // }

    public function get_nilai($nis, $alternatif, $kriteria)
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
        ");

        $result = $query->getRowArray();

        return $result;
    }

    public function get_kriteria()
    {
        $query = $this->db->query(
            "SELECT 
            a.kode AS kodeKriteria
            FROM kriteria a"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_alternatif()
    {
        $query = $this->db->query(
            "SELECT
            a.kode AS kodeAlternatif, 
            CONCAT(a.kode, '-' ,a.nama) AS namaAlternatif
            FROM aLternatif a"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_alternatif_siswa($nis)
    {
        $query = $this->db->query(
            "SELECT 
                nis,
                kodeAlternatif
            FROM nilai_siswa
            WHERE nis = '$nis'
            GROUP BY kodeAlternatif"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_alternatif_siswa_new($nis)
    {
        $query = $this->db->query(
            "SELECT 
                nis,
                kodeAlternatif,
                nama
            FROM nilai_siswa
            JOIN alternatif ON kodeAlternatif = kode
            WHERE nis = '$nis'
            GROUP BY kodeAlternatif"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_kriteria_siswa($nis)
    {
        $query = $this->db->query(
            "SELECT 
                nis,
                kodeKriteria
            FROM nilai_siswa
            WHERE nis = $nis
            GROUP BY kodeKriteria"
        );

        $result = $query->getResultArray();

        return $result;
    }
}
