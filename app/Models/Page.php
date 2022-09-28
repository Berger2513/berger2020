<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "admin_page";


    protected $fillable = [
        'category_modules', 'topic_modules', 'video_modules', 'goods_modules',
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function getCategoryModulesAttribute($value)
    {
        return json_decode($value);
    }


    public function getTopicModulesAttribute($value)
    {
        return json_decode($value);
    }
    public function getVideoModulesAttribute($value)
    {
        return json_decode($value);
    }
    public function getGoodsModulesAttribute($value)
    {
        return json_decode($value);
    }

}
