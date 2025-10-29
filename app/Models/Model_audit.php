<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_audit extends Model
{
    protected $table = 'tbl_audit_trail';
    protected $primaryKey = 'id_audit';
    protected $allowedFields = [
        'id_user',
        'username',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'created_at'
        
    ];
    protected $useTimestamps = false;

    public function insertAudit($data)
    {
        // Tambahkan pengisian nama komputer jika belum ada
        if (!isset($data['computer_name'])) {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $data['computer_name'] = gethostbyaddr($ip);
        }
        return $this->insert($data);
    }
    

    public function getActivityByUser($id_user, $limit = 5)
    {
        return $this->where('id_user', $id_user)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    // untuk admin: aktivitas departemen user
    public function getActivityByDept($id_dep, $limit = 10)
    {
        return $this->select('tbl_audit_trail.*, tbl_dep.nama_dep')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_audit_trail.id_user', 'left')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
                    ->where('tbl_user.id_dep', $id_dep)
                    ->orderBy('tbl_audit_trail.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
     public function getAllActivity($limit = 20)
    {
        return $this->select('tbl_audit_trail.*, tbl_dep.nama_dep')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_audit_trail.id_user', 'left')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
                    ->orderBy('tbl_audit_trail.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    public function getLastActivity($limit = 10)
        {
            return $this->select('tbl_audit_trail.*, tbl_dep.nama_dep')
                        ->join('tbl_user', 'tbl_user.id_user = tbl_audit_trail.id_user', 'left')
                        ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
                        ->orderBy('created_at', 'DESC')
                        ->limit($limit)
                        ->findAll();
        }
    public function getActivityByDepartment($depId, $limit = 10)
{
    return $this->select('tbl_audit_trail.*, tbl_user.username, tbl_dep.nama_dep')
                ->join('tbl_user', 'tbl_user.id_user = tbl_audit_trail.id_user', 'left')
                ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
                ->where('tbl_user.id_dep', $depId)
                ->orderBy('tbl_audit_trail.created_at', 'DESC')
                ->limit($limit)
                ->findAll();
}
}
    

