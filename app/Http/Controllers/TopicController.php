<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Topic;
use App\Models\Goods;
use Illuminate\Http\Request;

class TopicController extends Controller
{
     public function list()
     {
         $res = Topic::get();

         foreach($res  as $key =>  $re)
         {
             $moudules = $re->modules;

             foreach ($moudules as $k =>  $moudule)
             {

                    $goods_str = $moudule->goods_id;
                    $goods_list = Goods::whereIn('goods_id',[$goods_str])->get(['goods_id','cover']);




//                 $res[$key]->modules[$k]->goods = 1;
             }

         }

        return $this->success(200, $res);
     }

     public function detail(Request $request)
     {
         $res = Topic::find($request->topic_id);
         if(!$res) return $this->err(500, '没有数据');

         $moudules = $res->modules;

         foreach ($moudules as $k =>  $moudule)
         {

             $goods_str = $moudule->goods_id;
             $goods_list = Goods::whereIn('goods_id',[$goods_str])->get(['goods_id','cover','name']);

             $moudules[$k]->goods = $goods_list;
         }


         $res->modules = json_encode($moudules);

         


         return $this->success(200, $res);
     }
}
