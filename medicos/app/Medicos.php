<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Medicos extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'medico';
    protected $fillable = ['nombres','apellidos','cedula','id_especialidad','telefono_hab','telefono_cel','sexo','fecha_nacimiento','email','direccion','contrasena','pregunta_secreta','respuesta_secreta','foto','id_tipo_recepcion','id_tipo_medico','activo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['contrasena'];

    public function setContrasenaAttribute($value) {
        $this->attributes['contrasena'] = bcrypt($value);
    }
}
