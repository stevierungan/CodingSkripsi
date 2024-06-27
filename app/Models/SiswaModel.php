<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db = db_connect();
        $this->timestamp = date('Y-m-d G:i:s');
    }

    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    protected $allowedFields = [
        'nis', 'nama', 'jenis_kelamin', 'asal_sekolah', 'email'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';

    public function get_all_siswa()
    {
        $result = $this->orderBy('updated_at', 'desc')->findAll();

        return $result;
    }

    public function add_siswa($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function add_siswa_user($username, $password, $nama)
    {
        $data = ['username' => $username, 'password' => $password];

        $this->db->query("INSERT INTO user (username, password, profil, role) VALUES ('$username', '$password', '$nama', 2)");
    }

    public function detail_siswa($nis)
    {
        $result = $this->where('nis', $nis)->first();

        if (!$result) {
            dd("as");
        } else {
            dd($result);
        }

        return $result;
    }

    public function update_siswa($nis, $data)
    {
        $result = $this->update($nis, $data);

        return $result;
    }

    public function delete_siswa($nis)
    {
        $result = $this->where('nis', $nis)->delete();

        return $result;
    }

    public function delete_siswa_user($nis)
    {
        $this->db->query(
            "DELETE FROM user WHERE username = '$nis'"
        );
    }

    public function delete_siswa_nilai($nis)
    {
        $this->db->query(
            "DELETE FROM nilai_siswa WHERE nis = '$nis'"
        );
    }
}
