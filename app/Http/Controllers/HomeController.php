<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goods;
use App\Models\Page;
use Illuminate\Http\Request;

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
        $res['category_list'] = $category_list;
        $res['topic_modules'] = $topic_modules;
        $res['video_modules'] = $video_modules;


        foreach ($goods_modules as $key => $value)
        {
            $temp_goods = Goods::find($value->goods_id);
            if(empty($temp_goods)){
                $goods_modules[$key]->goods_info = [];
            }

            $goods_modules[$key]->goods_info = $temp_goods;

        }



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
}
