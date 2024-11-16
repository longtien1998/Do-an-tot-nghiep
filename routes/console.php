<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CheckExpiryCopyright;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
Artisan::command('app:check-expiry-copyrigit', function () {
    Artisan::call(new CheckExpiryCopyright);  // Gọi lệnh qua Artisan::call
})->daily();
