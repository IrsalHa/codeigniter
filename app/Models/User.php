<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model {
    protected $table = 'admins';
    protected $allowedFields = ['username', 'password'];
}