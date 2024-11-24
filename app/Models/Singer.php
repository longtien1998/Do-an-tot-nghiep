<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Singer extends Model
{
    use HasFactory, SoftDeletes;
    public function albums()
    {
        return $this->hasMany(Album::class, 'singer_id');
    }
}
