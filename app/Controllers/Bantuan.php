<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class Bantuan extends BaseController
{
    public function index()
    {
        $db = Database::connect();

        $currentUserId = session()->get('id_user');
        $currentLevel  = session()->get('level'); // 0 = superadmin

        if ($currentLevel == 0) {
            // Superadmin → lihat semua pesan
            $pesan = $db->table('pesan_bantuan')
                ->select('pesan_bantuan.*, user.nama_user AS nama_pengirim')
                ->join('user', 'user.id_user = pesan_bantuan.id_pengirim')
                ->orderBy('id_pesan', 'DESC')
                ->get()->getResultArray();
        } else {
            // Admin → hanya pesan yang dia kirim
            $pesan = $db->table('pesan_bantuan')
                ->select('pesan_bantuan.*, user.nama_user AS nama_pengirim')
                ->join('user', 'user.id_user = pesan_bantuan.id_pengirim')
                ->where('id_pengirim', $currentUserId)
                ->orderBy('id_pesan', 'DESC')
                ->get()->getResultArray();
        }

        return view('pages/adminbantuan_list', [
            'title' => 'Bantuan',
            'pesan' => $pesan
        ]);
    }

    public function kirim()
    {
        $db = Database::connect();
        $db->table('pesan_bantuan')->insert([
            'id_pengirim' => session()->get('id_user'),
            'pesan'       => $this->request->getPost('pesan'),
        ]);

        session()->setFlashdata('success', 'Pesan telah dikirim!');
        return redirect()->to('/bantuan');
    }
}
