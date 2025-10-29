<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditModel extends Model
{
    protected $table = 'audit'; // ganti dengan nama tabel audit trail Anda
    protected $primaryKey = 'id'; // ganti jika primary key berbeda
    protected $allowedFields = [
        'username', 'action', 'description', 'ip_address', 'created_at'
    ];
    public $timestamps = false; // set true jika pakai timestamps otomatis
}
