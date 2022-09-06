<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebToken
{
/**
* Handle an incoming request.
*
* @param  \Illuminate\Http\Request  $request
* @param  \Closure  $next
* @return mixed
*/
public function handle(Request $request, Closure $next)
{
if (Auth::guard('api')->guest()) {
return response()->json(['code' => 401,'msg' => 'token错误或为空']);
}

return $next($request);
}
}

