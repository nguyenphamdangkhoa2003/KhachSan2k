<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có vai trò admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Nếu không, chuyển hướng đến trang khác (ví dụ: trang chủ hoặc thông báo lỗi)
        return redirect('welcome')->with('error', 'Bạn không có quyền truy cập trang này.');
    }
}
