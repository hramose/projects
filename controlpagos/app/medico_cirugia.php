<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class medico_cirugia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'medico_cirugia';
    protected $fillable = ['id_cirugia','id_especialidad','id_rol','rol','monto','id_datos_cirugia'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
