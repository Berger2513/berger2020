<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Card_action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CardController extends Controller
{

    /**
     * 卡片内容详情
     * @param equest $request
     * @return array
     */
    public function detail(Request $request)
    {
        if( empty($request->uid) ||  !$card = Card::where('uid', $request->uid)->first())
        {
            return $this->err(505, '卡片不存在');
        }


        $card_action = Card_action::whereUid($request->uid)->first();

        if(!$card_action)  return $this->err(505, '卡片还没编辑');



        return $this->success(200, $card_action);
    }

    /**
     * 判断用户输入的code有效性
     * @param equest $request
     * @return array
     */
    public function get_code_status(Request $request)
    {
        if( empty($request->uid) ||  !$card = Card::where('uid', $request->uid)->first())
        {
            return $this->err(505, '卡片不存在');
        }


        if(!$request->code ||   ( strtoupper($request->code) !== strtoupper($card->code)))
        {
            return $this->err(505, 'code不匹配');
        }



        return $this->success(200, '');
    }

    /**、
     * 用户对于卡片的编辑
     * @param Request $request
     * @return array
     */
    public function action(Request $request)
    {
        //判断uid存在
        if( empty($request->uid) ||  !$card = Card::where('uid', $request->uid)->first())
        {
            return $this->err(505, '卡片不存在');
        }


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
    //    批量删除图片资源
    public function  resource_delete(Request $request)
    {
        if( 'bela_tempo_' !=  $request->code) return $this->err(505, 'code不匹配');
        //        初始化又拍云资源
        $disk = Storage::disk('upyun');

        // 删除单条文件
        $disk->delete($request->path);

        return $this->success(200,'');
    }

    /**
     * 用户上传资源到又拍云
     * @param Request $request
     * @return array
     */
    public function resource_single_upload(Request $request)
    {
        if( 'bela_tempo_' !=  $request->code) return $this->err(505, 'code不匹配');
        $res = $request->file('file');
        $path = $res->store('users','upyun');
        $pixfix = 'https://file.bela-tempo.com/';
        $data = [
            'path' => $path,
            'url'  => $pixfix.$path
        ];
        return $this->success(200,$data);
    }

    /**
     * 通过卡片的uid判断激活状态
     * @param Request $request
     * @return array
     */
    public function get_enable_status(Request $request)
    {
        if( !$card = Card::whereUid($request->uid)->first()) return $this->err(505, '卡片不存在');




        $reuturn_arr = [
            'status' =>$card->status == 1 ? true : false,
            'vfx_id' =>$card->vfx_id,
            'url' =>$card->vfx->url,
        ];

        return $this->success(200,$reuturn_arr);
    }


    /**
     * 用户上传多资源到又拍云
     * @param Request $request
     * @return array
     */
    public  function resource_upload(Request $request)
    {
        if( 'bela_tempo_' !=  $request->code) return $this->err(505, 'code不匹配');
        $res = $request->file('files');
//
        $reuturn_arr = [];
        foreach ($res as $re)
        {
            $path = $re->store('users','upyun');

            $pixfix = 'https://file.bela-tempo.com/';
            $data = [
                'path' => $path,
                'url'  => $pixfix.$path
            ];
            array_push($reuturn_arr, $data);
        }

        if(count($reuturn_arr) <1 )  return $this->err(505, '上传失败');

        return $this->success(200,$reuturn_arr);
    }
}
