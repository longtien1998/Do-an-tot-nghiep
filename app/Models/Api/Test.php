<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Singer;
use App\Models\Country;
use App\Models\Category;
use App\Models\Copyright;

class Test extends Model
{
    use HasFactory;

    protected $table = 'songs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'song_name',
        'description',
        'lyrics',
        'singer_id',
        'category_id',
        'country_id',
        'song_image',
        'release_date',
        'listen_count',
        'provider',
        'composer',
        'download_count',
    ];

    public function singer()
    {
        return $this->belongsTo(Singer::class, 'singer_id', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function copyright()
    {
        return $this->belongsTo(Copyright::class, 'id', 'song_id');
    }

    public static function test()
    {
        // Lấy tất cả bài hát kèm theo thông tin của ca sỹ, quốc gia, và thể loại
        $songs = self::limit(10)->get(); //with(['singer', 'country', 'category','copyright'])->

        // Format dữ liệu để hiển thị thông tin mong muốn
        $result = $songs->map(function ($song) {
            return [
                'song_name' => $song->song_name,
                'singer_name' => $song->singer->singer_name ?? null, // Tên ca sỹ
                'country_name' => $song->country->name_country ?? null, // Tên quốc gia
                'category_name' => $song->category->categorie_name ?? null, // Tên thể loại
                'publisher_id' => $song->copyright->publisher->publisher_name ?? null,
                'description' => $song->description,
                'lyrics' => $song->lyrics,
                'release_date' => $song->release_date,
                'listen_count' => $song->listen_count,
            ];
        });
        dd($result);
        return $result;
    }
}
