<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = ['username', 'email', 'topic', 'message','status'];

    public static function getAll($perPage, $filterCreateStart, $filterCreateEnd, $filterStatus)
    {
        $query = self::query();
        if ($filterCreateStart) {
            $query->where('created_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('created_at', '<=', $filterCreateEnd);
        }
        if ($filterStatus) {
            $query->where('status', '=', $filterStatus);
        }
        return $query->orderByDesc('id')->paginate($perPage);
    }
}
