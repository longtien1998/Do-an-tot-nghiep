<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);
        $user = User::firstWhere('email', '=', $credentials['email'])->roles->first()->role_type;
        // dd($user);
        // Kiểm tra xem người dùng có quyền admin hay không
        if ($user !== 1 && $user !== 2 && $user !== 3) {
            // Nếu người dùng không có quyền quản trị, chuyển hướng login lại
            return redirect()->back()->with('error', 'Tài khoản của bạn không có quyền vào Admin. Vui lòng đăng nhập tài khoản quản trị.');
        }

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false))->with('success', 'Đăng nhập thành công');
        }
        return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng');
    }


    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đăng xuất thành công');
    }
}
