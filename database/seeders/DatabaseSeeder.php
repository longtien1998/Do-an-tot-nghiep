<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
        ]);

         // DB::table('users')->insert([
        //     [
        //         'name' => 'Doe',
        //         'email' => 'john.doe@example.com',
        //         'phone' => '1234567890',
        //         'email_verified_at' => date('Y-m-d H:i:s'),
        //         'password' => password_hash('password', PASSWORD_BCRYPT),
        //         'image' => 'john.png',
        //         'gender' => 'male',
        //         'birthday' => '1990-01-01',
        //         'users_type' => 'premium',
        //         'expiry_date' => date('Y-m-d H:i:s', strtotime('+1 year')),
        //         'remember_token' => Str::random(10),
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'deleted_at' => null,
        //     ],
        //     [

        //         'name' => 'Smith',
        //         'email' => 'jane.smith@example.com',
        //         'phone' => '0987654321',
        //         'email_verified_at' => date('Y-m-d H:i:s'),
        //         'password' => password_hash('password123', PASSWORD_BCRYPT),
        //         'image' => 'jane.png',
        //         'gender' => 'female',
        //         'birthday' => '1995-05-10',
        //         'users_type' => 'regular',
        //         'expiry_date' => date('Y-m-d H:i:s', strtotime('+1 year')),
        //         'remember_token' => Str::random(10),
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'deleted_at' => null,
        //     ],
        // ]);
    }
}
