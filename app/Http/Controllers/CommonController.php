<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CommonController extends Controller
{


    protected  $accessToken;

    function __construct()
    {
//        if(is_empty($this->accessToken)){
//            $this->accessToken = $this->$this->getAccessToken();
//        }
    }

    public function getAccessToken()
    {


        $url = "https://www.baidu.com/";

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




    public function  weixin_callback(Request $request)
    {


        $APPID = "wx12669591d44f3bc7";
        $APPSECRET = "8d411f1c83e083018730a39c873a4017";

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

        $user = $this->get_curl_info($url2);

        echo "<img src='".$user->headimgurl."'></img>";
        echo "小倩同学 下午好哇";
        dd($user);
        dd($url);



        $user = Socialite::driver('weixin')->user();

        dd($user);
        $check = User::where('uid', $user->id)->where('provider', 'qq_connect')->first();
        if (!$check) {
            $customer = User::create([
                'uid' => $user->id,
                'provider' => 'qq_connect',
                'name' => $user->nickname,
                'email' => 'qq_connect+' . $user->id . '@example.com',
                'password' => bcrypt(Str::random(60)),
                'avatar' => $user->avatar
            ]);
        } else {
            $customer = $check;
        }

        Auth::login($customer, true);
        return redirect('/');
    }

    public function weixin(Request $request)
    {



        $this->getAccessToken();
        return Socialite::with('weixin')->redirect();
//        return Socialite::with('weixin')->redirect();
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
