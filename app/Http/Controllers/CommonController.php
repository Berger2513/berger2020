<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
class CommonController extends Controller
{

    protected  $accessToken;

    function __construct()
    {

    }

    public function getAccessToken()
    {
        $APPID = "wx12669591d44f3bc7";
        $APPSECRET = "8d411f1c83e083018730a39c873a4017";
        $REDIRECT_URI = urlEncode("https://api.bela-tempo.com/common/weixin_callback");
//        $REDIRECT_URI = urlEncode("http://laravel.test/common/weixin_callback");
        $state = "Bela_Temp".rand(10000,9999);



        $url1 ="https://open.weixin.qq.com/connect/qrconnect?appid=".$APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect";

dd($url1);


        //        $url = "https://open.weixin.qq.com/connect/qrconnect?appid=".$APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=snsapi_login&state=".$state."#wechat_redirect";
        //        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$APPSECRET;
        // Initialize a CURL session.
        $ch = curl_init();

        // Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $url1);

        $result = curl_exec($ch);

        dd($result);


    }


    /**
     * 微信扫码回调
     * @param Request $request
     * 通过code 得到access_token 然后再通过这个access_token来拿到微信用户的数据
     * @return array
     */
    public function  weixin_callback(Request $request)
    {
        $APPID = env('WEIXIN_KEY');
        $APPSECRET = env('WEIXIN_SECRET');

        $code = $request->code;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$APPID."&secret=".$APPSECRET."&code=".$code."&grant_type=authorization_code";

        $ch = curl_init();

        // Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);

        $res1 = json_decode($result);
        $access_token = $res1->access_token;
        $openid = $res1->openid;


        $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid;

        $weixin_user = $this->get_curl_info($url2);


        $openid = $weixin_user->openid;


        $check = User::where('openid', $openid)->first();
        if (!$check) {
            $api_token = md5($openid.rand(1000,9999));//token
            $expire_token = time()+60*60*12;//过期时间 半天时间

            DB::table('users')->create([
                'name' => $weixin_user->nickname,
                'password' =>'',
                'email' =>  '',
                'openid' => $openid,
                'sex' => $weixin_user->sex,
                'headimgurl' => $weixin_user->headimgurl,
                'unionid' => $weixin_user->unionid,
                'api_token'=> $api_token,
                'expire_token'=> $expire_token,
            ]);
            return $this->success(200, ['token' => $api_token]);
        } else {
           if(!$check->expire_token || $check->expire_token <= time())
           {
               $api_token = md5($openid.rand(1000,9999));//token
               $expire_token = time()+60*60*12;//过期时间 半天时间

               $check->api_token = $api_token;
               $check->expire_token = $expire_token;
               $check->save();
               return $this->success(200, ['token' => $api_token]);
           } else {
               return $this->success(200, ['token' => $check->api_token]);
           }

        }

    }

    public function weixin(Request $request)
    {

        $APPID = "wx12669591d44f3bc7";
        $REDIRECT_URI = urlEncode("https://api.bela-tempo.com/common/weixin_callback");

        $url ="https://open.weixin.qq.com/connect/qrconnect?appid=".$APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect";

        $data = [
            'code_url'=>  $url
        ];
        return $this->success(200, $data);
    }

    public function get_user_by_token(Request $request)
    {

        $check = User::where('api_token', $request->token)->first();
        if (!$check || $check->expire_token <= time()) {
            return $this->err(409, 'token不存在或者已经过期');
        }

        return $this->success(200, $check);
    }



    protected   function get_curl_info($url)
    {
        $ch = curl_init();

        // Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);

        $res1 = json_decode($result);

        return $res1;
    }
}
