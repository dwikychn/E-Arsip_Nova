<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bantuan extends Model
{
    protected $table = 'pesan_bantuan';
    protected $primaryKey = 'id_pesan';
    protected $allowedFields = ['id_pengirim', 'id_penerima', 'pesan', 'created_at', 'status'];

    // Ambil daftar admin untuk superadmin
    public function listAdmin()
    {
        return $this->db->table('tbl_user')
            ->where('level', 1)
            ->get()->getResultArray();
    }

    // Ambil ID superadmin
    public function getSuperadminID()
    {
        return $this->db->table('tbl_user')
            ->where('level', 0)
            ->get()
            ->getRow('id_user');
    }


    // ✅ Kirim pesan tanpa subjek
    public function sendChat($from, $to, $pesan)
    {
        return $this->insert([
            'id_pengirim' => $from,
            'id_penerima' => $to,
            'pesan'       => $pesan,
            'created_at'  => date('Y-m-d H:i:s'),
            'status'      => 'baru'
        ]);
    }

    // ✅ Tanda baca jika dibuka
    public function markAsRead($sender_id, $receiver_id)
    {
        return $this->db->table('pesan_bantuan')
            ->where('id_pengirim', $sender_id)
            ->where('id_penerima', $receiver_id)
            ->where('status', 'baru')
            ->update(['status' => 'dibaca']);
    }
public function getUserById($id)
{
    return $this->db->table('tbl_user')
        ->where('id_user', $id)
        ->get()
        ->getRowArray();
}
public function getChat($idUser, $idTarget)
{
    return $this->db->table('pesan_bantuan')
        ->where("(id_pengirim = $idUser AND id_penerima = $idTarget)
              OR (id_pengirim = $idTarget AND id_penerima = $idUser)")
        ->orderBy('id_pesan', 'ASC')
        ->get()
        ->getResultArray();
}


}
