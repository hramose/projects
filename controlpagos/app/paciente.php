<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paciente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'paciente';
    protected $fillable = ['nombres','apellidos','cedula','edad'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
