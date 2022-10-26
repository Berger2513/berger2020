<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected  $table = "admin_image";
    protected $appends = ['path'];
    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'type', 'url'
    ];
    protected $hidden = [
         'updated_at',
    ];

    public function getPathAttribute()
    {
        $url = $this->attributes['url'];
        $pixfix = 'http://file.bela-tempo.com/';
        return  $pixfix.$url;
    }

}
