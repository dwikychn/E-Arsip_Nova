<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_auth extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama_user', 'id_dep', 'username', 'password', 'level'];

    public function login($username, $password)
    {
        // Ambil user + nama departemen
        $user = $this->db->table('tbl_user u')
            ->select('u.*, d.nama_dep')
            ->join('tbl_dep d', 'd.id_dep = u.id_dep', 'left')
            ->where('u.username', $username)
            ->get()
            ->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
