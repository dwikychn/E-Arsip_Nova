<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_user extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama_user', 'id_dep', 'username', 'password', 'level'];
    protected $useTimestamps = false;
    protected $returnType    = 'array';
    protected $validationRules = [];
    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan, silakan pilih yang lain.'
        ]
    ];

    public function all_data()
    {
        return $this->db->table('tbl_user')
            ->select('tbl_user.*, tbl_dep.nama_dep')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
            ->orderBy('tbl_user.nama_user', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function addUser($data)
    {
        return $this->insert($data);
    }

    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    public function countByDepartment(int $depId): int
    {
        return (int) $this->where('id_dep', $depId)->countAllResults();
    }

    public function getAllUsers()
    {
        return $this->select('id_user, nama_user, id_dep, level')
            ->orderBy('nama_user', 'ASC')
            ->findAll();
    }
}
