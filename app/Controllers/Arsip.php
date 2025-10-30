<?php

namespace App\Controllers;

use App\Models\Model_kategori;
use App\Models\Model_arsip;
use App\Models\Model_arsip_akses;
use App\Models\Model_departemen;
use App\Models\Model_user;
use App\Traits\AuditTrailTrait;

class Arsip extends BaseController
{
    use AuditTrailTrait;

    protected $Model_kategori;
    protected $Model_arsip;
    protected $Model_arsip_akses;
    protected $Model_departemen;
    protected $Model_user;
    protected $db;

    public function __construct()
    {
        $this->Model_kategori = new Model_kategori();
        $this->Model_arsip = new Model_arsip();
        $this->Model_arsip_akses = new Model_arsip_akses();
        $this->Model_departemen = new Model_departemen();
        $this->Model_user = new Model_user();
        $this->db = \Config\Database::connect();
        helper(['form', 'text']);
    }

    public function index(): string
    {
        $id_dep  = (int) session()->get('id_dep');
        $id_user = (int) session()->get('id_user');
        $level   = (int) session()->get('level');

        $arsip = $this->Model_arsip->getArsipForUserWithAkses($id_dep, $id_user, $level);

        $kategori = ($level == 0)
            ? $this->Model_kategori->getKategoriWithDep()
            : $this->Model_kategori->getByDep($id_dep);

        $departemen = $this->Model_departemen->findAll();

        $users = $this->Model_user
            ->select('tbl_user.id_user, tbl_user.nama_user, tbl_user.id_dep, tbl_dep.nama_dep')
            ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
            ->findAll();

        foreach ($arsip as &$a) {
            $akses = $this->Model_arsip_akses->where('id_arsip', $a['id_arsip'])->findAll();
            $a['akses_dep'] = array_column($akses, 'id_dep');
            $a['akses_user'] = array_column($akses, 'id_user');
        }

        $data = [
            'title'      => 'Dokumen Arsip',
            'kategori'   => $kategori,
            'arsip'      => $arsip,
            'departemen' => $departemen,
            'users'      => $users,
        ];

        return view('pages/arsip', $data);
    }

