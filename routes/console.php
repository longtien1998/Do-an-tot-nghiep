<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CheckExpiryCopyright;



app(Schedule::class)->command('check:expired-accounts')->everyTenSeconds();
