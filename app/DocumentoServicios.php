<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoServicios extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id_documento_servicio';
    
    /**
     * @var string
     */
    protected $table = 'documento_servicio';


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
        'id_documento_servicio',
        'titulo',
        'url'
    ];
}