    public function addArsip()
    {
        $isSuper = ((int) session()->get('level') === 0);

        $idDepList = $this->request->getPost('id_dep');
        $idUser = session()->get('id_user');
        $namaUser = session()->get('nama_user');

        $files = $this->request->getFiles();
        $kategoriList = $this->request->getPost('id_kategori');
        $klasifikasiList = $this->request->getPost('klasifikasi');
        $deskripsiList = $this->request->getPost('deskripsi');
        $namaArsipList = $this->request->getPost('nama_arsip');
        $aksesDepList = $this->request->getPost('akses_dep') ?? [];
        $aksesUserList = $this->request->getPost('akses_user') ?? [];
        $aksesUserGlobalList = $this->request->getPost('akses_user_global') ?? [];

        if (empty($files['file_multiple'])) {
            return redirect()->back()->with('error_upload', 'Tidak ada file yang dipilih.');
        }

        $files = $files['file_multiple'];

        $index = 0;
        foreach ($files as $file) {
            if (!$file->isValid()) {
                $index++;
                continue;
            }

            $idKategori = (int) ($kategoriList[$index] ?? 0);
            $klasifikasi = ucfirst(strtolower($klasifikasiList[$index] ?? 'Umum'));
            $deskripsi = $deskripsiList[$index] ?? null;
            $namaArsipInput = trim($namaArsipList[$index] ?? '');

            $idDep = $isSuper
                ? (int) ($idDepList[$index] ?? 0)
                : (int) session()->get('id_dep');

            if (!$idDep) {
                log_message('error', "Gagal ambil id_dep untuk index $index");
                $index++;
                continue;
            }

            $aksesDep = $aksesDepList[$index] ?? [];
            $aksesUser = $aksesUserList[$index] ?? [];
            $aksesUserGlobal = $aksesUserGlobalList[$index] ?? [];

            $kategoriRow = $this->Model_kategori->find($idKategori);
            $depRow = $this->Model_departemen->find($idDep);

            if (!$kategoriRow || !$depRow) {
                log_message('error', "Kategori atau Departemen tidak valid di index $index");
                $index++;
                continue;
            }

            $kategoriPathParts = $this->Model_kategori->getFullPath($idKategori);
            $kategoriPath = implode('/', array_map(fn($n) => url_title($n, '_', true), $kategoriPathParts));
            $departemenFolder = url_title($depRow['nama_dep'], '_', true);
            $uploadPath = FCPATH . 'uploads/' . $departemenFolder . '/' . $kategoriPath;

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $originalName = pathinfo($file->getClientName(), PATHINFO_FILENAME);
            $ext = $file->getExtension();

            // 🧠 logika rename baru:
            if ($namaArsipInput !== '') {
                $safeName = url_title($namaArsipInput, '_', true);
            } else {
                $safeName = url_title($originalName, '_', true);
            }

            $newName = $safeName . '_' . bin2hex(random_bytes(3)) . '.' . strtolower($ext);
            $file->move($uploadPath, $newName);

            $dataSimpan = [
                'id_kategori' => $idKategori,
                'deskripsi'   => $deskripsi,
                'file_arsip'  => $newName,
                'path_arsip'  => 'uploads/' . $departemenFolder . '/' . $kategoriPath . '/',
                'id_dep'      => $idDep,
                'id_user'     => $idUser,
                'nama_user_upload' => $namaUser,
                'klasifikasi' => $klasifikasi,
                'ukuran_arsip' => $file->getSize(),
            ];

            $this->Model_arsip->save($dataSimpan);
            $idArsip = $this->Model_arsip->getInsertID();

            if (strtolower($klasifikasi) === 'terbatas') {

                foreach ($aksesDep as $depId) {
                    $depId = (int) $depId;

                    $this->Model_arsip_akses->insert([
                        'id_arsip'   => $idArsip,
                        'id_dep'     => $depId,
                        'id_user'    => null,
                        'tipe_akses' => 'departemen',
                    ]);

                    if (!empty($aksesUser[$depId])) {
                        foreach ($aksesUser[$depId] as $usrId) {
                            $usrId = (int) $usrId;
                            $this->Model_arsip_akses->insert([
                                'id_arsip'   => $idArsip,
                                'id_dep'     => $depId,
                                'id_user'    => $usrId,
                                'tipe_akses' => 'user',
                            ]);
                        }
                    }
                }

                if (!empty($aksesUserGlobal)) {
                    foreach ($aksesUserGlobal as $usrId) {
                        $usrId = (int) $usrId;
                        $this->Model_arsip_akses->insert([
                            'id_arsip'   => $idArsip,
                            'id_dep'     => null,
                            'id_user'    => $usrId,
                            'tipe_akses' => 'user',
                        ]);
                    }
                }
            }

            $this->logAudit('Upload Arsip', "Arsip diupload: $newName");
            $index++;
        }

        return redirect()->to('/arsip')->with('pesan_arsip', 'Semua arsip berhasil diupload dengan akses campuran!');
    }

    private function getKategoriPath($idKategori)
    {
        $path = [];
        $kategori = $this->db->table('tbl_kategori')->where('id_kategori', $idKategori)->get()->getRowArray();

        while ($kategori) {
            $path[] = str_replace(' ', '_', strtolower($kategori['nama_kategori']));
            if (!$kategori['parent_id']) break;
            $kategori = $this->db->table('tbl_kategori')->where('id_kategori', $kategori['parent_id'])->get()->getRowArray();
        }

        $path = array_reverse($path);
        return implode('/', $path);
    }

