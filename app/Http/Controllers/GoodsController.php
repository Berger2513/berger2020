<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class GoodsController extends Controller
{
    //    批量删除图片资源
    public function  image_del(Request $request)
    {
        //        初始化又拍云资源
        $disk = Storage::disk('upyun');

        // 删除单条文件
        $disk->delete($request->image);

        return $this->success(200,'');
    }


    //    批量添加图片资源
    public function  image_add(Request $request)
    {
        $res = $request->file('file');

        $reuturn_arr = [];
        foreach ($res as $re)
        {
            $path = $re->store('image','upyun');

            $pixfix = 'http://bela-goods.test.upcdn.net/';

            array_push($reuturn_arr, $path);
        }
        return $this->success(200,$reuturn_arr);
    }

    public function detail(Request $request)
    {

        $goods = Goods::find($request->goods_id);

        if(!$goods) return $this->err(500,'商品不存在');


        return $this->success(200,$goods);
    }
}
