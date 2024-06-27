<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'user';

    public function autentikasi($username, $password)
    {
        $this->select('*');
        $this->table('user');
        $this->where('username', $username);
        $this->where('password', $password);

        $result = $this->get()->getRowArray();

        return $result;
    }

    // public function test()
    // {
    //     $this->db->transStart();
    //     $this->db->query('AN SQL QUERY...');
    //     $this->db->query('ANOTHER QUERY...');
    //     $this->db->transComplete();

    //     if ($this->db->transStatus() === false) {
    //         // generate an error... or use the log_message() function to log your error
    //     }
    // }
}
