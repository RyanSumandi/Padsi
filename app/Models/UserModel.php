<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'firstname', 'lastname', 'role', 'user_name', 'user_email', 'user_password', 'user_created_at'];

    public function getUsers($id = false)
    {
        $query = $this->select('*');

        // ->where('id', $id);
        if ($id === false) {
            return $query->findAll();
        } else {
            return $query->where(['id' => $id])->first();
        }
    }
}
