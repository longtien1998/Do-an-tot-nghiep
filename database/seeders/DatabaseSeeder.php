<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('123123'),
        // ]);

        $user = DB::table('users')->create([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '0982268784',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' =>  Hash::make('Longtien@1998'),
                'image' => 'john.png',
                'gender' => 'Nam',
                'birthday' => '1998-10-07',
                'users_type' => 'Premium',
                'expiry_date' => null,
                'remember_token' => Str::random(10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ]
        ]);
        $role = DB::table('roles')->create([
            'role_name' => 'Admin',
            'user_id' => $user->id,
            'role_type' => 0,
        ]);

        DB::table('roles_detail')->create([
            'role_id' => $role->id,
            'role_1' => 1,
            'role_2' => 1,
            'role_3' => 1,
            'role_4' => 1,
            'role_5' => 1,
            'role_6' => 1,
            'role_7' => 1,
            'role_8' => 1,
            'role_9' => 1,
            'role_10' => 1,
            'role_11' => 1,
            'role_12' => 1,
            'role_13' => 1,
            'role_14' => 1,
            'role_15' => 1,
            'role_16' => 1,
            'role_17' => 1,
            'role_18' => 1,
            'role_19' => 1,
            'role_20' => 1,
        ]);
    }
}
