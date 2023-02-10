<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card_action extends Model
{
    protected $table = "card_action";

    protected $primaryKey = "id";
    protected  $appends  = ['vfx_id'];
    protected $fillable = [
        'name', 'to_name','content','images','video','music','time','uid'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function getVfxIdAttribute($value)
    {

        $vfx = Card::whereUid($this->uid)->first();

        return $vfx->vfx_id;
    }

    public function getImagesAttribute($value)
    {

        $coverList = explode(',',$value);
        return $coverList;
    }
}
