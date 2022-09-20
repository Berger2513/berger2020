<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
        public function upload(Request $request)
        {
            

            $path = $request->file('file')->store('image','upyun');

            $pixfix = 'http://bela-goods.test.upcdn.net/';
            return $pixfix.$path;
        }
}
