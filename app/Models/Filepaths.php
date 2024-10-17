<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filepaths extends Model
{
    use HasFactory;

    protected $table = 'file_paths';
    protected $fillable = [
        'song_id',
        'file_path',
        'file_type',
    ];
}
