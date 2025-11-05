<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bantuan extends Model
{
    protected $table = 'pesan_bantuan';
    protected $primaryKey = 'id_pesan';
    protected $allowedFields = ['id_pengirim', 'id_penerima', 'subjek', 'pesan', 'status', 'created_at', 'is_closed'];


    public function listAdmin()
    {
        return $this->db->table('tbl_user')
            ->where('level', 1)
            ->get()->getResultArray();
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

    // ✅ FUNGSI BARU: Query khusus untuk superadmin (berdasarkan ID user)
    public function listPercakapanByUser($idLogin, $idTarget)
    {
        return $this->db->table('pesan_bantuan')
            ->groupStart()
                ->where('id_pengirim', $idLogin)
                ->where('id_penerima', $idTarget)
            ->groupEnd()
            ->orGroupStart()
                ->where('id_pengirim', $idTarget)
                ->where('id_penerima', $idLogin)
            ->groupEnd()
            ->orderBy('created_at', 'ASC')
            ->get()->getResultArray();
    }

    public function markAsRead($sender_id, $receiver_id)
    {
        return $this->db->table('pesan_bantuan')
            ->where('id_pengirim', $sender_id)
            ->where('id_penerima', $receiver_id)
            ->where('status', 'baru')
            ->update(['status' => 'dibaca']);
    }

    // ✅ DIPERBAIKI: Daftar subjek untuk admin dengan filter subjek tidak kosong
    public function listSubjekByUser($id_user)
{
    return $this->db->table('pesan_bantuan')
        ->select('subjek, MAX(created_at) as terakhir, MAX(is_closed) as is_closed')
        ->groupStart()
            ->where('id_pengirim', $id_user)
            ->orWhere('id_penerima', $id_user)
        ->groupEnd()
        ->where('subjek !=', '')
        ->groupBy('subjek')
        ->orderBy('terakhir', 'DESC')
        ->get()->getResultArray();
}


    public function listPercakapanBySubjek($subjek, $idUser)
    {
        $superadminID = $this->getSuperadminID();

        // ✅ QUERY DIPERBAIKI: Ambil semua pesan dengan subjek tertentu
        // yang melibatkan admin dan superadmin
        return $this->db->table('pesan_bantuan')
            ->where('subjek', $subjek)
            ->groupStart()
                ->groupStart()
                    ->where('id_pengirim', $idUser)
                    ->where('id_penerima', $superadminID)
                ->groupEnd()
                ->orGroupStart()
                    ->where('id_pengirim', $superadminID)
                    ->where('id_penerima', $idUser)
                ->groupEnd()
            ->groupEnd()
            ->orderBy('created_at', 'ASC')
            ->get()->getResultArray();
    }

    public function markAsReadBySubjek($subjek, $idUser)
    {
        return $this->db->table('pesan_bantuan')
            ->where('subjek', $subjek)
            ->where('id_penerima', $idUser)
            ->where('status', 'baru')
            ->update(['status' => 'dibaca']);
    }
    public function setClosed($subjek, $idUser)
    {
        return $this->db->table($this->table)
            ->where('subjek', $subjek)
            ->groupStart()
                ->where('id_pengirim', $idUser)
                ->orWhere('id_penerima', $idUser)
            ->groupEnd()
            ->update(['is_closed' => 1]);
    }
public function cekSubjek($idUser, $subjek)
{
    return $this->where('id_pengirim', $idUser)
                ->where('subjek', $subjek)
                ->first();
}

}