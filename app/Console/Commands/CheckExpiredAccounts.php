<?php

namespace App\Console\Commands;

use App\Mail\SendExpiryDate;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckExpiredAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expired-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra tài khoản hết hạn và gửi thông báo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        // Tìm tài khoản hết hạn
        $expiredUsers = User::whereDate('expiry_date', '<=', $today)->get();

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
    }
}
