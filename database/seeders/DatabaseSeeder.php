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
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        // ]);
        // User::factory()->create([
        //     'name' => 'Tiến',
        //     'email' => 'tien@gmail.com',
        // ]);
        // User::factory()->create([
        //     'name' => 'Quốc',
        //     'email' => 'quoc@gmail.com',
        // ]);
          // User::factory()->create([
        //     'name' => 'Nguyên',
        //     'email' => 'Alex@gmail.com',
        // ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
        ]);
        $this->call(UsersTableSeeder::class);
    }
}
