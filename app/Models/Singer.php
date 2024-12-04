<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Singer extends Authenticatable
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'singer_name',
        'singer_image',
        'singer_birth_date',
        'singer_gender',
        'singer_biography',
        'singer_country',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function albums()
    {
        return $this->hasMany(Album::class, 'singer_id');

    }
    public function favouritesinger(){

        return $this->belongsToMany(User::class, 'favorite_singer', 'singer_id', 'user_id');
    }
    public static function show($id)
    {
        $singer = Singer::find($id);

        return $singer;
    }


    /**
     * Method to upload singer image to S3
     */
    public static function up_image($file, $singername)
    {
        try {
            $singernameSlug = Str::slug($singername, '_'); // Tạo slug cho tên ca sĩ
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = time() . '_' . $singernameSlug . '.' . strtolower($extension); // Đặt tên file

            // Đường dẫn lưu trữ trên S3
            $path = 'singers/' . $singernameSlug;

            // Upload file lên S3 với tên tùy chỉnh
            Storage::disk('s3')->putFileAs($path, $file, $fileName);
            Storage::disk('s3')->setVisibility($path . $fileName, 'public');

            // Lấy URL công khai của file đã upload
            $url_singer_image = Storage::disk('s3')->url($path . '/' . $fileName); // Chú ý: cần thêm $fileName vào đây

            return $url_singer_image;
        } catch (\Exception $e) {
            // Hiển thị lỗi nếu có
            dd($e->getMessage());
        }
    }

    /**
     * Method to get singers with filters
     */
    public static function selectSingers($perPage, $filterGender, $filterCountry, $filterCreate)
    {
        $query = DB::table('singers')
            ->select(
                'singers.*'
            )
            ->whereNull('deleted_at');

        if ($filterGender) {
            $query->where('singers.singer_gender', $filterGender);
        }
        if ($filterCountry) {
            $query->where('singers.singer_country', $filterCountry);
        }
        if ($filterCreate) {
            $query->whereDate('singers.created_at', $filterCreate);
        }

        $query->orderBy('id', 'asc');
        $singerList = $query->paginate($perPage);
        return $singerList;
    }

    /**
     * Method to search singers
     */
    public static function search($search)
    {
        $singers = DB::table('singers')
            ->where('singer_name', 'LIKE', '%' . $search . '%')
            ->select('singers.*')
            ->paginate(20);
        return $singers;
    }

    public static function search_trash_singer($search)
    {
        $singers = self::withTrashed()
            ->where('singer_name', 'LIKE', '%' . $search . '%')
            ->paginate(20);
        return $singers;
    }
}
