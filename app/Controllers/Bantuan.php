<?php

namespace App\Controllers;

use App\Models\Model_bantuan;
use CodeIgniter\Controller;

class Bantuan extends BaseController
{
    protected $bantuanModel;
    protected $db;

    public function __construct()
    {
        $this->bantuanModel = new Model_bantuan();
        $this->db = \Config\Database::connect();
    }

    public function index()
{
    $level = session()->get('level');
    $idUser = session()->get('id_user');

    // 🔹 Jika Superadmin → langsung masuk chat admin pertama
    if ($level == 0) {
        $adminList = $this->bantuanModel->listAdmin();
        if (!empty($adminList)) {
            return redirect()->to('/bantuan/chat/' . $adminList[0]['id_user']);
        } else {
            // Jika belum ada admin sama sekali
            return view('pages/bantuan_chat', [
                'title' => 'Percakapan',
                'chat' => [],
                'currentID' => null,
                'currentSubjek' => '',
                'listSidebar' => []
            ]);
        }
    }

    // 🔹 Jika Admin → langsung chat ke Superadmin
    $superadminID = $this->bantuanModel->getSuperadminID();
    return redirect()->to('/bantuan/chat/' . $superadminID);
}


public function chat($id_target)
{
    $idUser = session()->get('id_user');
    $level  = session()->get('level');
    $superadminID = $this->bantuanModel->getSuperadminID();

    // 🚫 Admin tidak boleh chat admin lain → arahkan ke Superadmin
    if ($level != 0 && $id_target != $superadminID) {
        return redirect()->to('/bantuan/chat/' . $superadminID);
    }

    // ✅ Sidebar
    if ($level == 0) {
        // Superadmin → daftar admin
        $listSidebar = $this->bantuanModel->listAdmin();
        $listSidebar = array_map(function($row) {
            return [
                'id'    => $row['id_user'],
                'label' => $row['nama'] ?? $row['nama_user'] ?? $row['username'],
            ];
        }, $listSidebar);

    } else {
        // Admin → daftar subjek percakapan
        $subs = $this->bantuanModel->listSubjekByUser($idUser);
        $listSidebar = [];
        foreach ($subs as $s) {
            $listSidebar[] = [
                'id'    => $superadminID,
                'label' => $s['subjek']
            ];
        }
    }

    // ✅ Tandai sebagai dibaca
    $this->bantuanModel->markAsRead($id_target, $idUser);

    // ✅ Ambil subjek terakhir (untuk lanjut chat)
    $last = $this->db->table('pesan_bantuan')
        ->where("(id_pengirim = $idUser AND id_penerima = $id_target)
              OR (id_pengirim = $id_target AND id_penerima = $idUser)")
        ->orderBy('created_at', 'DESC')
        ->get()->getRow();

    $currentSubjek = $last->subjek ?? ''; // bisa kosong jika chat pertama kali

    if ($level == 0) {
    // Superadmin chat berbasis ID user tujuan
    $chat = $this->bantuanModel->listPercakapan($id_target);
} else {
    // Admin chat berbasis subjek terakhir
    $chat = $this->bantuanModel->listPercakapan($currentSubjek);
}

$data = [
    'title'         => 'Percakapan',
    'chat'          => ($level == 0) 
                        ? $this->bantuanModel->listPercakapan($id_target)   // superadmin = berdasarkan user
                        : $this->bantuanModel->listPercakapan($currentSubjek), // admin = berdasarkan subjek
    'currentID'     => $id_target,
    'currentSubjek' => $currentSubjek,
    'listSidebar'   => $listSidebar
];


    return view('pages/bantuan_chat', $data);
}


    public function kirim()
{
    $subjek = $this->request->getPost('subjek');
    if (!$subjek || trim($subjek) == '') {
        $subjek = 'Percakapan Umum'; // atau buat subjek baru dinamis
    }

    $this->bantuanModel->insert([
        'id_pengirim' => session()->get('id_user'),
        'id_penerima' => $this->request->getPost('id_tujuan'),
        'subjek'      => $subjek,
        'pesan'       => $this->request->getPost('pesan'),
        'status'      => 'baru',
    ]);

    return redirect()->back();
}


    
 public function refreshChat($id_target)
{
    $idUser = session()->get('id_user');

    // Ambil ulang isi chat
    $chat = $this->bantuanModel->listPercakapan($id_target);

    // Tampilkan hanya blok chat (tanpa layout)
    $html = '';
    foreach ($chat as $c) {
        if ($c['id_pengirim'] == $idUser) {
            $html .= '
            <div style="text-align:right;margin:5px;">
                <span style="background:#d1ffd1;padding:5px 10px;border-radius:8px;display:inline-block;">
                    '.esc($c['pesan']).'
                </span>
            </div>';
        } else {
            $html .= '
            <div style="text-align:left;margin:5px;">
                <span style="background:#fff;padding:5px 10px;border-radius:8px;border:1px solid #ccc;display:inline-block;">
                    '.esc($c['pesan']).'
                </span>
            </div>';
        }
    }

    return $html;
}

}
