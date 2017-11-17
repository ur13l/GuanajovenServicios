<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    protected $table = 'chat';
      protected $primaryKey = 'id_chat';
      use SoftDeletes;

      protected $fillable = [
          'id_usuario'
      ];
      protected $dates = [
          'created_at',
          'updated_at',
          'deleted_at'
      ];


    public function usuario() {
        return $this->belongsTo('App\User', 'id_usuario', 'id');
    }

    public function mensajes() {
        return $this->hasMany('App\Mensaje', 'id_chat', 'id_chat');
    }

    public function ultimoMensaje() {
        return $this->mensajes->last();
    }

    public function contarNoLeidos() {
        return count($this->mensajes()->where('visto', false)->get());
    }

    public function todosLeidos(){
        return $this->mensajes()->where('visto',false)->update(['visto' => true]);
    }
}
