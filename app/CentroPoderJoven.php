<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroPoderJoven extends Model
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
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'id_centro_poder_joven',
        'nombre',
        'direccion',
        'id_usuario_responsable'
    ];

    /**
     * Relación de usuario responsable por Centro Poder Joven
     */
    public function usuarioResponsable() {
        return $this->hasOne('App\User', 'id_usuario_responsable');
    }


    /**
     * Relación de órdenes atención por Centro Poder Joven
     */
    public function ordenesAtencion() {
        return $this->hasMany('App\OrdenAtencion', 'id_orden_atencion');
    }
}
