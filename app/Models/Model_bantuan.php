<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bantuan extends Model
{
    protected $table = 'pesan_bantuan';
    protected $primaryKey = 'id_pesan';
    protected $allowedFields = ['id_pengirim', 'id_penerima', 'pesan', 'status', 'created_at'];

    public function listAdmin()
    {
        return $this->db->table('tbl_user')
            ->where('level', 1)
            ->get()->getResultArray();
    }

    public function listPercakapan($id_admin)
    {
        $id_login = session()->get('id_user'); // user yang sedang login

        return $this->where("(id_pengirim = $id_login AND id_penerima = $id_admin)
                            OR (id_pengirim = $id_admin AND id_penerima = $id_login)")
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function countUnread($user_id)
    {
        return $this->db->table('pesan_bantuan')
            ->where('id_pengirim', $user_id)
            ->where('id_penerima', $this->getSuperadminID())
            ->where('status', 'baru')
            ->countAllResults();
    }

    public function getSuperadminID()
    {
        return $this->db->table('tbl_user')
            ->where('level', 0)
            ->get()
            ->getRow('id_user');
    }

    public function markAsRead($sender_id, $receiver_id)
    {
        return $this->db->table('pesan_bantuan')
            ->where('id_pengirim', $sender_id)
            ->where('id_penerima', $receiver_id)
            ->where('status', 'baru')
            ->update(['status' => 'dibaca']);
    }
}
