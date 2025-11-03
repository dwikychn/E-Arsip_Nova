<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bantuan extends Model
{
    protected $table = 'pesan_bantuan';
    protected $primaryKey = 'id_pesan';
    protected $allowedFields = ['id_pengirim', 'id_penerima', 'subjek', 'pesan', 'status', 'created_at'];

    public function listAdmin()
    {
        return $this->db->table('tbl_user')
            ->where('level', 1)
            ->get()->getResultArray();
    }

   public function listPercakapan($targetOrSubjek)
{
    $id_login = (int) session()->get('id_user');
    $superadminID = $this->getSuperadminID();

    // Jika param numeric -> anggap itu id_target (dipanggil dari redirect langsung ke user)
    if (is_numeric($targetOrSubjek)) {
        $id_target = (int) $targetOrSubjek;

        // Gunakan query builder agar binding otomatis dan aman
        $builder = $this->db->table('pesan_bantuan');

        $builder->groupStart()
                    ->where('id_pengirim', $id_login)
                    ->where('id_penerima', $id_target)
                ->groupEnd()
                ->orGroupStart()
                    ->where('id_pengirim', $id_target)
                    ->where('id_penerima', $id_login)
                ->groupEnd()
                ->orderBy('created_at', 'ASC');

        return $builder->get()->getResultArray();
    }

    // Jika bukan numeric -> anggap itu subjek percakapan (dipanggil ketika admin memilih subjek)
    $subjek = $targetOrSubjek;

    // Ambil semua pesan dengan subjek itu yang melibatkan user saat ini
    $builder = $this->db->table('pesan_bantuan');
    $builder->where('subjek', $subjek)
            ->groupStart()
                ->where('id_pengirim', $id_login)
                ->orWhere('id_pengirim', $superadminID)
            ->groupEnd()
            ->groupStart()
                ->where('id_penerima', $id_login)
                ->orWhere('id_penerima', $superadminID)
            ->groupEnd()
            ->orderBy('created_at', 'ASC');

    return $builder->get()->getResultArray();
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

    // ✅ Daftar subjek untuk superadmin ataupun admin
    public function listSubjekByUser($id_user)
    {
        return $this->select('subjek, MAX(created_at) as terakhir')
                    ->where('id_pengirim', $id_user)
                    ->orWhere('id_penerima', $id_user)
                    ->groupBy('subjek')
                    ->orderBy('terakhir', 'DESC')
                    ->get()->getResultArray();
    }
}
