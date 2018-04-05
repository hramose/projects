<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class moneda extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'moneda';
    protected $fillable = ['tipo',];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
