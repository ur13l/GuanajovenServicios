<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Funcionario extends Model
{
    protected $table = 'funcionario';

    protected $primaryKey = 'id';

    use SoftDeletes;

    protected $fillable = [
        'id_usuario',
        'id_rol',
        'id_puesto',
        'rfc',
        'clave',
        'telefono',
        'estatus'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function usuario() {
        return $this->hasOne('App\User', 'id', 'id_usuario')->first();
    }

    public function rol() {
        return $this->hasOne('App\Rol', 'id', 'id_rol')->first();
    }

    public function puesto() {
        return $this->hasOne('App\Puesto', 'id', 'id_puesto')->first();
    }

}
