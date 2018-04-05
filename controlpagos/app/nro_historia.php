<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nro_historia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'nro_historia';
    protected $fillable = ['nro_historia','id_paciente','id_clinica'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
