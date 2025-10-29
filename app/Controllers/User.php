<?php

namespace App\Controllers;

use App\Models\Model_user;
use App\Models\Model_departemen;
use App\Traits\AuditTrailTrait;

class User extends BaseController
{
    use AuditTrailTrait;

    protected $userModel;
    protected $depModel;

    public function __construct()
    {
        $this->userModel = new Model_user();
        $this->depModel = new Model_departemen();
        helper(['form', 'url']);
    }

    public function index()
    {
        $session = session();
        $level = $session->get('level');
        $id_dep = $session->get('id_dep');

        if ($level == 0) {
            $users = $this->userModel->all_data();
        } else {
            $users = $this->userModel->where('tbl_user.id_dep', $id_dep)
                ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
                ->select('tbl_user.*, tbl_dep.nama_dep')
                ->findAll();
        }

        $data = [
            'title'      => 'Manajemen User',
            'users'      => $users,
            'departemen' => $this->depModel->findAll(),
        ];
        return view('pages/user', $data);
    }


    public function store()
    {
        $validationRules = [
            'nama_user' => 'required|min_length[3]',
            'username'  => 'required|is_unique[tbl_user.username]',
            'password'  => 'required|min_length[5]',
            'level'     => 'required'
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('error_user', $this->validator->getErrors());
        }

        $this->userModel->save([
            'nama_user' => $this->request->getPost('nama_user'),
            'username'  => $this->request->getPost('username'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'level'     => $this->request->getPost('level'),
            'id_dep'    => $this->request->getPost('id_dep'),
        ]);

        $this->logAudit('Tambah User', 'User baru ditambahkan: ' . $this->request->getPost('username'));
        return redirect()->to('/user')->with('pesan_user', 'User berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if ($user) {
            $currentUserId = session()->get('id_user');

            if ($id == $currentUserId) {
                return redirect()->to('/user')
                    ->with('error_user', 'Anda tidak bisa menghapus akun Anda sendiri!');
            }

            $this->userModel->delete($id);

            $this->logAudit('Hapus User', 'User dihapus: ' . $user['username']);

            return redirect()->to('/user')->with('pesan_user', 'User berhasil dihapus');
        }

        return redirect()->to('/user')->with('error_user', 'User tidak ditemukan!');
    }

    public function update($id)
    {
        $sessionLevel = session()->get('level');

        $userLama = $this->userModel->find($id);
        if (!$userLama) {
            return redirect()->to('/user')->with('error_user', ['User Tidak Ditemukan']);
        }

        $nama     = $this->request->getPost('nama_user');
        $username = $this->request->getPost('username');
        $level    = $this->request->getPost('level');
        $id_dep   = $this->request->getPost('id_dep');
        $password = $this->request->getPost('password');

        if ($username !== $userLama['username']) {
            $isUnique = $this->userModel->where('username', $username)->first();
            if ($isUnique) {
                return redirect()->back()
                    ->withInput()
                    ->with('error_user', ['Username sudah dipakai user lain']);
            }
        }

        $data = [
            'nama_user' => $nama,
            'username'  => $username,
            'password'  => !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $userLama['password']
        ];

        if ($sessionLevel == 0) {
            $data['id_dep'] = $id_dep;
            $data['level']  = $level;
        }

        if ($sessionLevel == 1) {
            $data['id_dep'] = $userLama['id_dep'];
        }

        $this->userModel->update($id, $data);

        $this->logAudit('Update User', 'User diperbarui: ' . $username);

        return redirect()->to('/user')->with('pesan_user', 'User berhasil diperbarui.');
    }


    public function updateProfile($id)
    {
        $userLama = $this->userModel->find($id);

        if (!$userLama || $id != session()->get('id_user')) {
            return redirect()->to('/')->with('error', ['Akses tidak diizinkan']);
        }

        $nama     = $this->request->getPost('nama_user');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

        $idDep   = session()->get('id_dep');
        $namaDep = session()->get('nama_dep');

        // Buat username
        $namaDepan  = strtolower(explode(' ', trim($nama))[0]);
        $depSingkat = strtolower(strtok($namaDep, ' '));
        $depSingkat = preg_replace('/[^a-z0-9]/', '', $depSingkat);
        $username   = $namaDepan . '_' . $depSingkat;

        // Cek duplikat username
        if ($username !== $userLama['username']) {
            $isUnique = $this->userModel->where('username', $username)->first();
            if ($isUnique) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', ['Username sudah dipakai user lain']);
            }
        }

        // Password
        if (!empty($password)) {
            if ($password !== $confirm) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', ['Konfirmasi password tidak sesuai']);
            }
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashPassword = $userLama['password'];
        }

        // Data update
        $data = [
            'nama_user' => $nama,
            'username'  => $username,
            'password'  => $hashPassword,
            'id_dep'    => $idDep,
        ];

        $this->userModel->update($id, $data);

        // Update session
        session()->set('nama_user', $nama);
        session()->set('username', $username);
        session()->set('id_dep', $idDep);
        session()->set('nama_dep', $namaDep);

        $this->logAudit('Update Profile', 'User memperbarui profilnya sendiri: ' . $username);

        return redirect()->back()->with('pesan', 'Profil berhasil diperbarui.');
    }

    public function byDepartemen($id_dep)
    {
        $users = $this->userModel
            ->select('id_user, nama_user')
            ->where('id_dep', $id_dep)
            ->orderBy('nama_user', 'ASC')
            ->findAll();

        return $this->response->setJSON($users);
    }
}
