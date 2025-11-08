<?php

namespace App\Controllers;

use App\Models\Model_bantuan;

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

        if ($level == 0) {
            $adminList = $this->bantuanModel->listAdmin();
            if (!empty($adminList)) {
                return redirect()->to('/bantuan/chat/' . $adminList[0]['id_user']);
            }
        }

        $superadminID = $this->bantuanModel->getSuperadminID();
        return redirect()->to('/bantuan/chat/' . $superadminID);
    }

    public function chat($id_target)
{
    $idUser = session()->get('id_user');
    $level  = session()->get('level');

    // SUPERADMIN → Chat dengan daftar admin
    if ($level == 0) {
        $adminList = $this->bantuanModel->listAdmin();

        $listSidebar = [];
        foreach ($adminList as $a) {
            $listSidebar[] = [
                'id'    => $a['id_user'],    // id admin
                'label' => $a['nama'],       // nama admin
            ];
        }

        $idTujuan = $id_target;
        $namaTujuan = $this->bantuanModel->getName($idTujuan);
    }

    // ADMIN → Selalu chat ke superadmin
    if ($level == 1) {
        $idTujuan = 1; // Superadmin
        $listSidebar = [
            [
                'id'    => 1,
                'label' => "Superadmin"
            ]
        ];
        $namaTujuan = "Superadmin";
    }

    $chat = $this->bantuanModel->getChat($idUser, $idTujuan);

    return view('pages/bantuan_chat', [
        'listSidebar' => $listSidebar,
        'chat'        => $chat,
        'idTujuan'    => $idTujuan,
        'namaTujuan'  => $namaTujuan,
    ]);
}


    public function kirim()
    {
        $id_pengirim = session()->get('id_user');
        $id_penerima = $this->request->getPost('id_tujuan');
        $pesan = $this->request->getPost('pesan');

        $this->bantuanModel->save([
            'id_pengirim' => $id_pengirim,
            'id_penerima' => $id_penerima,
            'subjek'      => '',
            'pesan'       => $pesan,
            'status'      => 1,
        ]);

        return redirect()->back();
    }

    public function refreshChat($id_target)
    {
        $idUser = session()->get('id_user');
        $chat = $this->bantuanModel->getChat($idUser, $id_target);

        return view('partial_chat', ['chat' => $chat]);
    }
}
