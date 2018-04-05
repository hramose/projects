<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class especialidad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'especialidad';
    protected $fillable = ['nombre',];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
