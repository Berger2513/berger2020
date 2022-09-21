<?php

namespace App\Http\Controllers\Admin;

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
}
