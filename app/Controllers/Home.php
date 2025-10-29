<?php

namespace App\Controllers;

use App\Models\Model_home;
use App\Models\Model_audit;
use App\Models\Model_arsip;
use App\Models\Model_user;
use App\Models\Model_departemen;

class Home extends BaseController
{
    protected $Model_home;
    protected $Model_audit;
    protected $Model_arsip;
    protected $Model_departemen;
    protected $Model_user;

    public function __construct()
    {
        $this->Model_home       = new Model_home();
        $this->Model_audit      = new Model_audit();
        $this->Model_arsip      = new Model_arsip();
        $this->Model_departemen = new Model_departemen();
        $this->Model_user       = new Model_user();
        helper('format');
    }

    public function index(): string
    {
        $session = session();
        $userId  = (int) $session->get('id_user');
        $depId   = (int) $session->get('id_dep');
        $level   = (int) $session->get('level');

        $user = $this->Model_user->find($userId);
        if (!$user) {
            return "User tidak ditemukan! Silakan coba login kembali.";
        }

        // ADMIN
        if ($level === 1) {
            return $this->adminDashboard($depId, $level);
        }

        // USER
        elseif ($level === 2) {
            return $this->userDashboard($depId, $level);
        }

        // SUPERADMIN
        elseif ($level === 0) {
            return $this->superAdminDashboard();
        }

        return "Level user tidak dikenali!";
    }

    // ================= SUPERADMIN =================
    private function superAdminDashboard(): string
    {
        $kategoriData    = $this->Model_arsip->getCountByKategori();
        $departemenChart = $this->Model_arsip->getCountPerDepartment();

        $tot_size     = $this->Model_arsip->getTotalSize();
        $tot_size_int = (int) ($tot_size ?? 0);

        $data = [
            'title'           => 'Dashboard Superadmin',
            'tot_arsip'       => $this->Model_home->tot_arsip(),
            'tot_dep'         => $this->Model_home->tot_dep(),
            'tot_kategori'    => $this->Model_home->tot_kategori(),
            'tot_user'        => $this->Model_home->tot_user(),
            'tot_Rahasia'     => $this->Model_arsip->where('klasifikasi', 'Rahasia')->countAllResults(),
            'tot_terbatas'    => $this->Model_arsip->where('klasifikasi', 'terbatas')->countAllResults(),
            'tot_Umum'        => $this->Model_arsip->where('klasifikasi', 'Umum')->countAllResults(),
            'tot_size'        => formatSize($tot_size_int),
            'lastActivity'    => $this->Model_audit->getLastActivity(5),
            'kategoriChart'   => $kategoriData,
            'departemenChart' => $departemenChart,
            'jumlahUser'      => $this->Model_user->countAllResults(),
            'jumlahFile'      => $this->Model_arsip->countAllResults(),
        ];

        return view('pages/home_superadmin', $data);
    }

    // ================= ADMIN =================
    private function adminDashboard(int $depId, int $level): string
    {
        $totalArsip   = $this->Model_arsip->countByDepartment($depId);
        $totalUser    = $this->Model_user->countByDepartment($depId);

        // ambil kategori chart per departemen
        $kategoriChart = $this->Model_arsip->getCountKategoriByDepId($depId);

        $lastActivity = $this->Model_audit->getActivityByDepartment($depId, 10);

        $deptInfo = $this->Model_departemen->find($depId);
        $quickDept = [[
            'nama_dep'   => $deptInfo['nama_dep'] ?? 'Departemen',
            'total_arsip' => $totalArsip,
            'total_user' => $totalUser
        ]];

        $data = [
            'title'         => 'Dashboard Admin Departemen',
            'level'         => $level,
            'tot_Rahasia'   => $this->Model_arsip->where(['id_dep' => $depId, 'klasifikasi' => 'Rahasia'])->countAllResults(),
            'tot_terbatas'  => $this->Model_arsip->where(['id_dep' => $depId, 'klasifikasi' => 'terbatas'])->countAllResults(),
            'tot_Umum'      => $this->Model_arsip->where(['id_dep' => $depId, 'klasifikasi' => 'Umum'])->countAllResults(),
            'kategoriChart' => $kategoriChart,
            'quickDept'     => $quickDept,
            'totalArsip'    => $totalArsip,
            'totalUser'     => $totalUser,
            'lastActivity'  => $lastActivity
        ];

        return view('pages/home_admin', $data);
    }

    // ================= USER =================
    private function userDashboard(int $depId, int $level): string
    {
        $kategoriChart = $this->chartKategoriUser($depId);
        $lastActivity  = $this->Model_audit->getActivityByDepartment($depId, 10);
        $totalArsip = $this->Model_arsip
            ->where('id_dep', $depId)
            ->countAllResults();

        $deptInfo = $this->Model_departemen->find($depId);
        $quickDept = [[
            'nama_dep'   => $deptInfo['nama_dep'] ?? 'Departemen',
            'total_arsip' => $totalArsip,
        ]];

        $data = [
            'title'          => 'Dashboard User Departemen',
            'level'          => $level,
            'tot_Rahasia'    => $this->Model_arsip->where(['id_dep' => $depId, 'klasifikasi' => 'Rahasia'])->countAllResults(),
            'tot_terbatas'   => $this->Model_arsip->where(['id_dep' => $depId, 'klasifikasi' => 'terbatas'])->countAllResults(),
            'tot_Umum'       => $this->Model_arsip->where(['id_dep' => $depId, 'klasifikasi' => 'Umum'])->countAllResults(),
            'kategoriChart'  => $kategoriChart,
            'quickDept'      => [],
            'totalArsip'     => $totalArsip,
            'quickDept'      => $quickDept,
            'lastActivity'   => $lastActivity
        ];

        // ganti view untuk user
        return view('pages/home_user', $data);
    }

    // ================= CHART METHODS =================
    private function chartKategoriAdmin(int $depId)
    {
        return $this->Model_arsip->getCountKategoriByDepId($depId);
    }

    private function chartKategoriUser(int $depId)
    {
        return $this->Model_arsip->getCountKategoriByDepId($depId);
    }
}
