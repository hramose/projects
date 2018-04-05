<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seguro extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'seguros';
    protected $fillable = ['nombre','direccion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
