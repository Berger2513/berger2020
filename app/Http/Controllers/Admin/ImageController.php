<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class ImageController extends Controller
{

    /**
     * 后台图片资源列表
     * @param Request $request
     * @return array
     */
    public function list(Request $request)
    {
        //        自定义条件查询
        $where = [];
        if ($request->filled('name')) {
            $where[] = ['name','like','%'.$request['name'].'%'];
        }
        if ($request->filled('type')) {
            $where[] = ['type','=',$request['type']];
        }

        $res = Image::where($where)->paginate(15);

        return $this->success(200,$res);
    }
    /**
     *  图片上传到云端
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {
        $rand_int = rand();
        $md5_rand_int = md5($rand_int);
        $rand_extension = rand(0,9999);
        $file_extension = $request->file('file')->getClientOriginalExtension();

//        $path = $request->file('file')->store('file','upyun');
        $path = $request->file('file')->storeAs(
            'file', $md5_rand_int.$rand_extension.".".$file_extension,'upyun'
        );

        //$pixfix = 'http://bela-goods.test.upcdn.net/';
        return $path;
    }

    //    添加到服务器
    public function add(Request $request)
    {
        $image = new Image();
        $image->name = $request->name;
        $image->type = $request->type;
        $image->url = $request->url;

        $image->save();

        return $this->success(200,'');
    }

    //    删除图片资源
    public function  del(Request $request)
    {
        $image = Image::where('url', $request->url)->first();



        try {
            //        初始化又拍云资源
            $disk = Storage::disk('upyun');
            // 删除单条文件
            $disk->delete($request->url);

            if($image) {

                $image->delete();
            }

            return $this->success(200,'');

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

}
