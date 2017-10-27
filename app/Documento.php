<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use SoftDeletes;

    protected $table = "documento";
    protected $primaryKey = "id_documento";
    protected $fillable = [
        "id_documento",
        "id_convocatoria",
        "titulo",
        "ruta_documento",
        "id_formato"
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function formato(){
        return $this->belongsTo('App\Formato', 'id_formato');
    }

    public function convocatoria(){
        return $this->belongsTo('App\Convocatoria', 'id_convocatoria');
    }
}
