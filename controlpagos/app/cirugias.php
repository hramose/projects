<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cirugias extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'cirugias';
    protected $fillable = ['id_medico','id_paciente', 'id_clinica','id_nro_historia','fecha_cirugia','nro_historia','img_sticker','nombre', 'id_especialidad','id_moneda'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
