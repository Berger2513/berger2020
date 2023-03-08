<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Goods_source extends Model
{
    protected $table = "goods_source";

    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'url', 'price', 'status','shop_name'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];




}
