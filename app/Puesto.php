<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model{
    protected $table = 'puesto';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_area',
        'nombre',
        'clave'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function area() {
        return $this->hasOne('App\Area', 'id', 'id_area')->first();
    }

}
