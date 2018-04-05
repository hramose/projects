<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cirugia_seguro extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'cirugia_seguro';
    protected $fillable = ['id_cirugia','id_seguro'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
