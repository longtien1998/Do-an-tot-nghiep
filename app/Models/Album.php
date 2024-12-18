<?php

namespace App\Models;

use App\Models\Api\FavoriteAlbum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'albums';

    protected $fillable = [
        'album_name',
        'singer_id',
        'image',
        'listen_count',
        'creation_date',
    ];

    public function singer()
    {
        return $this->belongsTo(Singer::class, 'singer_id');
    }

    public function songs()
    {
        return $this->belongsToMany(Music::class, 'album_song', 'album_id', 'song_id');
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteAlbum::class, 'album_id');
    }
    public function albumsong(){
        return $this->hasMany(AlbumSongs::class, 'album_id');
    }
    public static function up_file_album($file, $userName)
    {
        try {
            $userNameSlug = Str::slug($userName, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = time() . '_' . $userNameSlug . '.' . strtolower($extension); // Đặt tên file

            // Đường dẫn lưu trữ trên S3
            $path = 'album/' . $userNameSlug;

            // Upload file lên S3 với tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_user = Storage::disk('s3')->url($path . '/' . $fileName); // Chú ý: cần thêm $fileName vào đây

            return $url_user;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }



    public static function selectAll($perPage, $filterSinger, $filterCreate)
    {
        $query = self::query();

         // Áp dụng bộ lọc theo ca sĩ
        if ($filterSinger) {
            $query->where('singer_id', $filterSinger);
        }

          // Áp dụng bộ lọc theo ngày tạo
        if ($filterCreate) {
            $query->whereDate('creation_date', $filterCreate);
        }

        return $query->orderByDesc('id')->paginate($perPage);
    }


    public static function updateAlbum($id, $data)
    {
        $currentAlbum = DB::table('albums')->where('id', $id)->first();

        if (!empty($data['image'])) {
            if ($currentAlbum->image && Storage::disk('s3')->exists(parse_url($currentAlbum->image, PHP_URL_PATH))) {
                Storage::disk('s3')->delete(parse_url($currentAlbum->image, PHP_URL_PATH));
            }
        } else {
            $data['image'] = $currentAlbum->image;
        }

        // Cập nhật vào database
        return DB::table('albums')->where('id', $id)->update([
            'album_name' => $data['album_name'],
            'singer_id' => $data['singer_id'],
            'image' => $data['image'],
        ]);
    }


}
