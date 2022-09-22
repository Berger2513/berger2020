<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function login(Request $request)
    {

        if($request->user != 'root'){
             return $this->err(400,['msg'=> '账号错误']);
        }

        if($request->password != 'root'){
            return $this->err(400,['msg'=> '密码错误']);
        }

        $password = 'bela_'.$request->password;
        $token = encrypt($password);

        Cache::put('admin_user', $token, 600);

        return $this->success(200,$token);
    }
}
