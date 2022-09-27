<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminActivity;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{


    public function store(AdminActivity $request)
    {
        $cover_list = implode(',',$request->images);
        $goods = new Activity();
        $goods->name = $request->name;
        $goods->banner = $request->banner;
        $goods->goods_id = $request->goods_id;
        $goods->images = $cover_list;
        $goods->description = $request->description;
        $goods->start_date = $request->start_date;
        $goods->end_date = $request->end_date;
        $goods->status = 1;


        $goods->save();

        return $this->success(200,'');
    }
}
