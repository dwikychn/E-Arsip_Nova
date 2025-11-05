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
                    'id'     => urlencode($s['subjek']),
                    'label'  => $s['subjek'],
                    'status' => $s['status'] ?? 0
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
            $this->bantuanModel->markAsRead($id_target, $idUser);
        } else {
            $this->bantuanModel->markAsReadBySubjek($currentSubjek, $idUser);
        }
        
        $data = [
            'title'         => 'Percakapan',
            'chat'          => $chat,
            'currentID'     => $id_target,
            'currentSubjek' => $currentSubjek,
            'listSidebar'   => $listSidebar
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

        // Ambil ulang percakapan user ↔ target
        $chat = $this->bantuanModel->listPercakapanByUser($idUser, $id_target);

        $html = '';
        foreach ($chat as $c) {
            $self = ($c['id_pengirim'] == $idUser);

            $html .= '
            <div style="text-align:' . ($self ? 'right' : 'left') . '; margin:5px;">
                <span style="
                    background:' . ($self ? '#d1ffd1' : '#fff') . ';
                    padding:6px 12px;
                    border-radius:8px;
                    '. ($self ? '' : 'border:1px solid #ccc;') . '
                    display:inline-block;">
                    '.esc($c['pesan']).'
                </span>
            </div>';
        }

        return $html;
    }

    public function closeSubjek()
{
    $subjek = $this->request->getGet('subjek');
    $idUser = session()->get('id_user');

    $this->db->table('pesan_bantuan')
        ->where('subjek', $subjek)
        ->where('id_pengirim', $idUser)
        ->orWhere('id_penerima', $idUser)
        ->update(['is_closed' => 1]);

    return redirect()->back();
}

    public function refreshChatSubjek($subjek)
{
    $idUser = session()->get('id_user');

    $chat = $this->bantuanModel->listPercakapanBySubjek(urldecode($subjek), $idUser);

    $html = '';
    foreach ($chat as $c) {
        $self = ($c['id_pengirim'] == $idUser);

        $html .= '
        <div style="text-align:' . ($self ? 'right' : 'left') . '; margin:5px;">
            <span style="
                background:' . ($self ? '#d1ffd1' : '#fff') . ';
                padding:6px 12px;
                border-radius:8px;
                '. ($self ? '' : 'border:1px solid #ccc;') . '
                display:inline-block;">
                '.esc($c['pesan']).'
            </span>
        </div>';
    }

    return $html;
}

}