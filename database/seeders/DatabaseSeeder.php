<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        User::factory()->create([
            'name' => 'Tôn Long Tiến',
            'email' => 'tonlongtien1998@gmail.com',
        ]);
        $this->call(UsersTableSeeder::class);
    }
}
