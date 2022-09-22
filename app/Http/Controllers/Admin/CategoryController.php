<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
class CategoryController extends Controller
{
    //
    public function list()
    {
        $list = Category::orderBy('sort', 'desc')->get()->toArray();
        return $this->success(200,$list);
    }

    public function store(AdminCategory $request)
    {


        $category = new Category();

        $category->name = $request->name;
        $category->sort = $request->sort;

        $category->save();

        return $this->success(200,'');
    }

}
