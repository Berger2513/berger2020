<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
        public function store(Request $request)
        {
            $files = $request->file('avatar');

            foreach ($files as $file) {
                dd(1);
            }
//            $path = $request->file('avatar')->store('avatars','upyun');

//            return $path;
        }
}
