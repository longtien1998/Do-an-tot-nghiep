<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method bool hasPermissionTo(string|int|\Spatie\Permission\Models\Permission $permission, string|null $guardName = null)
 * @method bool hasRole(string|\Spatie\Permission\Models\Role $roles, string|null $guardName = null)
 * @method \Spatie\Permission\Models\Role assignRole(...$roles)
 */
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'image',
        'gender',
        'birthday',
        'users_type',
        'expiry_date',
        'remember_token',
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
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function up_file_users($file, $userName)
    {
        try {
            $userNameSlug = Str::slug($userName, '_'); // Tạo slug cho tên bài hát
            $extension = $file->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
            $fileName = time() . '_' . $userNameSlug . '.' . strtolower($extension); // Đặt tên file


            // Đường dẫn lưu trữ trên S3
            $path = 'users/' . $userNameSlug;

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
    public static function selectUsers($perPage, $filterGenDer, $filterRole, $filterCreate)
    {

        $query =self::with('roles')
            ->whereNull('deleted_at');
        if ($filterGenDer) {
            $query->where('users.gender', $filterGenDer);
        }
        if ($filterRole) {
            $query->whereHas('roles', function ($q) use ($filterRole) {
                $q->where('roles.id', $filterRole);
            });
        }
        if ($filterCreate) {
            $query->whereDate('users.created_at', $filterCreate);
        }

        $query->orderBy('id', 'asc');
        $userList = $query->paginate($perPage);

        return $userList;
    }
    public static function search_users($search)
    {
        $users = self::with('roles')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%'. $search. '%')
            ->orWhere('phone', 'LIKE', '%'. $search. '%')
            ->orWhereHas('roles', function ($q) use ($search) {
                $q->where('roles.name', 'LIKE', '%'. $search. '%');
            })
            ->select('users.*')
            ->paginate(10);
        return $users;
    }
    public static function show($id)
    {
        $users = User::find($id);
        return $users;
    }
}
