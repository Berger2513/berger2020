<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function  success($code, $data =[])
    {
        return [
            'status' => 1,
            'code' => $code,
            'data' =>$data
        ];
    }

    public function  err($code, $data =[])
    {
        return [
            'status'=> -1,
            'code' => $code,
            'data' =>$data
        ];
    }
}
