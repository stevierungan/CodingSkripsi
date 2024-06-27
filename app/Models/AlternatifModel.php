<?php

namespace App\Models;

use CodeIgniter\Model;

class AlternatifModel extends Model
{
    protected $table = 'alternatif';
    protected $primaryKey = 'kode';
    protected $allowedFields = [
        'kode', 'nama'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';

    public function get_all_alternatif()
    {
        $result = $this->orderBy('updated_at', 'desc')->findAll();

        return $result;
    }

    public function add_alternatif($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function detail_alternatif($kode)
    {
        $result = $this->where('kode', $kode)->first();

        if (!$result) {
            dd("as");
        } else {
            dd($result);
        }

        return $result;
    }

    public function update_alternatif($kode, $data)
    {
        $result = $this->update($kode, $data);

        return $result;
    }

    public function delete_alternatif($kode)
    {
        $result = $this->where('kode', $kode)->delete();

        return $result;
    }
}
