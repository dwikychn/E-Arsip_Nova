<?php

namespace App\Controllers;

use App\Models\Model_auth;

class Auth extends BaseController
{
    protected $Model_auth;
    public function __construct()
    {
        helper('form');
        $this->Model_auth = new Model_auth();
    }
    public function index()
    {
        $data = array(
            'title' => 'Login',
        );
        return view('pages/login', $data);
    }

    public function login()
    {
        if ($this->validate([
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                ],
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                ],
            ],
        ])) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $cek = $this->Model_auth->login($username, $password);

            if ($cek) {
                session()->set([
                    'log'       => true,
                    'id_user'   => $cek['id_user'],
                    'id_dep'    => $cek['id_dep'],
                    'nama_dep'  => $cek['nama_dep'],
                    'nama_user' => $cek['nama_user'],
                    'username'  => $cek['username'],
                    'level'     => $cek['level'],
                ]);

                return redirect()->to(base_url('home'));
            } else {
                session()->setFlashdata('error', 'Login Gagal! Username Atau Password Salah');
                return redirect()->to(base_url('auth/index'));
            }
        } else {
            session()->setFlashdata('error', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('auth/index'));
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Anda Telah Logout.');
        return redirect()->to(base_url('auth'));
    }
}
