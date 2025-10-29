<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_departemen extends Model
{
    protected $table = 'tbl_dep';
    protected $primaryKey = 'id_dep';
    protected $allowedFields = ['nama_dep'];

    public function all_data()
    {
        return $this->orderBy('nama_dep', 'ASC')->findAll();
    }

    public function addDep($data)
    {
        return $this->insert($data);
    }
    public function getDepWithCount()
    {
        return $this->db->table('tbl_dep d')
            ->select('d.id_dep, d.nama_dep, COUNT(a.id_arsip) as total')
            ->join('tbl_arsip a', 'a.id_dep = d.id_dep', 'left') // left join biar tetap tampil walau kosong
            ->groupBy('d.id_dep, d.nama_dep')
            ->orderBy('d.nama_dep', 'ASC')
            ->get()
            ->getResultArray();
    }
}
