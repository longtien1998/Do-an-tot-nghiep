<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authenticate(LoginRequest $request){

        $request->validated();

        $request->ensureIsNotRateLimited();

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false))->with('success','Đăng nhập thành công');
        }
        return redirect()->back()->with('error','Email hoặc mật khẩu không đúng');

    }


    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success','Đăng xuất thành công');

    }
}
