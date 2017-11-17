<?php

namespace App\Notifications;

use App\DatosUsuario;
use App\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventoNotificacion extends Notification {
    use Queueable;

    protected $evento;
    protected $datosUsuario;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Evento $evento, DatosUsuario $datosUsuario) {
        $this->evento = $evento;
        $this->datosUsuario = $datosUsuario;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $idUsuario = $this->datosUsuario->id_usuario;
        $idEvento = $this->evento->id_evento;
        $curpUsuario = $this->datosUsuario->curp;

        $fecha_inicio = $this->evento->fecha_inicio->format("d/m/Y");
        $fecha_fin = $this->evento->fecha_fin->format("d/m/Y");

        return (new MailMessage)
            ->line($this->datosUsuario->nombre.'.')
            ->line('Hemos visto que estas interesado en la evento: '.$this->evento->titulo.'.')
            ->line('Con fechas de: '.$fecha_inicio.' al '.$fecha_fin.'.')
            ->line('Si estas de acuerdo con ello, favor de oprimir el boton de aceptar, caso contrario has caso omiso a este mensaje.')
            //ingresamos a la url correspondiente con los parametros
            ->action('Aceptar', route('evento.registrado', array(
                'id_usuario' => $idUsuario ,
                'id_evento' => $idEvento,
                'curp_usuario' => $curpUsuario,
                'nombre_evento' => $this->evento->titulo
            )))
            ->line('Gracias por usar nuestra aplicación!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
