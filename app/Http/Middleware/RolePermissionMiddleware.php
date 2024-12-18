<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {

        if (!Auth::check()) {

            return redirect('/login')->with('Vui lòng đăng nhập để tiếp tục');
        }

        $user = Auth::user();
        // dd($permission);

        if (!$user->hasPermissionTo($permission)) {
            return redirect()->back()->with('warning', 'Bạn không có quyền với hành động này, vui lòng liên hệ quản trị viên để biết thêm thông tin chi tiết.');
        }

        return $next($request);
    }
}
