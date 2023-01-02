<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

    protected  $table = "card";

    protected $primaryKey = "id";

    protected $fillable = [
        'uid', 'code',  'user_id', 'mark', 'url'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


}

