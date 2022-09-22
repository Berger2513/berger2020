<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected  $table = "goods";

    protected $primaryKey = "goods_id";

    protected $fillable = [
        'name', 'category_id', 'taobao_id', 'cover', 'content', 'description', 'options', 'view_nums', 'collection_nums'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function category()
    {
        return $this->hasOne(Category::class, 'category_id','category_id');
    }
}
