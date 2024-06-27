<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModel extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'kode';
    protected $allowedFields = [
        'kode', 'nama', 'jenis', 'id', 'kriteria1', 'kriteria2', 'bobot'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';

    public function get_all_kriteria()
    {
        $result = $this->findAll();

        return $result;
    }

    public function add_kriteria($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function detail_kriteria($kode)
    {
        $result = $this->where('kode', $kode)->first();

        if (!$result) {
            dd("as");
        } else {
            dd($result);
        }

        return $result;
    }

    public function update_kriteria($kode, $data)
    {
        $result = $this->update($kode, $data);

        return $result;
    }

    public function delete_kriteria($kode)
    {
        $result = $this->where('kode', $kode)->delete();

        return $result;
    }

    public function get_kriteria()
    {
        $query = $this->db->query(
            "SELECT 
            a.kode AS kodeKriteria,
                CONCAT(a.kode, '-', a.nama) AS namaKriteria
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
            CONCAT(a.kode, '-', a.nama) AS namaAlternatif
            FROM aLternatif a"
        );

        $result = $query->getResultArray();

        return $result;
    }

    public function get_bobot_kriteria($k1, $k2)
    {
        $query = $this->db->query(
            "SELECT * FROM bobot_kriteria 
            WHERE kriteria1 = '$k1'
            AND kriteria2 = '$k2'"
        );

        $result = $query->getRowArray();

        return $result;
    }

    public function add_bobot_kriteria($data)
    {
        $builder = $this->db->table('bobot_kriteria');
        $result = $builder->insertBatch($data);

        return $result;
    }

    public function delete_bobot_kriteria($kode)
    {
        $result = $this->db->query(
            "DELETE FROM bobot_kriteria 
            WHERE kriteria1 = '$kode'
            OR kriteria2 = '$kode'"
        );

        return $result;
    }

    public function ubah_bobot_kriteria($k1, $k2, $bobot)
    {
        $result = $this->db->query(
            "UPDATE bobot_kriteria
            SET bobot = $bobot
            WHERE kriteria1 = '$k1'
            AND kriteria2 = '$k2'"
        );

        return $result;
    }

    public function get_jumlah_kriteria($kriteria)
    {
        $query = $this->db->query(
            "SELECT SUM(bobot) AS bobot FROM bobot_kriteria 
            WHERE kriteria2 = '$kriteria'"
        );

        $result = $query->getRowArray();

        return $result;
    }
}
