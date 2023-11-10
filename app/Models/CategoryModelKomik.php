<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModelKomik extends Model
{
    //Nama Table
    protected $table = 'komik_category';
    // Atribut yg digunakan menjadi primary key
    protected $primaryKey = 'komik_category_id';
}
