<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\CheckExpiryCopyright;


// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();
// Artisan::command('app:check-expiry-copyrigit', function () {
//     Artisan::call(new CheckExpiryCopyright);  // Gọi lệnh qua Artisan::call
// })->daily();

Schedule::call(function () {
    DB::table('users')->where('id', '=', 3)->update([
        'gender' => 'nam',
    ]);
})->everyTenSeconds();
