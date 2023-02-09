<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Card_action;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function action(Request $request)
    {
        //判断uid存在
        if( empty($request->uid) ||  !$card = Card::where('uid', $request->uid)->first())
        {
            return $this->err(505, '卡片不存在');
        }



        if( empty($request->code)) {
            // 查看卡片的内容
            $card_action = Card_action::whereUid($request->uid)->first();

            return $this->success(200, $card_action);
        } else {
            // 编辑或者新建数据
            if( strtoupper($request->code) !=  strtoupper($card->code)) return $this->err(505, 'code不匹配');

            $card_action = Card_action::whereUid($request->uid)->first();

            if(!$card_action) {
                $res            = new Card_action();
                $res->name      = $request->name;
                $res->to_name   = $request->to_name;
                $res->content   = $request->content;
                $res->video     = $request->video;
                $res->music     = $request->music;
                $res->images    = $request->images;
                $res->time      = $request->time;
                $res->uid       = $request->uid;
                $res->save();

            } else {
                $card_action->name      = $request->name;
                $card_action->to_name   = $request->to_name;
                $card_action->content   = $request->content;
                $card_action->video     = $request->video;
                $card_action->music     = $request->music;
                $card_action->images    = $request->images;
                $card_action->time      = $request->time;
                $card_action->uid       = $request->uid;

                $card_action->save();
            }

            return $this->success(200, 'ok');

        }




    }
    public function resource_single_upload(Request $request)
    {
        if( 'bela_tempo_' !=  $request->code) return $this->err(505, 'code不匹配');
        $res = $request->file('file');
        $path = $res->store('users','upyun');
        $pixfix = 'https://file.bela-tempo.com/';
        return $this->success(200,$pixfix.$path);
    }





    public function resource_upload(Request $request)
    {
        if( 'bela_tempo_' !=  $request->code) return $this->err(505, 'code不匹配');
        $res = $request->file('file');
//
//        $rand_int = rand();
//        $md5_rand_int = md5($rand_int);
//        $rand_extension = rand(0,9999);
//        $file_extension = $request->file('file')->getClientOriginalExtension();
//
////        $path = $request->file('file')->store('file','upyun');
//        $path = $request->file('file')->storeAs(
//            'file', $md5_rand_int.$rand_extension.".".$file_extension,'upyun'
//        );
//
//        //$pixfix = 'http://bela-goods.test.upcdn.net/';
//        return $path;

//        dd($res);
        $reuturn_arr = [];
        foreach ($res as $re)
        {
            $path = $re->store('users','upyun');

            $pixfix = 'http://bela-goods.test.upcdn.net/';

            array_push($reuturn_arr, $path);
        }

        if(count($reuturn_arr) <1 )  return $this->err(505, '上传失败');

        return $this->success(200,$reuturn_arr);
    }
}
