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

        if(!in_array($request->user,["root","admin","bela_tempo"])){
            return $this->err(400,['msg'=> '账号错误']);
        }


        if($request->password != 'root'){
            return $this->err(400,['msg'=> '密码错误']);
        }

        if($request->user == 'root'){
            $password = 'bela_root_'.$request->password;
            $token = md5($password);

            Cache::put('admin_root', $token, 60*60*12);
        }
        if($request->user == 'admin'){
            $password = 'bela_admin_'.$request->password;
            $token = md5($password);

            Cache::put('admin_admin', $token, 60*60*12);
        }
        if($request->user == 'bela_tempo'){
            $password = 'bela_bela_tempo_'.$request->password;
            $token = md5($password);

            Cache::put('admin_bela_tempo', $token, 60*60*12);
        }


        return $this->success(200,$token);
    }
}
