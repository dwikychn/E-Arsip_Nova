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

        // Jika Superadmin → langsung masuk chat admin pertama
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

        // ✅ Admin → redirect dengan default subjek
        $superadminID = $this->bantuanModel->getSuperadminID();
        return redirect()->to('/bantuan/chat/' . $superadminID . '/default');
    }


    public function chat($id_target, $subjek = 'default')
    {
        $idUser = session()->get('id_user');
        $level  = session()->get('level');
        $superadminID = $this->bantuanModel->getSuperadminID();

        // Admin hanya boleh chat superadmin
        if ($level != 0 && $id_target != $superadminID) {
            return redirect()->to('/bantuan/chat/' . $superadminID . '/default');
        }

        // === Sidebar ===
        if ($level == 0) {
            // Superadmin → daftar admin
            $listSidebar = $this->bantuanModel->listAdmin();
            $listSidebar = array_map(function($row) {
                return [
                    'id'    => $row['id_user'],
                    'label' => $row['nama'] ?? $row['nama_user'] ?? $row['username'],
                    'status' => 0 // superadmin tidak butuh status subjek
                ];
            }, $listSidebar);

            // ✅ Chat berdasarkan ID user (untuk superadmin)
            $chat = $this->bantuanModel->listPercakapanByUser($idUser, $id_target);
            $currentSubjek = 'Percakapan Umum';

        } else {
            // ✅ Admin → daftar subjek
            $subs = $this->bantuanModel->listSubjekByUser($idUser);
            $listSidebar = [];

            foreach ($subs as $s) {
                $listSidebar[] = [
                'id'       => urlencode($s['subjek']),
                'label'    => $s['subjek'],
                'is_closed'=> $s['is_closed'] ?? 0
            ];
            }

            // ✅ Tentukan subjek aktif
            if ($subjek == 'default' && !empty($subs)) {
                $currentSubjek = $subs[0]['subjek'];
            } else {
                $currentSubjek = urldecode($subjek);
            }

            // ✅ Ambil chat berdasarkan SUBJEK
            $chat = $this->bantuanModel->listPercakapanBySubjek($currentSubjek, $idUser);
        }

        // Tandai pesan sebagai dibaca
       if ($level == 0) {
            $idTujuan = $id_target; // superadmin -> admin
        } else {
            $idTujuan = $superadminID; // admin -> superadmin
        }

        $data = [
            'title'         => 'Percakapan',
            'chat'          => $chat,
            'currentID'     => $id_target,
            'currentSubjek' => $currentSubjek,
            'listSidebar'   => $listSidebar,
            'idTujuan'      => $idTujuan  // ✅ KIRIM KE VIEW
        ];

        return view('pages/bantuan_chat', $data);
    }




    public function kirim()
    {
        $id_pengirim = session()->get('id_user');
        $id_penerima = $this->request->getPost('id_tujuan');

        // default subjek jika kosong
        $subjek = $this->request->getPost('subjek');
        if (!$subjek || trim($subjek) == '') {
            $subjek = 'Percakapan';
        }

        $this->bantuanModel->insert([
            'id_pengirim' => $id_pengirim,
            'id_penerima' => $id_penerima,
            'subjek'      => $subjek,
            'pesan'       => $this->request->getPost('pesan'),
            'status'      => 'baru',
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect()->back();
    }


public function refreshChat($id_target)
{
    $idUser = session()->get('id_user');
    $chat = $this->bantuanModel->listPercakapanByUser($idUser, $id_target);

    return $this->response
        ->setHeader('Cache-Control', 'no-cache, must-revalidate')
        ->setHeader('Expires', '0')
        ->setBody(view('pages/partial_chat', ['chat' => $chat]));
}


public function refreshChatSubjek($subjek)
{
    $idUser = session()->get('id_user');
    $chat = $this->bantuanModel->listPercakapanBySubjek(urldecode($subjek), $idUser);

    foreach ($chat as $c) {
        echo '<div class="chat-item '.($c['id_pengirim'] == $idUser ? 'me' : 'other').'">';
        echo '<div class="bubble">'.nl2br(esc($c['pesan'])).'<br>';
        echo '<small class="waktu">'.$c['created_at'].'</small>';
        echo '</div></div>';
    }
}
public function buatSubjek()
{
    $idUser = session()->get('id_user');
    $superadminID = $this->bantuanModel->getSuperadminID();
    $subjek = $this->request->getPost('subjek');

    // Cek kalau sudah ada subjek sama
    $cek = $this->bantuanModel->cekSubjek($idUser, $subjek);
    if($cek){
        return redirect()->back()->with('error', 'Subjek sudah ada!');
    }

    // Masukkan pesan dummy untuk membuat thread
    $this->bantuanModel->insert([
        'id_pengirim' => $idUser,
        'id_penerima' => $superadminID,
        'pesan'       => "(Percakapan Baru Dibuat)",
        'subjek'      => $subjek
    ]);

    return redirect()->to("/bantuan/chat/$superadminID/" . urlencode($subjek));
}

}