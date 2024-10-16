<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'image',
        'gerder',
        'birthday',
        'roles',
        'users_type',
        'expiry_date',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
