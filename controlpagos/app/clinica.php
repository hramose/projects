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
    protected $table = 'clinica';
    protected $fillable = ['nombre','direccion','pais','ciudad'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
