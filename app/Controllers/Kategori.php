<?php

namespace App\Controllers;

use App\Models\Model_kategori;
use App\Models\Model_arsip;
use App\Models\Model_departemen;
use App\Traits\AuditTrailTrait;

class Kategori extends BaseController
{
    use AuditTrailTrait;

    protected $Model_kategori;
    protected $Model_arsip;
    protected $Model_departemen;

    public function __construct()
    {
        $this->Model_kategori = new Model_kategori();
        $this->Model_arsip = new Model_arsip();
        $this->Model_departemen = new Model_departemen();
        helper('form');
    }

    public function index(): string
    {
        $id_dep = session()->get('id_dep');
        $level  = session()->get('level');

        $isSuper = ($level == 0);

        $kategoriTree = $this->Model_kategori->getKategoriTreeOptimized($isSuper ? null : $id_dep);
        $kategoriList = $this->Model_kategori->getKategoriWithParent($isSuper ? null : $id_dep);
        $departemen   = $isSuper ? $this->Model_departemen->findAll() : [];

        $data = [
            'title'        => 'Manajemen Kategori',
            'kategoriTree' => $kategoriTree,
            'kategoriList' => $kategoriList,
            'departemen'   => $departemen,
        ];

        return view('pages/kategori', $data);
    }

    public function add()
    {
        $namaKategori = trim($this->request->getPost('nama_kategori'));
        $parentId     = $this->request->getPost('parent_id');
        $level        = session()->get('level');

        if ($level == 0) {
            $id_dep = $this->request->getPost('id_dep');
        } else {
            $id_dep = session()->get('id_dep');
        }

        if (empty($namaKategori)) {
            return redirect()->back()->with('error_kat', ['Nama kategori wajib diisi!']);
        }

        if ($parentId && !is_numeric($parentId)) {
            return redirect()->back()->with('error_kat', ['Parent ID tidak valid!']);
        }

        if ($parentId && !$this->Model_kategori->find($parentId)) {
            return redirect()->back()->with('error_kat', ['Parent kategori tidak ditemukan!']);
        }

        $cek = $this->Model_kategori
            ->where('nama_kategori', $namaKategori)
            ->where('id_dep', $id_dep)
            ->where('parent_id', $parentId)
            ->first();

        if ($cek) {
            return redirect()->back()->with('error_kat', ['Nama kategori sudah ada di level ini!']);
        }

        $this->Model_kategori->save([
            'nama_kategori' => $namaKategori,
            'id_dep'        => $id_dep,
            'parent_id'     => $parentId ?: null
        ]);

        $dep = $this->Model_departemen->find($id_dep);
        $namaDep = $dep ? $dep['nama_dep'] : 'unknown_dep';

        $pathKategori = $this->buildKategoriPath($parentId);
        $basePath = FCPATH . 'uploads/' . $namaDep . '/' . $pathKategori . $namaKategori;

        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $this->logAudit(
            'Tambah Kategori',
            "Kategori baru: {$namaKategori} (Departemen: {$id_dep}, Parent: " . ($parentId ?? 'root') . ")"
        );

        return redirect()->to(base_url('kategori'))->with('pesan_kat', 'Kategori berhasil ditambahkan.');
    }

    private function buildKategoriPath($parentId)
    {
        $path = '';
        while ($parentId) {
            $parent = $this->Model_kategori->find($parentId);
            if (!$parent) break;
            $path = $parent['nama_kategori'] . '/' . $path;
            $parentId = $parent['parent_id'];
        }
        return $path;
    }

