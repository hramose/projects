<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seguros_medicos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'seguros_medicos';
    protected $fillable = ['nombre','direccion','id_medico'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
