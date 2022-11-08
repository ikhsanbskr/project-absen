<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKaryawan extends Model
{
    protected $table      = 'karyawan';
    protected $primaryKey = 'nik';
    protected $allowedFields = ['nama', 'nik', 'jabatan'];
}
