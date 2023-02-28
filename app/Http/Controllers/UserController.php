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
class UserController extends Controller
{
    use AuthenticatesUsers;
    public function login(Request $request)
    {

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (Auth::attempt($credentials)) {

            $user_info = 'user_'.Auth::user()->id.rand(0,1000);
            $reuslt  = encrypt($user_info);


            UserModel::where('id',Auth::user()->id)->update(['api_token'=> $reuslt]);

            return $this->success(200,$reuslt);
        }

        return $this->err(400,['msg'=> '登录失败']);


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
        $user = \App\Models\User::where('api_token',$request->token)->find();



        return $this->success(200,$user);

    }
    public function detail_goods(Request $request)
    {
        $user = \App\Models\User::with('goods:goods.goods_id,goods.name,goods.cover')->where('api_token',$request->token)->find();



        return $this->success(200,$user);

    }



    public function detail_sale(Request $request)
    {
        $user = \App\Models\User::where('api_token',$request->token)->find();
        $user->name_status = true;
        $user->password_status = true;
        $user->openid_status = true;

        if(!$user->email) {
            $user->name_status = false;
        }
        if(!$user->password) {
            $user->password_status = false;
        }
        if(!$user->openid) {
            $user->openid_status = false;
        }
        return $this->success(200,$user);
    }



    public function collect_goods(Request $request)
    {

            $res = Db::table('user_goods')->where('user_id', $request->user_id)->where('goods_id', $request->goods_id)->first();

            if(!$res) {
                Db::table('user_goods')->insert(['user_id'=> $request->user_id , 'goods_id' =>  $request->goods_id]);
                return $this->success(200, '');;
            } else {
                return $this->err(500, '已经收藏了');;
            }
    }

    public function cancle_collect_goods(Request $request)
    {

        $res = Db::table('user_goods')->where('user_id', $request->user_id)->where('goods_id', $request->goods_id)->first();

        if(!$res) {
            return $this->success(200, '');;
        } else {
            Db::table('user_goods')->where('user_id', $request->user_id)->where('goods_id', $request->goods_id)->delete();
            return $this->success(200, '');;

        }
    }

}
