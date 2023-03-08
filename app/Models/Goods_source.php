<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Goods_source extends Model
{
    protected $table = "goods_source";

    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'url', 'price', 'status','shop_name','category_id','goods_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function category()
    {
        return $this->hasOne(Category::class, 'category_id','category_id');
    }

}
