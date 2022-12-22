<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardResource extends Model
{

    protected $table = "card_resource";

    protected $primaryKey = "id";

    protected $fillable = [
        'uid', 'code', 'resource'
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

