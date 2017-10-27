<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id';
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'nombre_vista'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function permisos() {
        return $this->belongsToMany('App\Permiso', 'rol_permiso')->withPivot('id_permiso')->get();
    }

}
