<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\CheckExpiryCopyright;




Schedule::command('check:expired-accounts')->dailyAt('01:00');

Schedule::call(function () {
    DB::table('users')->where('id', '=', 3)->update([
        'gender' => 'nam',
    ]);
})->everyTenSeconds();

