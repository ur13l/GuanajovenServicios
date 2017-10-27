<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_direccion',
        'nombre',
        'clave'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function direccion() {
        return $this->hasOne('App\Direccion', 'id', 'id_direccion')->first();
    }

}
