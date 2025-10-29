<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bantuan extends Model
{
    protected $table = 'pesan_bantuan';
    protected $primaryKey = 'id_bantuan';
    protected $allowedFields = ['id_pengirim', 'pesan', 'created_at'];
}
