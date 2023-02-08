<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{

    protected  $table = "card";

    protected $primaryKey = "id";

    protected  $appends  = ['vfx'];

    protected $fillable = [
        'uid', 'code',  'user_id', 'mark', 'url','vfx_id','status'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function getVfxAttribute($value)
    {
        $vfx = Card_vfx::find($this->vfx_id);


        return $vfx;
    }

}

