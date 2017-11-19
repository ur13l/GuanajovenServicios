<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenAtencion extends Model
{   
    /**
     * @var string
     */
    protected $primaryKey = 'id_orden_atencion';
    
    /**
     * @var string
     */
    protected $table = 'orden_atencion';


    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'fecha_inicio',
        'fecha_propuesta',
        'fecha_resolucion'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'id_area',
        'id_usuario_captura',
        'id_usuario_responsable',
        'id_joven_responsable',
        'id_region',
        'id_centro_poder_joven',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_propuesta',
        'fecha_resolucion',
        'costo_estimado',
        'costo_real',
        'resultado',
        'observaciones',
        'estatus'
    ];

    /**
     * Relación de área de orden de atención
     */
    public function area() {
        return $this->belongsTo('App\Area', 'id_area');
    }

    /**
     * Relación de usuario que captura la orden
     */
    public function usuarioCaptura() {
        return $this->belongsTo('App\User', 'id_usuario_captura');
    }

    /**
     * Relación de servicio con órdenes de atención.
     */
    public function usuarioResponsable() {
        return $this->belongsTo('App\User', 'id_usuario_responsable');
    }

    /**
     * Relación de joven responsable de la orden
     */
    public function jovenResponsable() {
        return $this->belongsTo('App\User', 'id_joven_responsable');
    }

    /**
     * Relación de región a la que corresponde la orden
     */
    public function region() {
        return $this->belongsTo('App\Region', 'id_region');
    }

    /**
     * Relación de centro poder joven con la orden.
     */
    public function centroPoderJoven() {
        return $this->belongsTo('App\CentroPoderJoven', 'id_centro_poder_joven');
    }

    /**
     * Relación de documentos por orden
     */
    public function documentos() {
        return $this->belongsToMany('App\DocumentoServicios', 'orden_documento', 'id_orden_atencion', 'id_documento_servicio');
    }

    /**
     * Relación de servicios a los que se liga la orden
     */
    public function servicios() {
        return $this->belongsToMany('App\Servicio', 'orden_servicio', 'id_orden_atencion', 'id_servicio');
    }

    /**
     * Relación de usuarios beneficiados (Jóvenes)
     */
    public function beneficiados() {
        return $this->belongsToMany('App\User', 'orden_beneficiados', 'id_orden_atencion', 'id_usuario');
    }

    /**
     * Relación de usuarios involucrados
     */
    public function involucrados() {
        return $this->belongsToMany('App\User', 'orden_involucrados', 'id_orden_atencion', 'id_usuario');
    }

    /**
     * Devuelve el status correspondiente
     *
     * @return void
     */
    public function estatus() {
        switch($this->estatus) {
            case 1: 
                return "Abierto";
            case 2:
                return "Cerrado";
            default:
                return "";
        }

    }
}
