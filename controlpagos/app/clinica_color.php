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
    protected $table = 'clinica_color';
    protected $fillable = ['id_clinica','id_medico','color'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
