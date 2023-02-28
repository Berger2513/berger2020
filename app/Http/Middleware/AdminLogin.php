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
        $admin_arr = array();
        $user_root = Cache::get('admin_root');
        $user_admin = Cache::get('admin_admin');
        $user_bela = Cache::get('admin_bela_tempo');


array_push($admin_arr,$user_root );
array_push($admin_arr,$user_admin );
array_push($admin_arr,$user_bela );


        if(!$request->token) {
            return response()->json(['code' => 401,'msg' => '请先登录用户']);
        }

        if(!in_array($request->token, $admin_arr))
        {

            return response()->json(['code' => 499,'msg' => '数据不匹配']);
        }



        return $next($request);
    }
}
