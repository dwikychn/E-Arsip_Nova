<?php

namespace App\Controllers;

use App\Models\Model_arsip;
use App\Models\Model_departemen;
use App\Models\Model_kategori;
use App\Traits\AuditTrailTrait;

class Cari extends BaseController
{
    use AuditTrailTrait;
    protected $Model_arsip;
    protected $Model_departemen;
    protected $Model_kategori;
    protected $db;

    public function __construct()
    {
        $this->Model_arsip = new Model_arsip();
        $this->Model_departemen = new Model_departemen();
        $this->Model_kategori = new Model_kategori();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $model = new \App\Models\Model_arsip();
        $data = [
            'title' => 'Cari Arsip',
            'arsip' => $model->getArsip(),
            'page'  => 'cari',
        ];
        return view('pages/cari', $data);
    }

    public function cariArsip()
    {
        $keyword = $this->request->getVar('keyword');
        $id_dep  = (int) session()->get('id_dep');
        $id_user = (int) session()->get('id_user');
        $level   = (int) session()->get('level');

        $arsip = $this->Model_arsip->searchArsip($keyword, $id_dep, $id_user, $level);

        $data = [
            'title' => 'Hasil Pencarian Arsip',
            'arsip' => $arsip,
            'keyword' => $keyword,
        ];

        return view('pages/cari_arsip', $data);
    }

    // ===============================
    // 🧾 Preview Arsip
    // ===============================
    public function preview($id)
    {
        $id_dep  = (int) session()->get('id_dep');
        $id_user = (int) session()->get('id_user');
        $level   = (int) session()->get('level');

        $arsip = $this->Model_arsip->find($id);
        if (!$arsip) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (!$this->isAllowed($arsip)) {
            return redirect()->to('/cari')->with('error_cari', ['Anda tidak punya akses untuk melihat arsip ini.']);
        }

        // 📂 Bangun path folder arsip
        $depRow = $this->db->table('tbl_dep')->where('id_dep', $arsip['id_dep'])->get()->getRowArray();
        $departemenFolder = $depRow ? url_title($depRow['nama_dep'], '_', true) : 'unknown_dep';
        $kategoriPath = $this->getKategoriPath($arsip['id_kategori']);

        $filePath = ROOTPATH . 'uploads/' . $departemenFolder . '/' . $kategoriPath . '/' . $arsip['file_arsip'];

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)
                ->setBody('❌ File tidak ditemukan di server: ' . $filePath);
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mime = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ][$ext] ?? 'application/octet-stream';

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $arsip['file_arsip'] . '"')
            ->setBody(file_get_contents($filePath));
    }

    // ===============================
    // 🧭 Stream file (dipanggil oleh fetch)
    // ===============================
    public function stream($id)
    {
        $arsip = $this->Model_arsip->find($id);
        if (!$arsip) {
            return $this->response->setStatusCode(404)
                ->setBody('❌ Arsip tidak ditemukan di database.');
        }

        $depRow = $this->db->table('tbl_dep')
            ->where('id_dep', $arsip['id_dep'])
            ->get()->getRowArray();

        $departemenFolder = $depRow ? url_title($depRow['nama_dep'], '_', true) : 'unknown_dep';
        $kategoriPath = $this->getKategoriPath($arsip['id_kategori']);
        $filePath = ROOTPATH . 'uploads/' . $departemenFolder . '/' . $kategoriPath . '/' . $arsip['file_arsip'];

        if (!is_file($filePath)) {
            return $this->response->setStatusCode(404)
                ->setBody('❌ File tidak ditemukan di server: ' . $filePath);
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeType = match ($ext) {
            'pdf'  => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'doc'  => 'application/msword',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            default => 'application/octet-stream',
        };

        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . basename($filePath) . '"')
            ->setBody(file_get_contents($filePath));
    }

    // ===============================
    // 🔁 Utility: Dapatkan path kategori bertingkat
    // ===============================
    private function getKategoriPath($idKategori)
    {
        $path = [];
        $kategori = $this->db->table('tbl_kategori')
            ->where('id_kategori', $idKategori)
            ->get()->getRowArray();

        while ($kategori) {
            $path[] = str_replace(' ', '_', strtolower($kategori['nama_kategori']));
            if (!$kategori['parent_id']) break;
            $kategori = $this->db->table('tbl_kategori')
                ->where('id_kategori', $kategori['parent_id'])
                ->get()->getRowArray();
        }

        return implode('/', array_reverse($path));
    }

    // ===============================
    // 🧹 Hapus Banyak Arsip (dengan validasi hak akses)
    // ===============================
    public function hapus_multiple()
    {
        $ids = $this->request->getPost('id_arsip');
        if (!$ids) {
            return redirect()->to(base_url('cari'))->with('error_cari', ['Tidak ada arsip yang dipilih.']);
        }

        $deleted = 0;
        $skipped = 0;

        foreach ($ids as $id) {
            $arsip = $this->Model_arsip->find($id);
            if ($arsip && $this->isAllowed($arsip)) {
                $this->Model_arsip->delete($id);
                $deleted++;
            } else {
                $skipped++;
            }
        }

        if ($deleted > 0) {
            session()->setFlashdata('pesan_cari', "$deleted arsip berhasil dihapus.");
        }

        if ($skipped > 0) {
            session()->setFlashdata('error_cari', ["$skipped arsip dilewati karena Anda tidak memiliki izin."]);
        }

        return redirect()->to(base_url('cari'));
    }

    // ===============================
    // 🔒 Fungsi pengecekan akses user terhadap arsip
    // ===============================
    private function isAllowed($arsip): bool
    {
        $id_dep  = (int) session()->get('id_dep');
        $id_user = (int) session()->get('id_user');
        $level   = (int) session()->get('level');

        if ($level === 0) return true;
        if (strtolower($arsip['klasifikasi']) === 'umum') return true;
        if (strtolower($arsip['klasifikasi']) === 'rahasia' && $arsip['id_dep'] == $id_dep) return true;

        if (strtolower($arsip['klasifikasi']) === 'terbatas') {
            if ($arsip['id_user'] == $id_user) return true;
            $cek = $this->db->table('tbl_arsip_akses')
                ->where('id_arsip', $arsip['id_arsip'])
                ->groupStart()
                ->groupStart()
                ->where('tipe_akses', 'departemen')
                ->where('id_dep', $id_dep)
                ->groupEnd()
                ->orGroupStart()
                ->where('tipe_akses', 'user')
                ->where('id_user', $id_user)
                ->groupEnd()
                ->groupEnd()
                ->countAllResults();
            return $cek > 0;
        }

        return false;
    }
}
