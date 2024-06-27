<?php

namespace App\Models;

use CodeIgniter\Model;

class ChangePasswordModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db = db_connect();
    }

    public function get_user()
    {
        $query = $this->db->query('SELECT * FROM user');

        $result = $query->getResultArray();

        return $result;
    }

    public function user_ubah_password($username, $password)
    {
        $this->db->query(
            "UPDATE user
            SET password = '$password'
            WHERE username = '$username'"
        );
    }
}
