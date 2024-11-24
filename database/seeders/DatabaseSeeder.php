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
    }
}
