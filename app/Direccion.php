<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direccion';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_dependencia',
        'nombre',
        'clave'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function dependencia() {
        return $this->hasOne('App\Dependencia', 'id', 'id_dependencia')->first();
    }

}
