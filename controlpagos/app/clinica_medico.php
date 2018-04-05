<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clinica_medico extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'clinica_medico';
    protected $fillable = ['id_medico','color','direccion','ciudad','pais'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
