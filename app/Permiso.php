<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permiso';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'nombre_vista'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function roles() {
        return $this->belongsToMany('App\Rol', 'rol_permiso')->withPivot('id_rol')->get();
    }
}