    public function update($id)
    {
        $kategoriModel = $this->Model_kategori;
        $arsipModel = $this->Model_arsip;
        $depModel = $this->Model_departemen;

        $kategoriLama = $kategoriModel->find($id);
        if (!$kategoriLama) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $namaBaru = trim($this->request->getPost('nama_kategori'));
        $parentId = $this->request->getPost('parent_id') ?? null;

        if ($namaBaru === '') {
            return redirect()->back()->with('error', 'Nama kategori wajib diisi.');
        }

        $oldParts = $kategoriModel->getFullPath($id);
        $oldRel = implode('/', array_map(fn($n) => url_title($n, '_', true), $oldParts));

        $kategoriModel->update($id, [
            'nama_kategori' => $namaBaru,
            'parent_id' => $parentId
        ]);

        $newParts = $kategoriModel->getFullPath($id);
        $newRel = implode('/', array_map(fn($n) => url_title($n, '_', true), $newParts));

        $departemenList = $depModel->findAll();

        foreach ($departemenList as $dep) {
            $depFolder = url_title($dep['nama_dep'], '_', true);
            $base = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $depFolder . DIRECTORY_SEPARATOR;

            $folderLama = $base . str_replace('/', DIRECTORY_SEPARATOR, $oldRel);
            $folderBaru = $base . str_replace('/', DIRECTORY_SEPARATOR, $newRel);

            log_message('debug', "[kategori:update] dep={$depFolder} old={$folderLama} -> new={$folderBaru}");

            if (is_dir($folderLama)) {
                if (!is_dir(dirname($folderBaru))) {
                    @mkdir(dirname($folderBaru), 0777, true);
                }

                if (!@rename($folderLama, $folderBaru)) {
                    log_message('warning', "[kategori:update] rename gagal, fallback copy: {$folderLama} -> {$folderBaru}");
                    $this->copyFolder($folderLama, $folderBaru);
                    $this->deleteFolder($folderLama);
                } else {
                    log_message('debug', "[kategori:update] rename sukses: {$folderBaru}");
                }
            } else {
                if (!is_dir($folderBaru)) {
                    @mkdir($folderBaru, 0777, true);
                    log_message('debug', "[kategori:update] folder lama tidak ada — dibuat folder baru: {$folderBaru}");
                } else {
                    log_message('debug', "[kategori:update] folder lama tidak ada, tetapi folder baru sudah ada: {$folderBaru}");
                }
            }

            $oldPrefix = 'uploads/' . $depFolder . '/' . ($oldRel ? $oldRel . '/' : '');
            $newPrefix = 'uploads/' . $depFolder . '/' . ($newRel ? $newRel . '/' : '');

            $arsipModel
                ->like('path_arsip', $oldPrefix, 'after')
                ->set('path_arsip', "REPLACE(path_arsip, '{$oldPrefix}', '{$newPrefix}')", false)
                ->update();
        }

        $this->logAudit('Edit Kategori', "Kategori diubah dari {$kategoriLama['nama_kategori']} menjadi {$namaBaru}");
        return redirect()->to('/kategori')->with('pesan', 'Kategori berhasil diperbarui dan file dipindahkan!');
    }

    private function copyFolder($src, $dst)
    {
        if (!is_dir($src)) return false;
        @mkdir($dst, 0777, true);
        $dir = opendir($src);
        while (($file = readdir($dir)) !== false) {
            if ($file === '.' || $file === '..') continue;
            $srcPath = $src . DIRECTORY_SEPARATOR . $file;
            $dstPath = $dst . DIRECTORY_SEPARATOR . $file;
            if (is_dir($srcPath)) {
                $this->copyFolder($srcPath, $dstPath);
            } else {
                copy($srcPath, $dstPath);
            }
        }
        closedir($dir);
        return true;
    }

    private function deleteFolder($dir)
    {
        if (!is_dir($dir)) return;
        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->deleteFolder($path);
            } else {
                @unlink($path);
            }
        }
        @rmdir($dir);
    }

    public function delete($id = null)
    {
        // Ambil input multiple (kalau ada)
        $ids = $this->request->getPost('id_kategori');

        // Kalau $id dikirim (hapus satuan), jadikan array
        if ($id !== null) {
            $ids = [$id];
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->to(base_url('kategori'))
                ->with('error_kat', ['Tidak ada kategori yang dipilih.']);
        }

        $deleted = [];
        $blocked = [];

        foreach ($ids as $katId) {
            $kategori = $this->Model_kategori->find($katId);
            if (!$kategori) continue;

            // Simpan full path SEBELUM dihapus dari DB
            $pathParts = $this->Model_kategori->getFullPath($katId);
            $pathKategori = implode('/', array_map(fn($n) => url_title($n, '_', true), $pathParts));

            // Cek apakah masih punya arsip/subkategori
            $arsipCount = $this->Model_arsip->where('id_kategori', $katId)->countAllResults();
            $subCount   = $this->Model_kategori->where('parent_id', $katId)->countAllResults();

            if ($arsipCount > 0 || $subCount > 0) {
                $blocked[] = $kategori['nama_kategori'];
                continue;
            }

            // Hapus data kategori
            $this->Model_kategori->delete($katId);
            $deleted[] = $kategori['nama_kategori'];

            // Hapus folder fisik hanya yang sesuai path
            if (!empty($pathKategori)) {
                $departemenList = $this->Model_departemen->findAll();
                foreach ($departemenList as $dep) {
                    $depFolder = FCPATH . 'uploads/' . url_title($dep['nama_dep'], '_', true);
                    $folderPath = $depFolder . '/' . $pathKategori;

                    if (is_dir($folderPath)) {
                        $this->deleteFolder($folderPath);
                    }
                }
            }
        }

        // === LOG & FLASH MESSAGE ===
        if (!empty($deleted)) {
            $this->logAudit('Hapus Kategori', 'Menghapus: ' . implode(', ', $deleted));
            session()->setFlashdata('pesan_kat', 'Kategori berhasil dihapus: ' . implode(', ', $deleted));
        }

        if (!empty($blocked)) {
            session()->setFlashdata('error_kat', [
                'Kategori tidak dapat dihapus karena masih memiliki arsip/subkategori: ' . implode(', ', $blocked)
            ]);
        }

        if (empty($deleted) && empty($blocked)) {
            $this->logAudit('Hapus Kategori', 'Tidak ada kategori yang dihapus.');
        }

        return redirect()->to(base_url('kategori'));
    }
}
