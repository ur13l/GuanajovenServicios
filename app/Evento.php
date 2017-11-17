<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model {
    public $table = 'evento';
    public $primaryKey = 'id_evento';
    use SoftDeletes;

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'id_tipo_evento',
        'direccion',
        'latitud',
        'longitud',
        'puntos_otorgados',
        'area_responsable'
    ];

    public function tipoEvento() {
        return $this->hasOne('App\TipoEvento', 'id_tipo_evento');
    }

    public function scopeProximos($query) {
        return $query->orderBy('fecha_inicio', 'desc');
    }

    public function usuarios() {
        return $this->belongsToMany('App\User', 'usuario_evento', 'id_evento', 'id_usuario');
    }
}
