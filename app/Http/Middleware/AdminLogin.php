<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Cache::get('admin_user');
        

        if(is_null($user) || $user != $request->token){
            return response()->json(['code' => 401,'msg' => '请先登录用户']);
        }

        return $next($request);
    }
}
