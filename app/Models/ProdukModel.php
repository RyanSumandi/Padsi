<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'Id_produk';
    protected $allowedFields = ['Id_Produk','Id_Pembelian', 'Nama_Produk', 'Stok_Produk', 'Harga_Produk'];
    protected $useTimestamps = true;
    protected $useSoftDeletes  =  true;
}
