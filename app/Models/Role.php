<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
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

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function role_detail(){
        return $this->belongsTo(Role_detail::class,'id', 'role_id');
    }
}