    public function deleteArsip($id)
    {
        $arsip = $this->Model_arsip->find($id);
        if ($arsip) {
            $filePath = FCPATH . $arsip['path_arsip'] . $arsip['file_arsip'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $this->Model_arsip->delete($id);
            $this->Model_arsip_akses->where('id_arsip', $id)->delete();
            $this->logAudit('Hapus Arsip', 'Arsip dihapus: ' . $arsip['file_arsip']);
        }
        return redirect()->to('/arsip')->with('pesan_arsip', 'Arsip berhasil dihapus.');
    }

    public function hapus_multiple()
    {
        $ids = $this->request->getPost('id_arsip');
        if (empty($ids)) {
            return redirect()->to('/arsip')->with('error_arsip', 'Tidak ada arsip yang dipilih.');
        }

        foreach ($ids as $id) {
            $arsip = $this->Model_arsip->find($id);
            if ($arsip) {
                $filePath = FCPATH . $arsip['path_arsip'] . $arsip['file_arsip'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $this->Model_arsip->delete($id);
                $this->Model_arsip_akses->where('id_arsip', $id)->delete();
                $this->logAudit('Hapus Arsip Multiple', 'Arsip dihapus: ' . $arsip['file_arsip']);
            }
        }
        return redirect()->to('/arsip')->with('pesan_arsip', 'Arsip terpilih berhasil dihapus.');
    }

    public function updateArsip($id)
    {
        $arsipLama = $this->Model_arsip->find($id);
        if (!$arsipLama) {
            return redirect()->to('/arsip')->with('error_arsip', 'Arsip tidak ditemukan.');
        }

        $file         = $this->request->getFile('file_arsip');
        $namaDokumen  = trim($this->request->getPost('nama_dokumen'));
        $idKategori   = (int) $this->request->getPost('id_kategori');
        $deskripsi    = $this->request->getPost('deskripsi');
        $klasifikasi  = strtolower($this->request->getPost('klasifikasi'));
        $idDep        = session()->get('level') == 0
            ? (int) $this->request->getPost('id_dep')
            : (int) session()->get('id_dep');

        $data = [
            'id_kategori' => $idKategori,
            'id_dep'      => $idDep,
            'deskripsi'   => $deskripsi,
            'klasifikasi' => $klasifikasi,
            'tgl_update'  => date('Y-m-d H:i:s'),
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = url_title($namaDokumen, '_', true) . '_' . time() . '.' . $file->getExtension();

            $file->move(FCPATH . 'uploads/arsip', $newName);

            if (!empty($arsipLama['file_arsip']) && file_exists(FCPATH . 'uploads/arsip/' . $arsipLama['file_arsip'])) {
                @unlink(FCPATH . 'uploads/arsip/' . $arsipLama['file_arsip']);
            }

            $data['file_arsip'] = $newName;

            $this->logAudit('Update Arsip', "File arsip diperbarui: {$newName}");
        } else {
            $this->logAudit('Update Arsip', "Data arsip diperbarui tanpa file baru: ID {$id}");
        }

        $this->Model_arsip->update($id, $data);

        $this->Model_arsip_akses->where('id_arsip', $id)->delete();

        if ($klasifikasi === 'terbatas') {
            $aksesDep = $this->request->getPost('akses_dep') ?? [];
            foreach ($aksesDep as $depId) {
                $this->Model_arsip_akses->insert([
                    'id_arsip' => $id,
                    'id_dep'   => (int) $depId,
                    'id_user'  => null,
                    'tipe_akses' => 'departemen'
                ]);
            }

            $aksesUserGlobal = $this->request->getPost('akses_user_global') ?? [];
            foreach ($aksesUserGlobal as $userId) {
                $this->Model_arsip_akses->insert([
                    'id_arsip' => $id,
                    'id_user'  => (int) $userId,
                    'id_dep'   => null,
                    'tipe_akses' => 'user'
                ]);
            }
            $this->logAudit('Update Akses Arsip', "Akses diperbarui untuk arsip ID {$id}");
        }

        return redirect()->to('/arsip')->with('pesan_arsip', 'Arsip berhasil diupdate.');
    }

    public function preview($id)
    {
        $arsip = $this->Model_arsip->find($id);
        if (!$arsip) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $filePath = FCPATH . $arsip['path_arsip'] . $arsip['file_arsip'];
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mime = mime_content_type($filePath);

        // === Jika PDF → buka langsung di browser (Chrome/Edge)
        if ($ext === 'pdf') {
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . basename($filePath) . '"')
                ->setBody(file_get_contents($filePath));
        }

        // === Jika docx, xlsx, gambar, dan lainnya → otomatis download
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"')
            ->setBody(file_get_contents($filePath));
    }
}
