<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenSeguimiento extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id_orden_seguimiento';
    
    /**
     * @var string
     */
    protected $table = 'orden_seguimiento';


    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'id_orden_seguimiento',
        'id_comentario',
        'titulo',
        'descripcion',
        'fecha_comentario',
        'id_usuario',
        'id_comentario_anterior'
    ];
}
