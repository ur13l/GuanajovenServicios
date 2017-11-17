<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Convocatoria extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $table = "convocatoria";
    protected $primaryKey = "id_convocatoria";
    protected $fillable = [
        "id_convocatoria",
        "titulo",
        "descripcion",
        "ruta_imagen",
        "fecha_inicio",
        "fecha_cierre",
        "estatus"
    ];

    protected $dates = [
        "fecha_inicio",
        "fecha_cierre",
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function documentos(){
        return $this->hasMany('App\Documento', 'id_convocatoria')->with('formato');
    }

    public function usuarios() {
        return $this->belongsToMany('App\User', 'usuario_convocatoria', 'id_convocatoria', 'id_usuario');
    }
}
