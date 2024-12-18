<?php

namespace App\Http\Controllers\Admin\Auto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\SendExpiryDate;
use Illuminate\Support\Facades\Mail;


class CheckAccountController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        // Tìm tài khoản hết hạn
        $expiredUsers = User::whereDate('expiry_date', '<=', $today)->get();

        if ($expiredUsers->isEmpty()) {
            // $this->info('Không có tài khoản hết hạn');
            return;
        }
        try {
            // Gửi thông báo về email user
            foreach ($expiredUsers as $user) {

                // Gửi email cho người dùng
                Mail::to($user->email)->send(new SendExpiryDate($user->expiry_date, $user->email, $user->users_type, $user->name));
                User::find($user->id)->update([
                    'expiry_date' => NULL,
                    'users_type' => "Basic"
                ]);

                // $this->info("Đã gửi thông báo cho tài khoản: {$user->email}");
            }
            return redirect()->back()->with('success','Check tài khoản hết hạn thành công, có '.$expiredUsers->count().' tài khoản hết hạn');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Lỗi khi check');
        }
    }
}
