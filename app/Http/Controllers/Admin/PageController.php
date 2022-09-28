<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function update(Request $request)
    {
        $page =  Page::first();

        if(empty($page)){
            $page = new Page();
        }

        $page->category_modules = $request->category_modules;
        $page->topic_modules = $request->topic_modules;
        $page->video_modules = $request->video_modules;
        $page->goods_modules = $request->goods_modules;

        $page->save();

        return $this->success(200,'');
    }


    public function detail()
    {
        $page =  Page::first();

        return $this->success(200,$page);
    }

    public function banner_update(Request $request)
    {
        $banner =  Banner::first();

        if(empty($banner)){
            $banner = new Banner();
        }

        $banner->home_url = $request->home_url;
        $banner->activity_url = $request->activity_url;
        $banner->category_url = $request->category_url;
        $banner->community_url = $request->community_url;
        $banner->shop_url = $request->shop_url;
        $banner->concat_url = $request->concat_url;

        $banner->save();

        return $this->success(200,'');
    }
    public function banner_detail()
    {
        $banner =  Banner::first();
        if(empty($banner)){
            return $this->success(200,[]);
        }
        return $this->success(200,$banner);
    }

}
