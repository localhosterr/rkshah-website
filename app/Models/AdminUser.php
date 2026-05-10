<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Authenticatable
{
    protected $table    = 'admin_users';
    protected $fillable = ['name', 'email', 'password', 'is_active', 'last_login_at'];
    protected $hidden   = ['password'];
    protected $casts    = ['is_active' => 'boolean', 'last_login_at' => 'datetime'];

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }
}
