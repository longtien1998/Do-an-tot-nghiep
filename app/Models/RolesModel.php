<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'id',
        'role_name',
        'user_id',
        'role_type',
        'created_at',
        'updated_at'
    ];
}
