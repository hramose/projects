<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'alta';
    protected $fillable = ['fecha','id_cirugia'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
