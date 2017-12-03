<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstatusOrden extends Model
{
    public $table = 'estatus_orden';
    public $primaryKey = 'id';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'nombre'
    ];
}
