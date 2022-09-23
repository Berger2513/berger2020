<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected  $table = "admin_image";

    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'type', 'url'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
