<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role_detail extends Model
{
    use HasFactory;
    protected $table = 'roles_detail';
    protected $fillable = [
        'id',
        'role_id',
        'role_1',
        'role_2',
        'role_3',
        'role_4',
        'role_5',
        'role_6',
        'role_7',
        'role_8',
        'role_9',
        'role_10',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public static function selectAll($perPage, $filterRole)
    {
        $query = self::with('role');
        if ($filterRole || $filterRole !== null) {
            $query->whereHas('role', function ($q) use ($filterRole) {
                $q->where('role_name', $filterRole); // Sử dụng whereHas để lọc theo vai trò
            });
        }

        $query->orderBy('id', 'asc');
        $RoleList = $query->paginate($perPage);
        return $RoleList;
    }
}
