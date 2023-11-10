<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    // Nama Tabel
    protected $table = 'layanan';
    // Atribut yang digunakan menjadi primary key
    protected $primaryKey = 'Id_Layanan';
    // Atribut untuk menyimpan created_at and updated_at
    protected $useTimestamps = true;
    protected $allowedFields = [
        'Bentuk_Layanan', 'Reservasi_Layanan'
    ];

    protected $useSoftDeletes = true;
}
