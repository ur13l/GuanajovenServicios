<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenAtencion extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id_centro_poder_joven';
    
    /**
     * @var string
     */
    protected $table = 'centro_poder_joven';


    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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
        $this->hasOne('App\Area', 'id_area');
    }

    /**
     * Relación de usuario que captura la orden
     */
    public function usuarioCaptura() {
        $this->hasOne('App\User', 'id_usuario_captura');
    }

    /**
     * Relación de servicio con órdenes de atención.
     */
    public function usuarioResponsable() {
        return $this->hasOne('App\User', 'id_usuario_responsable');
    }

    /**
     * Relación de joven responsable de la orden
     */
    public function jovenResponsable() {
        return $this->hasOne('App\User', 'id_joven_responsable');
    }

    /**
     * Relación de región a la que corresponde la orden
     */
    public function region() {
        return $this->hasOne('App\Region', 'id_region');
    }

    /**
     * Relación de centro poder joven con la orden.
     */
    public function centroPoderJoven() {
        return $this->hasOne('App\CentroPoderJoven', 'id_centro_poder_joven');
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
}
