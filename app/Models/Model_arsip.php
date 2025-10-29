<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_arsip extends Model
{
    protected $table        = 'tbl_arsip';
    protected $primaryKey = 'id_arsip';
    protected $allowedFields = [
        'id_kategori',
        'deskripsi',
        'tgl_upload',
        'tgl_update',
        'file_arsip',
        'id_dep',
        'id_user',
        'nama_user_upload',
        'klasifikasi',
        'ukuran_arsip',
        'path_arsip'
    ];

    public function getCountKategoriByDepId(int $depId): array
    {
        return $this->db->table($this->table)
            ->select('COALESCE(tbl_kategori.nama_kategori, "Tanpa Kategori") AS nama_kategori')
            ->selectCount($this->table . '.id_arsip', 'total')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = ' . $this->table . '.id_kategori', 'left')
            ->where($this->table . '.id_dep', $depId)
            ->groupBy('tbl_kategori.id_kategori')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getKategoriByDepartment($depId)
    {
        return $this->select('klasifikasi, COUNT(*) as total')
            ->where('id_dep', $depId)
            ->groupBy('klasifikasi')
            ->findAll();
    }

    public function getArsip()
    {
        return $this->db->table('tbl_arsip')
            ->select('tbl_arsip.*, 
        CASE 
            WHEN tbl_user.id_user IS NULL 
            THEN CONCAT(tbl_arsip.nama_user_upload, " (User Dihapus)") 
            ELSE tbl_user.nama_user 
        END as nama_user,
        tbl_kategori.nama_kategori, 
        tbl_dep.nama_dep')
            ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user', 'left')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori', 'left')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep', 'left')
            ->orderBy('tbl_arsip.id_arsip', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getArsipByDep($id_dep)
    {
        return $this->db->table('tbl_arsip')
            ->select('tbl_arsip.*, 
        CASE 
            WHEN tbl_user.id_user IS NULL 
            THEN CONCAT(tbl_arsip.nama_user_upload, " (User Dihapus)") 
            ELSE tbl_user.nama_user 
        END as nama_user,
        tbl_kategori.nama_kategori, 
        tbl_dep.nama_dep')
            ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user', 'left')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori', 'left')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep', 'left')
            ->where('tbl_arsip.id_dep', $id_dep)
            ->orderBy('tbl_arsip.id_arsip', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getLastActivityUpload($limit = 5)
    {
        return $this->db->table('tbl_arsip')
            ->select('tbl_arsip.*, 
        CASE 
            WHEN tbl_user.id_user IS NULL 
            THEN CONCAT(tbl_arsip.nama_user_upload, " (User Dihapus)") 
            ELSE tbl_user.nama_user 
        END as nama_user,
        tbl_kategori.nama_kategori, 
        tbl_dep.nama_dep')
            ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user', 'left')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori', 'left')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep', 'left')
            ->orderBy('tbl_arsip.tgl_upload', 'DESC')
            ->orderBy('tbl_arsip.id_arsip', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getTotalSize(): int
    {
        $result = $this->db->table($this->table)
            ->selectSum('ukuran_arsip', 'total_size_bytes')
            ->get()
            ->getRow();

        if ($result && $result->total_size_bytes !== null) {
            return (int) $result->total_size_bytes;
        }

        return 0;
    }

    public function getCountByKategori(): array
    {
        return $this->db->table($this->table)
            ->select('tbl_kategori.nama_kategori')
            ->selectCount('*', 'total')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori', 'left')
            ->groupBy('tbl_kategori.nama_kategori')
            ->get()
            ->getResultArray();
    }

    public function getCountPerDepartment(): array
    {
        return $this->db->table('tbl_dep')
            ->select('tbl_dep.nama_dep, COALESCE(COUNT(tbl_arsip.id_arsip), 0) as total')
            ->join('tbl_arsip', 'tbl_dep.id_dep = tbl_arsip.id_dep', 'left')
            ->groupBy('tbl_dep.id_dep, tbl_dep.nama_dep')
            ->get()
            ->getResultArray();
    }


    public function getArsipForUser($id_dep, $level)
    {
        $builder = $this->db->table('tbl_arsip')
            ->select('tbl_arsip.*, 
        CASE 
            WHEN tbl_user.id_user IS NULL 
            THEN CONCAT(tbl_arsip.nama_user_upload, " (User Dihapus)") 
            ELSE tbl_user.nama_user 
        END as nama_user,
        tbl_kategori.nama_kategori, 
        tbl_dep.nama_dep')
            ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user', 'left')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori', 'left')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep', 'left')
            ->orderBy('tbl_arsip.id_arsip', 'DESC');

        if ($level != 0) {
            $builder->where('tbl_arsip.id_dep', $id_dep);
        }

        return $builder->get()->getResultArray();
    }

    public function getKategoriByUser($userId)
    {
        return $this->select('nama_kategori, COUNT(*) as total')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
            ->where('id_user', $userId)
            ->groupBy('tbl_arsip.id_kategori')
            ->findAll();
    }

    public function getKategoriAll()
    {
        return $this->select('nama_kategori, COUNT(*) as total')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
            ->groupBy('tbl_arsip.id_kategori')
            ->findAll();
    }
    public function countArsipByJenis($jenis, $userId = null)
    {
        $builder = $this->where('klasifikasi', $jenis);

        if ($userId !== null) {
            $builder = $builder->where('id_user', $userId);
        }

        return $builder->countAllResults();
    }

    public function getLastActivityByUser($user_id, $limit = 10)
    {
        return $this->db->table('tbl_arsip')
            ->select('tbl_arsip.file_arsip, tbl_arsip.deskripsi, tbl_arsip.tgl_upload, tbl_user.nama_user')
            ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user', 'left')
            ->where('arsip.user_id', $user_id)
            ->orderBy('arsip.tanggal', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getLastActivityByDepartemen($departemen_id, $limit = 10)
    {
        return $this->db->table('tbl_arsip')
            ->select('tbl_arsip.file_arsip, tbl_arsip.deskripsi, tbl_arsip.tgl_upload, tbl_user.nama_user')
            ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user', 'left')
            ->where('user.departemen_id', $departemen_id)
            ->orderBy('arsip.tanggal', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getLastActivityAll($limit = 10)
    {
        return $this->db->table('tbl_arsip')
            ->select('tbl_arsip.file_arsip, tbl_arsip.deskripsi, tbl_arsip.tgl_upload, tbl_user.nama_user')
            ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user', 'left')
            ->orderBy('arsip.tanggal', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function countByDepartment(int $depId): int
    {
        return (int) $this->where('id_dep', $depId)->countAllResults();
    }

    public function getCountKategori($depId = null, $userId = null)
    {
        $builder = $this->db->table($this->table)
            ->select('tbl_kategori.nama_kategori')
            ->selectCount('tbl_arsip.id_arsip', 'total')
            ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori', 'left');

        if ($depId !== null) {
            $builder->where('tbl_arsip.id_dep', $depId);
        }

        if ($userId !== null) {
            $builder->where('tbl_arsip.id_user', $userId);
        }

        $builder->groupBy('tbl_kategori.nama_kategori');

        return $builder->get()->getResultArray();
    }

    public function getArsipForUserWithAkses($id_dep, $id_user, $level)
    {
        $builder = $this->db->table('tbl_arsip a')
            ->select('a.*, k.nama_kategori, d.nama_dep, u.nama_user')
            ->join('tbl_kategori k', 'k.id_kategori = a.id_kategori', 'left')
            ->join('tbl_dep d', 'd.id_dep = a.id_dep', 'left')
            ->join('tbl_user u', 'u.id_user = a.id_user', 'left');

        if ($level == 0) {
            return $builder->orderBy('a.id_arsip', 'DESC')->get()->getResultArray();
        }

        if ($level == 1) {
            return $builder->where('a.id_dep', $id_dep)
                ->orderBy('a.id_arsip', 'DESC')
                ->get()
                ->getResultArray();
        }

        if ($level == 2) {
            $aksesQuery = $this->db->table('tbl_arsip_akses')
                ->select('id_arsip')
                ->groupStart()
                ->where('tipe_akses', 'departemen')
                ->where('id_dep', $id_dep)
                ->groupEnd()
                ->orGroupStart()
                ->where('tipe_akses', 'user')
                ->where('id_user', $id_user)
                ->groupEnd()
                ->get()
                ->getResultArray();

            $aksesIds = array_column($aksesQuery, 'id_arsip');

            $builder->groupStart()
                ->where('a.id_user', $id_user)
                ->orWhere('a.klasifikasi', 'umum');

            if (!empty($aksesIds)) {
                $builder->orWhereIn('a.id_arsip', $aksesIds);
            }

            $builder->groupEnd();

            return $builder->orderBy('a.id_arsip', 'DESC')->get()->getResultArray();
        }

        return [];
    }

    public function searchArsip(array $filters = [], int $id_user, int $id_dep, bool $isSuper = false)
    {
        $builder = $this->db->table('tbl_arsip a');
        $builder->select('a.*, k.nama_kategori, d.nama_dep, u.nama_user');
        $builder->join('tbl_kategori k', 'a.id_kategori = k.id_kategori', 'left');
        $builder->join('tbl_dep d', 'a.id_dep = d.id_dep', 'left');
        $builder->join('tbl_user u', 'a.id_user = u.id_user', 'left');

        if (!$isSuper) {
            $builder->groupStart()
                ->orWhere('a.id_user', $id_user)
                ->orWhere('a.klasifikasi', 'Umum')
                ->orGroupStart()
                ->where('a.klasifikasi', 'Rahasia')
                ->where('a.id_dep', $id_dep)
                ->groupEnd()
                ->orWhereIn('a.id_arsip', function ($sub) use ($id_dep) {
                    return $sub->select('id_arsip')
                        ->from('tbl_arsip_akses')
                        ->where('tipe_akses', 'departemen')
                        ->where('id_dep', $id_dep);
                })
                ->orWhereIn('a.id_arsip', function ($sub) use ($id_user) {
                    return $sub->select('id_arsip')
                        ->from('tbl_arsip_akses')
                        ->where('tipe_akses', 'user')
                        ->where('id_user', $id_user);
                })
                ->groupEnd();
        }

        if (!empty($filters['keyword'])) {
            $builder->groupStart()
                ->like('a.deskripsi', $filters['keyword'])
                ->orLike('a.file_arsip', $filters['keyword'])
                ->groupEnd();
        }

        if (!empty($filters['kategori'])) {
            $builder->where('a.id_kategori', (int)$filters['kategori']);
        }

        if (!empty($filters['klasifikasi'])) {
            $builder->where('a.klasifikasi', $filters['klasifikasi']);
        }

        if (!empty($filters['tgl_dari']) && !empty($filters['tgl_sampai'])) {
            $builder->where('a.tgl_upload >=', $filters['tgl_dari']);
            $builder->where('a.tgl_upload <=', $filters['tgl_sampai']);
        }

        $builder->orderBy('a.tgl_upload', 'DESC');
        $builder->groupBy('a.id_arsip');

        return $builder->get()->getResultArray();
    }

    // public function cariArsipWithAkses($keyword, $id_dep, $id_user, $level)
    // {
    //     $builder = $this->db->table('tbl_arsip a')
    //         ->select('a.*, k.nama_kategori, d.nama_dep')
    //         ->join('tbl_kategori k', 'a.id_kategori = k.id_kategori', 'left')
    //         ->join('tbl_dep d', 'a.id_dep = d.id_dep', 'left')
    //         ->join('tbl_arsip_akses aa', 'a.id_arsip = aa.id_arsip', 'left')
    //         ->groupBy('a.id_arsip');

    //     if (!empty($keyword)) {
    //         $builder->groupStart()
    //             ->like('a.file_arsip', $keyword)
    //             ->orLike('a.deskripsi', $keyword)
    //             ->orLike('k.nama_kategori', $keyword)
    //             ->groupEnd();
    //     }

    //     if ($level == 0) {
    //         return $builder->get()->getResultArray();
    //     }

    //     $builder->groupStart()
    //         ->where('a.id_dep', $id_dep)
    //         ->orWhere('a.id_user', $id_user)
    //         ->orWhere('(aa.tipe_akses = "departemen" AND aa.id_dep = ' . (int)$id_dep . ')')
    //         ->orWhere('(aa.tipe_akses = "user" AND aa.id_user = ' . (int)$id_user . ')')
    //         ->groupEnd();

    //     return $builder->get()->getResultArray();
    // }

    // public function searchArsipWithAkses($keyword, $id_dep, $id_user, $level)
    // {
    //     $builder = $this->db->table('tbl_arsip a')
    //         ->select('a.*, k.nama_kategori, d.nama_dep')
    //         ->join('tbl_kategori k', 'a.id_kategori = k.id_kategori', 'left')
    //         ->join('tbl_dep d', 'a.id_dep = d.id_dep', 'left')
    //         ->join('tbl_arsip_akses aa', 'a.id_arsip = aa.id_arsip', 'left')
    //         ->groupBy('a.id_arsip');

    //     if (!empty($keyword)) {
    //         $builder->groupStart()
    //             ->like('a.deskripsi', $keyword)
    //             ->orLike('a.file_arsip', $keyword)
    //             ->orLike('k.nama_kategori', $keyword)
    //             ->groupEnd();
    //     }

    //     if ($level == 0) {
    //         return $builder->get()->getResultArray();
    //     }

    //     $builder->groupStart()
    //         ->where('a.id_dep', $id_dep)
    //         ->orWhere('a.id_user', $id_user)
    //         ->orWhere('(aa.tipe_akses = "departemen" AND aa.id_dep = ' . (int)$id_dep . ')')
    //         ->orWhere('(aa.tipe_akses = "user" AND aa.id_user = ' . (int)$id_user . ')')
    //         ->groupEnd();

    //     return $builder->get()->getResultArray();
    // }
}
