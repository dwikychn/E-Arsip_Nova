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
    // Jika Superadmin
    if (session()->get('level') == 0) {

        $adminList = $this->bantuanModel->listAdmin();

        // Tambahkan jumlah pesan belum dibaca ke setiap admin
        foreach ($adminList as &$row) {
            $row['unread'] = $this->bantuanModel->countUnread($row['id_user']);
        }

        $data = [
            'title'     => 'Kotak Pesan',
            'adminList' => $adminList
        ];
        return view('pages/adminbantuan_list', $data);
    }

    // Jika admin → langsung ke chat superadmin
    $superadminID = $this->bantuanModel->getSuperadminID();
    return redirect()->to('bantuan/chat/' . $superadminID);
}

public function chat($id_target)
{
    $idUser = session()->get('id_user');
    $level  = session()->get('level');

    // Ambil superadmin
    $superadmin = $this->db->table('tbl_user')->where('level', 0)->get()->getRow();
    $superadminID = $superadmin->id_user;

    // Jika admin mencoba membuka chat dengan admin lain → blokir ke superadmin
    if ($level != 0 && $id_target != $superadminID) {
        return redirect()->to('/bantuan/chat/' . $superadminID);
    }

    // ✅ Ubah semua pesan dari target → ke user ini menjadi dibaca
    $this->db->table('pesan_bantuan')
        ->where('id_pengirim', $id_target)
        ->where('id_penerima', $idUser)
        ->where('status', 'baru')
        ->update(['status' => 'dibaca']);

    $data = [
        'title' => 'Percakapan',
        'chat'  => $this->bantuanModel->listPercakapan($id_target),
        'id_admin' => $id_target
    ];

    // ✅ Ini yang benar (tampilkan halaman chat, bukan admin list)
    return view('pages/bantuan_chat', $data);
}


    public function kirim()
    {
        $this->bantuanModel->insert([
            'id_pengirim'  => session()->get('id_user'),
            'id_penerima'  => $this->request->getPost('id_tujuan'),
            'pesan'        => $this->request->getPost('pesan'),
            'status'       => 'baru'
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
