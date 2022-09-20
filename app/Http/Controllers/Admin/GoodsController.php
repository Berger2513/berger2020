<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
        public function upload(Request $request)
        {
            $files = $request->file('file');

            $path = $request->file('avatar')->store('avatars','upyun');

            $pixfix = 'http://bela-goods.test.upcdn.net/';
            return $pixfix.$path;
        }
}
