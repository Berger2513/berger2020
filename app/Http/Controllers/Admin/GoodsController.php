<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminGoods;
use App\Http\Requests\AdminGoodsEdit;
use App\Models\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class GoodsController extends Controller
{
        public function upload(Request $request)
        {

//            $res = $request->file('file');
//
//            foreach ($res as $re)
//            {
//                $path = $re->store('image','upyun');
//
//                $pixfix = 'http://bela-goods.test.upcdn.net/';
//            }
//            echo 1;
//            exit;
//
//            exit;
//            // 取到磁盘实例
//            $disk = Storage::disk('upyun');
//
//            // 删除单条文件
//            $disk->delete('/image/kykaCoFrOBKeCUT4c0XpQRU9fmQSGDzeY6dRrS00.jpg');
//
//
//            exit;

            $path = $request->file('file')->store('image','upyun');

//            $pixfix = 'http://bela-goods.test.upcdn.net/';
            return $path;
        }
    /**
     *  后台商品列表
     * @return array
     */
    public function list()
    {


        $list = Goods::with('category')->get();
        return $this->success(200,$list);
    }
    /**
     * 添加商品
     * @param AdminCategory $request
     * @return array
     */
    public function store(AdminGoods $request)
    {

        $goods = new Goods();
        $goods->name = $request->name;
        $goods->category_id = $request->category_id;
        $goods->taobao_id = $request->taobao_id;
        $goods->cover = $arr;
        $goods->description = $request->description;
        $goods->content = $request->content;
        $goods->options = $request->options;
        $goods->is_show = 1;


        $goods->save();

        return $this->success(200,'');
    }
    /**
     * 编辑分类
     * @param AdminCategory $request
     * @return array
     */
    public function update(AdminGoodsEdit $request)
    {

        $goods = Goods::find($request->goods_id);
        $goods->name = $request->name;
        $goods->category_id = $request->category_id;
        $goods->taobao_id = $request->taobao_id;
        $goods->cover = $request->cover;
        $goods->description = $request->description;
        $goods->content = $request->content;
        $goods->options = $request->options;
        $goods->save();

        return $this->success(200,'');
    }

    /**
     * 删除商品
     * @param AdminCategory $request
     * @return array
     */
    public function del(Request $request)
    {

        $goods = Goods::find($request->goods_id);

        $goods->delete();

        return $this->success(200,'');
    }

    /**
     * 商品详情
     * @param AdminCategory $request
     * @return array
     */
    public function detail(Request $request)
    {

        $goods = Goods::with('category')->find($request->goods_id);

        return $this->success(200,$goods);
    }

    /**
     * 商品详情
     * @param AdminCategory $request
     * @return array
     */
    public function show_action(Request $request)
    {

        $goods = Goods::where('goods_id', $request->goods_id)->update(['is_show' => $request->is_show]);



        return $this->success(200,'');
    }
}
