<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected  $table = "activity";

    protected $primaryKey = "id";



    protected  $appends  = ['prefix','end_time'];
    protected $fillable = [
        'banner', 'name', 'taobao_id', 'images', 'start_date', 'end_date', 'description', 'status','is_open'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];


    public function getPrefixAttribute($value)
    {
        return "http://bela-goods.test.upcdn.net/";
    }


    public function getImagesAttribute($value)
    {

        $coverList = explode(',',$value);
        return $coverList;
    }
    public function getEndTimeAttribute($value)
    {
        $end_time = Carbon::create($this->end_date)->timestamp;
        $now_time = Carbon::now()->timestamp;

        if($this->status == 2) {

            return $end_time - $now_time;
        }
    }

}
