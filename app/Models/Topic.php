<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    protected  $table = "topic";

    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'cover', 'modules'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function getModulesAttribute($value)
    {
        $arr = json_decode($value);

        return $arr;

    }

}
