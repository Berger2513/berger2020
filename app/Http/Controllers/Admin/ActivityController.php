<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminActivity;
use App\Http\Requests\AdminActivityEdit;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\StartActivityJob;
class ActivityController extends Controller
{
    /**
     *  后台商品列表
     * @return array
     */
    public function list(Request $request)
    {
        $where = [];
        if ($request->filled('id')) {
//            $where[] = ['name','like','%'.$request['name'].'%'];
            $where[] = ['id','=',$request['id']];
        }
        if ($request->filled('status')) {
            $where[] = ['status','=',$request['status']];
        }
        $list = Activity::where($where)->paginate(15);
        return $this->success(200,$list);
    }

    public function store(AdminActivity $request)
    {
        $cover_list = implode(',', $request->images);
        $goods = new Activity();
        $goods->name = $request->name;
        $goods->banner = $request->banner;
        $goods->taobao_id = $request->taobao_id;
        $goods->images = $cover_list;
        $goods->description = $request->description;
        $goods->start_date = $request->start_date;
        $goods->end_date = $request->end_date;
        $goods->status = 1;

        $create_time = Carbon::create($request->start_date)->timestamp;
        $now_time    = Carbon::now()->timestamp;
        $delay_time  = $create_time - $now_time;
        if($delay_time<0){
            $delay_time = 10;
        }

        $goods->save();
        StartActivityJob::dispatch($goods)->delay($delay_time);


        return $this->success(200, '');
    }

    /**
     * 编辑分类
     * @param AdminCategory $request
     * @return array
     */
    public function update(AdminActivityEdit $request)
    {
        $cover_list = implode(',', $request->images);

        $goods = Activity::find($request->id);

        if (!$goods) {
            return $this->err('500', "数据不存在");
        }
        $goods->name = $request->name;
        $goods->banner = $request->banner;
        $goods->taobao_id = $request->taobao_id;
        $goods->images = $cover_list;
        $goods->description = $request->description;
        $goods->start_date = $request->start_date;
        $goods->end_date = $request->end_date;
        $goods->status = 1;
        $goods->save();
        return $this->success(200, '');
    }


    public function del(Request $request)
    {

        $activity = Activity::find($request->id);

        if (!$activity) {
            return $this->err(500, "数据有错");
        }
        $activity->delete();

        return $this->success(200, '删除成功');

    }

    /**
     * 商品详情
     * @param AdminCategory $request
     * @return array
     */
    public function detail(Request $request)
    {

        $activity = Activity::find($request->id);
        if (!$activity) {
            return $this->err(500, "数据有错");
        }
        return $this->success(200,$activity);
    }
}
