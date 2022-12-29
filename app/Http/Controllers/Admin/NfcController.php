<?php

namespace App\Http\Controllers\Admin;

use App\Models\Card;
use App\Models\CardResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NfcController extends Controller
{
    //


    public function add(Request $request)
    {

        $findExist =  Card::whereUid($request->uid)->first();

        if($findExist)
            return $this->err(505, 'uid已经绑定成功');

        $card = new Card();
        $card->uid = $request->uid;
        $card->code = $request->code;


        $card->save();

        return $this->success(200, '');
    }
    public function wirte_resource(Request $request)
    {

        //判断用户合法性
        $card = Card::whereUid($request->uid)->first();


        if(!$card)
            return $this->err(505, '卡片不存在');
        $findExist =  CardResource::whereUid($request->uid)->first();

        if($findExist){
            //更新
            $findExist->mark =  $request->mark;
            $findExist->url =  $request->url;
            $findExist->save();
            return $this->success(200, '');


        } else {
            //新增
            $CardResource = new CardResource();
            $CardResource->uid = $request->uid;
            $CardResource->code = $request->code;
            $CardResource->user_id = $request->user_id;
            $CardResource->mark = $request->mark;
            $CardResource->url = $request->url;

            $CardResource->save();
            return $this->success(200, '');
        }
    }
    public function list(Request $request)
    {
        $where = [];
        if ($request->filled('uid')) {
            $where[] = ['uid',$request->uid];
        }


        $list = CardResource::where($where)->paginate(15);
        return $this->success(200,$list);
    }
    public function detail(Request $request)
    {

        $findExist =  CardResource::whereUid($request->uid)->first();

        if($findExist){
            return $this->success(200, $findExist);
        } else {
            return $this->err(505, '该卡片没有激活');
        }

    }
}
