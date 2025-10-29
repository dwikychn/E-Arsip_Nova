<?php

namespace App\Controllers;

class Bantuan extends BaseController
{
        public function index()
    {
        return view('pages/adminbantuan_form');
    }

    public function kirim()
    {
        $db = \Config\Database::connect();
        $db->table('pesan_bantuan')->insert([
            'id_pengirim' => session()->get('id_user'),
            'pesan' => $this->request->getPost('pesan'),
        ]);

        session()->setFlashdata('success', 'Pesan telah dikirim!');
        return redirect()->to('/bantuan');
    }

}
