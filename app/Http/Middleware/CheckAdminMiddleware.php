<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {

            return redirect('/login')->with('Vui lòng đăng nhập để tiếp tục');
        }

        $user = Auth::user();
        // dd($permission);

        $acc = $user->roles->first();
        // dd($acc->role_type);
        if($acc){
            $role = $acc->role_type;
        } else {
            $role = 0;
        }
        // dd($user);

        if ($role == 0) {

            return redirect('/login')->with('error', 'Tài khoản của bạn không có quyền vào Admin. Vui lòng đăng nhập tài khoản quản trị.');
        }
        
        return $next($request);
    }
}
