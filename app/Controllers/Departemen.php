<?php

namespace App\Controllers;


use App\Models\Model_departemen;
use App\Traits\AuditTrailTrait;

class Departemen extends BaseController
{
    use AuditTrailTrait;
    protected $depModel;

    public function __construct()
    {

        $this->depModel = new Model_departemen();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Departemen',
            'departemen' => $this->depModel->findAll(),
        ];
        return view('pages/departemen', $data);
    }

    public function addDep()
    {
        $namaDepartemen = $this->request->getPost('nama_dep');
        $cek = $this->depModel->where('nama_dep', $namaDepartemen)->first();
        if ($cek) {
            session()->setFlashdata('error_dep', ['Nama Departemen sudah ada!']);
            $this->logAudit('Gagal Tambah Departemen', 'Nama departemen sudah ada: ' . $namaDepartemen);
        } else {
            $this->depModel->save(['nama_dep' => $namaDepartemen]);
            session()->setFlashdata('pesan_dep', 'Data berhasil ditambahkan');
            $this->logAudit('Tambah Departemen', 'Departemen baru ditambahkan: ' . $namaDepartemen);
        }
        return redirect()->to(base_url('departemen'));
    }

    public function editDep($id)
    {
        $namaDepBaru = $this->request->getPost('nama_dep');
        $depLama     = $this->depModel->find($id);

        if (!$depLama) {
            $this->logAudit('Gagal Edit Departemen', 'Departemen tidak ditemukan, ID: ' . $id);
            return redirect()->to(base_url('departemen'))
                ->with('error_dep', ['Departemen tidak ditemukan']);
        }
        if ($namaDepBaru !== $depLama['nama_dep']) {
            $cek = $this->depModel->where('nama_dep', $namaDepBaru)->first();
            if ($cek) {
                return redirect()->to(base_url('departemen'))
                    ->with('error_dep', ['Nama Departemen sudah ada!']);
            }
        }
        $this->depModel->update($id, ['nama_dep' => $namaDepBaru]);
        $this->logAudit('Edit Departemen', 'Departemen diupdate: ' . $namaDepBaru . ' (ID: ' . $id . ')');
        return redirect()->to(base_url('departemen'))
            ->with('pesan_dep', 'Departemen berhasil diupdate');
    }

    public function deleteDep($id)
    {
        $dep = $this->depModel->find($id);
        $this->depModel->delete($id);
        $this->logAudit('Hapus Departemen', 'Departemen dihapus: ' . ($dep ? $dep['nama_dep'] : 'ID ' . $id));
        return redirect()->to('/departemen')->with('pesan_dep', 'Departemen Berhasil Dihapus');
    }

    public function getAll()
    {
        return $this->response->setJSON($this->depModel->findAll());
    }
}
