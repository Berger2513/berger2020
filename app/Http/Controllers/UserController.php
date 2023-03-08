<?php

namespace App\Http\Controllers;

use app\common\validate\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    use AuthenticatesUsers;
    public function login(Request $request)
    {

//        $credentials = ['email' => $request->name, 'password' => $request->password];
        $user = \App\Models\User::where('email', $request->name)->first();


        if(!$user)
        {
            return $this->err(400,['msg'=> '帐号不存在']);
        }

        if(!$user->password)
        {
            return $this->err(400,['msg'=> '请先设置密码']);
        }

        if( Crypt::decryptString($user->password) !=  $request->password) {
            return $this->err(400,['msg'=> '密码错误']);
        }

        $api_token = md5($user->openid.rand(1000,9999));//token
        $expire_token = time()+60*60*12;//过期时间 半天时间

        $user->api_token = $api_token;
        $user->expire_token = $expire_token;
        $user->save();
        return $this->success(200, ['token' => $api_token]);


    }


    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|min:8|string|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->err(400,['msg'=> '登录失败']);
        }
        $userId  = UserModel::max('id');

        $user_info = 'user_'.($userId +1).rand(0,1000);
        $reuslt  = encrypt($user_info);
        UserModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => $reuslt,
        ]);


        return $this->success(200,$reuslt);

    }


    public function detail(Request $request)
    {
        $user = \App\Models\User::where('api_token',$request->token)->first();

        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');        }


        return $this->success(200,$user);

    }
    public function user_edit(Request $request)
    {
        $user = \App\Models\User::where('api_token',$request->token)->first();
        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');
        }


        if($request->filled('name')) {

            $user->name = $request->name;
        }

        if($request->filled('headimgurl')) {

            $user->headimgurl = $request->headimgurl;
        }

        if($request->filled('sex')) {

            $user->sex = $request->sex;
        }
        if($request->filled('contact')) {

            $user->contact = $request->contact;
        }
        if($request->filled('job')) {

            $user->job = $request->job;
        }
        if($request->filled('signature')) {

            $user->signature = $request->signature;
        }

        $user->save();

        return $this->success(200,'');

    }


    public function detail_goods(Request $request)
    {
        $user = \App\Models\User::with('goods:goods.goods_id,goods.name,goods.cover')->where('api_token',$request->token)->first();
        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');
        }



        return $this->success(200,$user);

    }



    public function detail_sale(Request $request)
    {
        $user = \App\Models\User::where('api_token',$request->token)->first();
        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');        }

        return $this->success(200,$user);
    }



    public function collect_goods(Request $request)
    {

        $user =\App\Models\User::where('api_token',$request->token)->first();
        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');
        }

            $res = Db::table('user_goods')->where('user_id', $user->id)->where('goods_id', $request->goods_id)->first();

            if(!$res) {
                Db::table('user_goods')->insert(['user_id'=>  $user->id , 'goods_id' =>  $request->goods_id]);
                return $this->success(200, '');;
            } else {
                return $this->err(500, '已经收藏了');;
            }
    }

    public function cancle_collect_goods(Request $request)
    {
        $user =\App\Models\User::where('api_token',$request->token)->first();
        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');
        }

        $res = Db::table('user_goods')->where('user_id', $user->id)->where('goods_id', $request->goods_id)->first();

        if(!$res) {
            return $this->success(200, '');;
        } else {
            Db::table('user_goods')->where('user_id', $user->id)->where('goods_id', $request->goods_id)->delete();
            return $this->success(200, '');;

        }
    }


    public function user_email_edit(Request $request)
    {
        $user =\App\Models\User::where('api_token',$request->token)->first();
        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');
        }

        if(\App\Models\User::where('email', $request->email)->first()){
            return $this->err('409','帐号已经存在');
        }

        $user->email = $request->email;
        $user->save();
        return $this->success(200, '');;
    }
    public function user_password_edit(Request $request)
    {
        $user =\App\Models\User::where('api_token',$request->token)->first();
        if(!$user->expire_token  || $user->expire_token <= time())
        {
            return $this->err('409','token已经过期');
        }



        $user->password =  Crypt::encryptString($request->password);
        $user->save();
        return $this->success(200, '');;
    }



}
