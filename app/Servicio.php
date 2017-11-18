<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id_servicio';
    
    /**
     * @var string
     */
    protected $table = 'servicio';


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
        'id_servicio',
        'titulo',
        'descripcion',
        'estatus'
    ];

    /**
     * Relación de servicio con órdenes de atención.
     */
    public function ordenes() {
        return $this->belongsToMany('App\OrdenAtencion','orden_servicio', 'id_servicio', 'id_orden_servicio');
    }

}
