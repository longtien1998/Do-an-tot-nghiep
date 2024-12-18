<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'name',
        'slug',
    ];


    public function permissions()
    {
        return $this->hasMany(Permission::class, 'id','module_id');
    }


    public static function index($perPage, $filterCreateStart, $filterCreateEnd)
    {
        $query = self::query();
        if ($filterCreateStart) {
            $query->where('created_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('created_at', '<=', $filterCreateEnd);
        }
        return $query->orderByDesc('id')->paginate($perPage);
    }
}
