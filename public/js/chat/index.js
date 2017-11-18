$(function() {

    function btn_resize() {
        if ($(window).width() <= 970) {
            $('#enviarMensaje').html('<i class="material-icons right">send</i>');
            $('#enviarMensaje').css({
                'width': '1.3cm',
                'border-radius': '30px',
                'height': '47px',
                'padding-top': '10px'
            });
        } else {

            $('#enviarMensaje').html('Enviar<i class="material-icons right">send</i>');
            $('#enviarMensaje').css({
                'width': '2.8cm',
                'border-radius': '0px',
                'height': '40px',
                'padding-top': '7px'
            });
        }
    }
    btn_resize();

    $(window).resize(function(event) {
        btn_resize();
    });

    $("#buscarUsuarios").keyup(function() {

        var buscar = $(this).val();
        var html;

        //Si no hay nada en el buscador reinicia la lista
        if (buscar.length == 0) {
            $.ajax({
                url: $("#_url").val() + "/api/chat/recargaListaChats",
                method: "POST",
                success: function(data) {
                    var lista_chats = $('#lista-chats');
                    lista_chats.html("");

                    jQuery.each(data, function(index, val) {
                        val.no_leidos = val.no_leidos == 0 ? '' : val.no_leidos;
                        lista_chats.append(
                            '      <a href="#!" class="collection-item avatar chat-item">' +
                            '      <input type="hidden" value="' + val.id + '" id="chat' + val.id + '">' +
                            '              <img src="' + val.ruta_imagen + '" alt="" class="circle">' +
                            '          <span  class="title accent-color-text">' + val.nombre + '</span>' +
                            '          <p class="grey-text ultimoMensaje">' + val.ultimo_mensaje + '</p>' +
                            '          <p class="grey-text secondary-content fechaUltimo" style="margin-top:-5px" href="#!">' + val.fecha_ultimo + '</p>' +
                            '          <p href="#!"  class="secondary-content primary-color-text"><span style="margin-top:25px" class="badge noLeidos">' + val.no_leidos + '</span></p>' +
                            '      </a>');
                    });
                    chat_item_event();
                    user_item_event();

                }
            });
        } else {
            $.ajax({
                url: $("#_url").val() + "/api/chat/buscarUsuarios",
                method: "POST",
                data: {
                    busqueda: buscar
                },
                success: function(data) {
                    var lista_chats = $('#lista-chats');
                    lista_chats.html("");

                    jQuery.each(data, function(index, val) {

                        var idItem = val.chat_id !== null ? val.chat_id : val.user_id;
                        var claseItem = val.chat_id !== null ? 'chat-item' : 'user-item';
                        val.no_leidos = val.no_leidos > 0 ? val.no_leidos : '';

                        lista_chats.append(
                            '      <a href="#!" class="collection-item avatar ' + claseItem + '">' +
                            '      <input type="hidden" value="' + idItem + '" id="chat' + idItem + '">' +
                            '              <img src="' + val.ruta_imagen + '" alt="" class="circle">' +
                            '          <span  class="title accent-color-text">' + val.nombre + '</span>' +
                            '          <p class="grey-text ultimoMensaje">' + val.ultimo_mensaje + '</p>' +
                            '          <p class="grey-text secondary-content fechaUltimo" style="margin-top:-5px" href="#!">' + val.fecha_ultimo + '</p>' +
                            '          <p href="#!"  class="secondary-content primary-color-text"><span style="margin-top:25px" class="badge noLeidos">' + val.no_leidos + '</span></p>' +
                            '      </a>');
                    });

                    chat_item_event();
                    user_item_event();

                }
            });
        }

    });

    $("#form_enviar").submit(function() {
        var mensaje = $("#mensaje").val();
        $("#lista-mensajes").append("<li class='mensaje-derecha accent-color'>" + mensaje + "</li>");
        $("#lista-mensajes")[0].scrollTop = $("#lista-mensajes")[0].scrollHeight;
        $("#mensaje").val('');
        $('#lista-chats').prepend($('#chat' + $('#_active_chat').val()).parent());
        $.ajax({
            url: $("#_url").val() + "/api/chat/enviarAdmin",
            method: "POST",
            data: {
                "mensaje": mensaje,
                "api_token": $("#_api_token").val(),
                "active_chat": $("#_active_chat").val()
            },
            success: function(data) {
                var hora = new Date();

                $('#chat' + $('#_active_chat').val()).parent('a').find('.ultimoMensaje').html(mensaje);
                $('#chat' + $('#_active_chat').val()).parent('a').find('.fechaUltimo').html(hora.getHours() + ':' + hora.getMinutes());
                $('#chat' + $('#_active_chat').val()).parent('a').find('.noLeidos').html('');

                $('#chat' + $('#_active_chat').val()).parent('a').trigger('click');

            }
        });

        return false;
    });

    function chat_item_event() {
        $(".chat-item").click(function() {

            var idChat = $(this).find("[type=hidden]").val();
            $("#_active_chat").val(idChat);

            $.ajax({
                url: $("#_url").val() + "/api/chat/mensajesAdmin",
                method: "POST",
                data: {
                    api_token: $("#_api_token").val(),
                    id_chat: idChat,
                    page: '1'
                },
                success: function(data) {


                    mensajes = data.data;
                    $('#chat' + idChat).parent('a').find('.noLeidos').html('');
                    $("#lista-mensajes").html("");
                    var hoy = new Date();
                    hoy = [hoy.getDate(), hoy.getMonth() + 1, hoy.getFullYear()].join('/');

                    for (var i = 0, max = mensajes.length; i < max; i++) {

                        console.log(mensajes[i].created_at);
                        fecha_mensaje = new Date(mensajes[i].created_at.split(' ')[0].replace(/-/g, ' '));
                        fecha_mensaje = [fecha_mensaje.getDate(), fecha_mensaje.getMonth() + 1, fecha_mensaje.getFullYear()].join('/');

                        fecha = fecha_mensaje == hoy ?
                            //Toma la hora y elimina los segundos
                            mensajes[i].created_at.split(' ')[1].split(':')[0] + ':' + mensajes[i].created_at.split(' ')[1].split(':')[1] :
                            //Toma la fecha
                            fecha_mensaje;


                        if (mensajes[i].envia_usuario) {
                            $("#lista-mensajes").prepend("<li class='mensaje-izquierda primary-color'>" + mensajes[i].mensaje +
                                "<br><div class='fecha_mensaje'>" + fecha +
                                "</div><div style='display:none;' class='fecha_mensaje full_fecha'>" +
                                fecha_mensaje + ' ' + mensajes[i].created_at.split(' ')[1] + "</div></li>");
                        } else {
                            $("#lista-mensajes").prepend("<li class='mensaje-derecha accent-color'>" + mensajes[i].mensaje +
                                "<br><div class='fecha_mensaje'>" + fecha +
                                "</div><div style='display:none;' class='fecha_mensaje full_fecha'>" +
                                fecha_mensaje + ' ' + mensajes[i].created_at.split(' ')[1] + "</div></li>");
                        }



                        $('#lista-mensajes > li').first().mouseenter(function() {
                            $(this).find('.fecha_mensaje:first()').css('display', 'none');
                            $(this).find('.fecha_mensaje:last()').css('display', 'block');
                        });

                        $('#lista-mensajes > li').first().mouseleave(function() {
                            $(this).find('.fecha_mensaje:first()').css('display', 'block');
                            $(this).find('.fecha_mensaje:last()').css('display', 'none');
                        });


                    }
                    $("#lista-mensajes")[0].scrollTop = $("#lista-mensajes")[0].scrollHeight;
                }
            })
        });
    }
    chat_item_event();


    function user_item_event() {
        $(".user-item").click(function() {

            var idUser = $(this).find("[type=hidden]").val();

            $.ajax({
                url: $("#_url").val() + "/api/chat/nuevoChat",
                method: "POST",
                data: {
                    user_id: idUser
                },
                success: function(data) {
                    console.log(data);

                    $(this).removeClass('user-item');
                    $(this).addClass('chat-item');
                    $("#_active_chat").val(data);


                    $("#lista-mensajes").html("");
                    $("#lista-mensajes")[0].scrollTop = $("#lista-mensajes")[0].scrollHeight;
                }
            })
        });
    }
    user_item_event();


});


function actualizarListaChat() {
    $("#lista-chats").empty();
}
