<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    protected  $table = "topic";

    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'cover', 'modules'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function getModulesAttribute($value)
    {
        $arr = json_decode($value);


        foreach ($arr as $key=> $val){
            $goods_temp = explode(',', $val->goods_id);

            $temp_goods_arr = [];
            foreach ($goods_temp as $goods)
            {
                $item = Goods::find($goods)->toArray();

                if($goods){
                    array_push($temp_goods_arr, $item);
                } else {
                    continue;
                }

            }

            $arr[$key]->goods_list = $temp_goods_arr;
        }


        return $arr;


    }

}
