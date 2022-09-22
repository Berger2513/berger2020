<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{

    /**
     *  后台分类列表
     * @return array
     */
    public function list()
    {
        $list = Category::orderBy('sort', 'desc')->get()->toArray();
        return $this->success(200,$list);
    }

    /**
     * 添加分类
     * @param AdminCategory $request
     * @return array
     */
    public function store(AdminCategory $request)
    {

        $category = new Category();
        $category->name = $request->name;
        $category->sort = $request->sort;
        $category->description = $request->description;

        $category->save();

        return $this->success(200,'');
    }
    /**
     * 编辑分类
     * @param AdminCategory $request
     * @return array
     */
    public function update(AdminCategory $request)
    {

        $category = Category::find($request->category_id);
        $category->name = $request->name;
        $category->sort = $request->sort;
        $category->description = $request->description;

        $category->save();

        return $this->success(200,'');
    }


    public function del(Request $request)
    {

        $category = Category::find($request->category_id);

        $category->delete();

        return $this->success(200,'');
    }
    public function detail(Request $request)
    {



        $category = Category::find($request->category_id);

        return $this->success(200,$category);
    }

}
