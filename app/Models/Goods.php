<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Goods extends Model
{
    protected  $table = "goods";

    protected $primaryKey = "goods_id";

    protected $fillable = [
        'name', 'category_id', 'taobao_id', 'cover', 'content', 'description', 'options', 'view_nums', 'collection_nums','is_show'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function getCoverAttribute($value)
    {

        $coverList = explode(',',$value);
        return $coverList;
    }

    protected $casts = [
        'is_show' => 'boolean',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'category_id','category_id');
    }
}
