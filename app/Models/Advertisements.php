<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Advertisements extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ads';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'id',
        'ads_name',
        'ads_description',
        'file_path',
    ];
    public static function createAds($data)
    {
        return DB::table('ads')->insert([
            'ads_name' => $data['ads_name'],
            'ads_description' => $data['ads_description'],
            'file_path' => $data['file_path'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public static function selectAds(){
        return DB::table('ads')
        ->select('id','ads_name','ads_description','file_path')
        ->whereNull('deleted_at')
        ->get();
    }
    public static function updateAds($id, $data)
    {
        return DB::table('ads')->where('id', $id)->update([
            'ads_name' => $data['ads_name'],
            'ads_description' => $data['ads_description'],
            'file_path' => $data['file_path'],
            'updated_at' => now(),
        ]);
    }
    public static function search_ads($search)
    {
        $ads = DB::table('ads')
            ->where('ads_name', 'LIKE', '%' . $search . '%')
            ->select('ads.*')
            ->get();
        return $ads;
    }
}
