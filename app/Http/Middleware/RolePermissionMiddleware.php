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
        // Kiểm tra xem user đã đăng nhập hay chưa
        if (!Auth::check()) {

            return redirect('/login')->with('Vui lòng đăng nhập để tiếp tục');
        }
        // Lấy người dùng hiện tại
        $user = Auth::user();
        // dd($permission);
        // Kiểm tra nếu người dùng có quyền thông qua vai trò
        if (!$user->hasPermissionTo($permission)) {
            return redirect()->back()->with('warning', 'Bạn không có quyền với hành động này, vui lòng liên hệ quản trị viên để biết thêm thông tin chi tiết.');
        }

        return $next($request);
    }
}
