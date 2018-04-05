<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transcriptor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'transcripcion';
    protected $primaryKey = 'transcripcion_id';
    public $timestamps = false;

    protected $fillable = [
        'transcripcion_id', 'medico_id', 'clinica_id', 'imagen_id', 'registro_id', 'historia', 'nombre_completo_paciente', 'factura', 'nro_orden', 'fecha_facturacion', 'fecha_entrega_seguro', 'monto_servicio', 'pago', 'saldo_pendiente', 'tipo_pago', 'estatus','id_tabla_atencion', 'fecha_ingreso', 'userid_ingreso', 'fecha_anulacion', 'userid_anulacion', 'fecha_revision', 'userid_revision', 'fecha_correccion', 'userid_correccion', 'fecha_verificacion', 'userid_verificacion', 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'fecha_ingreso', 'userid_ingreso', 'fecha_anulacion', 'userid_anulacion', 'fecha_revision', 'userid_revision', 'fecha_correccion', 'userid_correccion', 'fecha_verificacion', 'userid_verificacion',  
    ];

}