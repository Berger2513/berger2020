<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Card;
use App\Models\CardResource;
use App\Models\Category;
use App\Models\Goods;
use App\Models\Page;
use App\Models\Topic;
use Illuminate\Http\Request;
use Mockery\Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $res = [];
        $admin_page = Page::first();
        $category_list = $admin_page->category_modules;
        $topic_modules = $admin_page->topic_modules;
        $video_modules = $admin_page->video_modules;
        $goods_modules = $admin_page->goods_modules;



        foreach ($category_list  as $key => $value)
        {
            $temp_category = [];

            $temp_category = Category::find($value->id);
            if(empty($temp_category)){
                $category_list[$key]->category_name = "";
                $category_list[$key]->description = "";
                continue;
            }

            $category_list[$key]->category_name = $temp_category->name;
            $category_list[$key]->category_description = $temp_category->description;

        }

        foreach ($topic_modules  as $key => $value)
        {
            $temp_topic = [];

            $temp_topic = Topic::find($value->id);
            if(empty($temp_topic)){
                $topic_modules[$key]->topic_name = "";
                continue;
            }

            $topic_modules[$key]->topic_name = $temp_topic->name;

        }


        foreach ($goods_modules as $key => $value)
        {
            $temp_goods = [];
            $temp_goods = Goods::find($value->goods_id);
            if(empty($temp_goods)){
                $goods_modules[$key]->goods_info = [];
                continue;
            }

            $goods_modules[$key]->goods_info = $temp_goods;

        }


        $res['category_list'] = $category_list;
        $res['topic_modules'] = $topic_modules;
        $res['video_modules'] = $video_modules;
        $res['goods_modules'] = $goods_modules;

        return $this->success(200, $res);
    }

    public function category()
    {
        $category_list = Category::where(['is_show' =>1])->get();
        foreach ($category_list as $key => $value)
        {
            $goods_list = Goods::where(['category_id' => $value->category_id])->limit(3)->get();
            $category_list[$key]->goods_list = $goods_list;
        }

        return $this->success(200, $category_list);
    }


    public function  activity()
    {
        $activity_list_1 = Activity::where('is_open', 1)->where('status',1)->get();
        $activity_list_2 = Activity::where('is_open', 1)->where('status',2)->get();
        $activity_list_3 = Activity::where('is_open', 1)->where('status',3)->get();

        $res = [
            'now' => $activity_list_2,
            'future' => $activity_list_1,
            'past' => $activity_list_3,
        ];

        return $this->success(200, $res);
    }


    public function bind(Request $request)
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

    public function card_add(Request $request)
    {
        //判断用户合法性
        $card = Card::whereUid($request->uid)->first();


        if($card->code  != $request->code)
            return $this->err(505, '验证码不匹配');
        $findExist =  CardResource::whereUid($request->uid)->first();
        if($findExist){
            //更新
            if(! $request->resource) {
                return $this->success(200, '');
            } else {
                $findExist->resource =  $request->resource;
                $findExist->save();
                return $this->success(200, '');
            }

        } else {
            //新增
            $CardResource = new CardResource();
            $CardResource->uid = $request->uid;
            $CardResource->code = $request->code;
            $CardResource->resource = $request->resource;

            $CardResource->save();
            return $this->success(200, '');
        }


    }
    public function card_detail(Request $request)
    {
        $findExist =  CardResource::whereUid($request->uid)->first();

        if($findExist){
            return $this->success(200, $findExist);
        } else {
            return $this->err(505, '该卡片没有激活');
        }
    }
}
