<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_kategori extends Model
{
    protected $table = 'tbl_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori', 'id_dep', 'parent_id'];

    public function getByDep($id_dep)
    {
        return $this->where('id_dep', $id_dep)->findAll();
    }

    public function getKategoriWithDep()
    {
        return $this->db->table($this->table)
            ->select('tbl_kategori.*, tbl_dep.nama_dep')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_kategori.id_dep', 'left')
            ->get()
            ->getResultArray();
    }

    public function getKategoriTreeOptimized($id_dep = null)
    {
        $builder = $this->db->table($this->table)
            ->select('tbl_kategori.*, tbl_dep.nama_dep')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_kategori.id_dep', 'left');

        if ($id_dep !== null) {
            $builder->where('tbl_kategori.id_dep', $id_dep);
        }

        $rows = $builder->get()->getResultArray();

        $tree = [];
        $refs = [];

        foreach ($rows as &$row) {
            $row['children'] = [];
            $refs[$row['id_kategori']] = &$row;
        }

        foreach ($rows as &$row) {
            if ($row['parent_id'] && isset($refs[$row['parent_id']])) {
                $refs[$row['parent_id']]['children'][] = &$row;
            } else {
                $tree[] = &$row;
            }
        }

        return $tree;
    }

    public function getKategoriWithParent($id_dep = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_kategori.*, tbl_dep.nama_dep, parent.nama_kategori as parent_nama');
        $builder->join('tbl_dep', 'tbl_dep.id_dep = tbl_kategori.id_dep', 'left');
        $builder->join('tbl_kategori as parent', 'parent.id_kategori = tbl_kategori.parent_id', 'left');

        if ($id_dep !== null) {
            $builder->where('tbl_kategori.id_dep', $id_dep);
        }

        return $builder->get()->getResultArray();
    }

    public function getFullPath($idKategori)
    {
        $path = [];
        $visited = [];

        while ($idKategori) {
            if (in_array($idKategori, $visited, true)) {
                log_message('error', "Loop terdeteksi di kategori ID: $idKategori");
                break;
            }

            $visited[] = $idKategori;

            $kategori = $this->find($idKategori);
            if (!$kategori) break;

            $path[] = $kategori['nama_kategori'];
            $idKategori = $kategori['parent_id'] ?? null;
        }

        return array_reverse($path);
    }
}
