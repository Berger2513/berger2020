<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\DB;




class IndexController extends Controller
{


    /**
     *
     */
    public function index()
    {
          $category = DB::table('categorys')->get();

//        $category = Category::first();
        return $category->toJson();
    }
}
