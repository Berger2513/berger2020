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

        $user_root = Cache::get('admin_root');
        $user_admin = Cache::get('admin_admin');
        $user_bela = Cache::get('admin_bela_tempo');

        if(!$request->token) {
            return response()->json(['code' => 401,'msg' => '请先登录用户']);
        }

        if(!in_array($request->token,[$user_root,$user_admin,$user_bela])){
            return response()->json(['code' => 401,'msg' => '请先登录用户']);
        }



        return $next($request);
    }
}
