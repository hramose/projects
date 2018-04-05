<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class imagen extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'imagenes';
    protected $primaryKey = 'imagen_id';
    public $timestamps = false;

    protected $fillable = [
        'imagen_id', 'medico_id', 'clinica_id', 'descripcion', 'nombre_archivo', 'fecha_fin_mes', 'consecutivo', 'tipo_imagen', 'estatus', 'fecha_ingreso', 'userid_ingreso', 'fecha_anulacion', 'userid_anulacion', 'fecha_revision', 'userid_revision', 'fecha_correccion', 'userid_correccion', 'fecha_verificacion', 'userid_verificacion', 
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