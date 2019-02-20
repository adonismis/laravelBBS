<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        //三個判斷
        //1.如果用戶已登錄
        //2.並且還未認證 Email
        //3.並訪問的不是 email 驗證相關 URL 或者退出的 URL。
        if ($request->user() &&
            ! $request->user()->hasVerifiedEmail() &&
            ! $request->is('email/*', 'logout')) {

            // 返回對應內容
            return $request->expectsJson()
                        ? abort(403, 'Your email address is not verified.')
                        : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
