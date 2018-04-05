<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pagosclinica extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'pagosclinicas';
    protected $fillable = ['id_cirugia', 'id_clinica','id_paciente','monto','nro_factura_clinica', 'nro_control', 'fecha_pago','id_moneda','tipo_pago','id_datos_cirugia'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
