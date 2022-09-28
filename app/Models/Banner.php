<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = "admin_url_page";


    protected $fillable = [
        'home_url', 'activity_url', 'category_url', 'community_url','shop_url','concat_url'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];



}
