<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'banners';
    protected $primaryKey = 'id';
    protected $fillable = [
        'banner_name',
        'banner_url',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function up_banner($file, $Pulisher)
    {
        try {
            $PulisherSlug = Str::slug($Pulisher, '_');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $PulisherSlug . '.' . strtolower($extension);

            
            $path = 'Banner/';

            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            $url_logo = Storage::disk('s3')->url($path . $fileName);

            return $url_logo;
        } catch (\Exception $e) {

            dd($e->getMessage());
        }
    }

    public static function getImage(){

        $files = Storage::disk('s3')->files('Banner');

        $usedImages = self::pluck('banner_url')->toArray();

        $images = array_map(function ($file) use ($usedImages) {
            return [
                'path'    => $file,
                'url'     => Storage::disk('s3')->url($file),
                'in_use'  => in_array(Storage::disk('s3')->url($file), $usedImages), // Kiểm tra ảnh có đang dùng
            ];
        }, $files);
        return $images;
    }

    public static function search($query)
    {
        return self::where('banner_name', 'LIKE', '%' . $query . '%')
            ->orWhere('banner_name', 'LIKE', '%' . $query . '%')
            ->paginate(30);
    }

    public static function getAll($perPage, $filterCreateStart, $filterCreateEnd)
    {
        $query = self::whereNull('deleted_at');
        if ($filterCreateStart) {
            $query->where('created_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('created_at', '<=', $filterCreateEnd);
        }
        return $query->paginate($perPage);
    }

    public static function getAlltrash($perPage, $filterCreateStart, $filterCreateEnd)
    {
        $query = self::onlyTrashed();
        if ($filterCreateStart) {
            $query->where('deleted_at', '>=', $filterCreateStart);
        }

        if ($filterCreateEnd) {
            $query->where('deleted_at', '<=', $filterCreateEnd);
        }
        return $query->paginate($perPage);
    }

    public static function search_trash_banner($searchQuery)
    {
        return self::onlyTrashed()
            ->where(function ($query) use ($searchQuery) {
                $query->where('banner_name', 'LIKE', '%' . $query . '%')
                ->orWhere('banner_name', 'LIKE', '%' . $query . '%');
            })
            ->paginate(30);
    }
}
