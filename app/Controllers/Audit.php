<?php

namespace App\Controllers;

use App\Models\Model_audit;

class Audit extends BaseController
{
    protected $auditModel;

    public function __construct()
    {
        $this->auditModel = new Model_audit();
    }

    public function index()
    {
        $session = session();
        $level   = $session->get('level');   // ambil level user dari session
        $id_dep  = $session->get('id_dep');  // ambil id departemen dari session

        // query dasar
        $builder = $this->auditModel
            ->select('tbl_audit_trail.*, tbl_user.level, tbl_user.nama_user, tbl_dep.nama_dep')
            ->join('tbl_user', 'tbl_user.id_user = tbl_audit_trail.id_user', 'left')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
            ->orderBy('tbl_audit_trail.created_at', 'DESC');

        // Jika admin (level 1), filter berdasarkan departemen
        if ($level == 1) {
            $builder->where('tbl_user.id_dep', $id_dep);
        }

        // Jika user biasa (level 2), hanya tampilkan aktivitas dirinya sendiri
        elseif ($level == 2) {
            $builder->where('tbl_user.id_user', $session->get('id_user'));
        }

        // Kalau superadmin (level 0), tidak ada filter — semua tampil

        $data = [
            'title'  => 'Audit Trail',
            'audits' => $builder->findAll()
        ];

        return view('pages/audit', $data);
    }
}
