<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use App\Mail\SendExpiryDate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;



// Schedule::command('check:expired-accounts')->dailyAt('01:00');
Schedule::command('check:expired-accounts')->dailyAt('10:58');


// Schedule::call(function () {
//     DB::table('users')->where('id', '=', 2)->update([
//         'gender' => 'nam',
//     ]);
// })->everyTenSeconds();

Schedule::call(function () {
    $today = Carbon::today();
        // Tìm tài khoản hết hạn
        $expiredUsers = DB::table('users')->whereDate('expiry_date', '<=', $today)->get();

        if ($expiredUsers->isEmpty()) {
            $this->info('Không có tài khoản hết hạn');
            return;
        }

        // Gửi thông báo về email user
        foreach ($expiredUsers as $user) {

            // Gửi email cho người dùng
            Mail::to($user->email)->send(new SendExpiryDate($user->expiry_date, $user->email, $user->users_type, $user->name));
            User::find($user->id)->update([
                'expiry_date' => NULL,
                'users_type' => "Basic"
            ]);

            $this->info("Đã gửi thông báo cho tài khoản: {$user->email}");
        }
})->everyTenSeconds();
