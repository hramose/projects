<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class datos_cirugia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'datos_cirugia';
    //protected $fillable = ['id_cirugia','observaciones','habitacion','fecha_carga','fecha_alta'];
    protected $fillable = ['id_cirugia','observaciones','habitacion','fecha_carga','fecha_alta','id_tipo_atencion','tipo_atencion','monto','cirujano','nombre_cirugia'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
