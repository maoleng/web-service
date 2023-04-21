<?php

namespace App\Models;

use Libraries\database_drivers\Model;

class User extends Model
{

    public string $table = 'users';

    protected array $fillable = [
        'name', 'email', 'password', 'is_admin', 'created_at',
    ];

    protected array $not_string_attributes = [
        'is_admin',
    ];

    public function verify($password): bool
    {
        return password_verify($password, $this->password);
    }
}