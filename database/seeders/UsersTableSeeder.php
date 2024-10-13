<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'firstname' => 'John',
                'name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '1234567890',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'image' => 'john.png',
                'gender' => 'male',
                'birthday' => '1990-01-01',
                'roles' => 'admin',
                'users_type' => 'premium',
                'expiry_date' => date('Y-m-d H:i:s', strtotime('+1 year')),
                'remember_token' => Str::random(10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'firstname' => 'Jane',
                'name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '0987654321',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'image' => 'jane.png',
                'gender' => 'female',
                'birthday' => '1995-05-10',
                'roles' => 'user',
                'users_type' => 'regular',
                'expiry_date' => date('Y-m-d H:i:s', strtotime('+1 year')),
                'remember_token' => Str::random(10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
        ]);
    }
}
