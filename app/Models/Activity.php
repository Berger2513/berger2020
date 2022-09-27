<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected  $table = "activity";

    protected $primaryKey = "id";

    protected $fillable = [
        'banner', 'name', 'goods_id', 'images', 'start_date', 'end_date', 'description', 'status',
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

}
