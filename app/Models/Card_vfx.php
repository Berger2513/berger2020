<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card_vfx extends Model
{
    protected $table = "card_vfx";

    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'url'
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
