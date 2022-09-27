<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminTopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class TopicController extends Controller
{
    public function list(Request $request)
    {
        //        自定义条件查询
        $where = [];
//        if ($request->filled('name')) {
//            $where[] = ['name','like','%'.$request['name'].'%'];
//        }
//        if ($request->filled('type')) {
//            $where[] = ['type','=',$request['type']];
//        }

        $res = Topic::where($where)->paginate(15);

        return $this->success(200,$res);
    }


    /**
     * 添加专题
     * @param AdminCategory $request
     * @return array
     */
    public function store(AdminTopic $request)
    {

        $topic = new Topic();
        $topic->cover = $request->cover;
        $topic->name = $request->name;
        $topic->modules = $request->modules;

        $topic->save();

        return $this->success(200,'创建成功');
    }

    /**
     * 编辑专题
     * @param AdminCategory $request
     * @return array
     */
    public function update(AdminTopic $request)
    {
        $topic = Topic::find($request->id);

        if(!$topic) {
            return $this->err(500, "数据有错");
        }
        $topic->cover = $request->cover;
        $topic->name = $request->name;
        $topic->modules = $request->modules;

        $topic->save();

        return $this->success(200,'编辑成功');
    }


    /**
     * 删除专题
     * @param Request $request
     * @return array
     */
    public function del(Request $request)
    {
        $topic = Topic::find($request->id);

        if(!$topic) {
            return $this->err(500, "数据有错");
        }
        $topic->delete();

        return $this->success(200,'删除成功');

    }

    /**
     * 商品详情
     * @param AdminCategory $request
     * @return array
     */
    public function detail(Request $request)
    {

        $topic = Topic::find($request->id);

        if(!$topic) {
            return $this->err(500, "数据有错");
        }
        return $this->success(200,$topic);
    }
}
