<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_arsip_akses extends Model
{
    protected $table = 'tbl_arsip_akses';
    protected $primaryKey = 'id_akses';
    protected $allowedFields = ['id_arsip', 'id_dep', 'id_user', 'tipe_akses'];
    protected $useTimestamps = false;

    /**
     * Ambil daftar arsip yang bisa diakses oleh user.
     *
     * @param int $id_dep   Departemen user
     * @param int $id_user  ID user
     * @param int $level    Level user (0 = superadmin)
     * @return array
     */
    public function getArsipForUser($id_dep, $id_user, $level)
    {
        $builder = $this->db->table('tbl_arsip')
            ->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_dep.nama_dep')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori', 'left')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep', 'left');

        // 🔹 Superadmin: bisa lihat semua
        if ($level == 0) {
            return $builder->get()->getResultArray();
        }

        // 🔹 Untuk user biasa
        $builder->groupStart()
            // Akses 1: Arsip umum, semua bisa lihat
            ->where('tbl_arsip.klasifikasi', 'umum')

            // Akses 2: Arsip rahasia, hanya departemennya sendiri
            ->orGroupStart()
            ->where('tbl_arsip.klasifikasi', 'rahasia')
            ->where('tbl_arsip.id_dep', $id_dep)
            ->groupEnd()

            // Akses 3: Arsip terbatas - departemen yang diizinkan
            ->orGroupStart()
            ->where('tbl_arsip.klasifikasi', 'terbatas')
            ->whereIn(
                'tbl_arsip.id_arsip',
                $this->db->table('tbl_arsip_akses')
                    ->select('id_arsip')
                    ->where('id_dep', $id_dep)
            )
            ->groupEnd()

            // Akses 4: Arsip terbatas - user spesifik
            ->orGroupStart()
            ->where('tbl_arsip.klasifikasi', 'terbatas')
            ->whereIn(
                'tbl_arsip.id_arsip',
                $this->db->table('tbl_arsip_akses')
                    ->select('id_arsip')
                    ->where('id_user', $id_user)
            )
            ->groupEnd()
            ->groupEnd();

        return $builder->get()->getResultArray();
    }
}
