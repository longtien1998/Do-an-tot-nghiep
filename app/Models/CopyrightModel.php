<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CopyrightModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'copyrights';

    protected $fillable = [
        'id',
        'song_id',
        'publisher_id',
        'license_type',
        'issue_day',
        'expiry_day',
        'usage_rights',
        'terms',
        'license_file',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'issue_day' => 'datetime',
        'expiry_day' => 'datetime',
    ];

    public function publisher()
    {
        return $this->belongsTo(PublishersModel::class);
    }

    public function song()
    {
        return $this->belongsTo(Music::class);
    }
}
