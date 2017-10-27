$(document).ready(function(){
  //Configuración para generar el SideNav
  $(".button-collapse").sideNav();

  //Configuración para abrir modal
  $('.modal-trigger').leanModal();

  //Configuración del datePicker
  $('.datepicker').pickadate({
    labelMonthNext: 'Siguiente',
    labelMonthPrev: 'Anterior',
    labelMonthSelect: 'Selecciona un mes',
    labelYearSelect: 'Selecciona un año',
    monthsFull: [ 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' ],
    monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
    weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
    weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb' ],
    weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Cerrar',
    format: "dd/mm/yyyy",
    modal: false
  });

  //Configuración del TimePicker
  $('.timepicker').lolliclock({
    autoclose:true,
    hour24: true
  });

  if(moment($("#fecha-inicio").val()).format("DD MMMM, YYYY") != "Invalid date") {
    $("#fecha-inicio").val(moment($("#fecha-inicio").val()).format("DD MMMM, YYYY"));
  }
  if(moment($("#fecha-fin").val()).format("DD MMMM, YYYY") != "Invalid date"){
    $("#fecha-fin").val(moment($("#fecha-fin").val()).format("DD MMMM, YYYY"));
  }

  if(location.href.includes("nuevo")) {
    $("#hora-inicio").val("");
    $("#hora-fin").val("");
  }

  //Necesario para sustituir el select común de HTML5 por el de Materialize
   $('select').material_select();

  //Se ejecuta al darle click al botón de más, permite configurar la acción a 'create'
   /*$('#new-event').on('click', function(){
     action = 'create';
     id = null;
     limpiarCampos();
   });*/

   // for HTML5 "required" attribute
   $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});

   $(".vald").change(function(){
     $(this).removeClass("invalid");
   });


   //Manejador del botón de eliminar selección
   $("#delete-selection").on('click', function(){
     $("#delete-message").html("¿Confirma que desea eliminar los eventos seleccionados?");
     dialogDelete();
   });

   //Cambiar el mensaje de la interfaz
   $(".brand-logo").html("&nbsp Eventos");

   $('#tipo-evento').on('change', function () {
       $('#tipo-seleccionado').val($('#tipo-evento').val());
   });

   /*
   //Eliminar evento
    $('.delete').on('click', function () {
        var item_evento = $(this).parent();
        var id_evento = $(item_evento).find('.id').val();
        var url = $('#_url').val() + '/eventos/eliminar';

        $.ajax({
            url: url,
            data: { 'idEvento': id_evento },
            type: 'POST',
            dataType: 'JSON',
            error: function (xhr) {
                Materialize.toast('Ocurrió un error, vuelve a intentarlo', 3000, 'red');
            },
            success: function (respuesta) {
                if (respuesta.status == 200) {
                    $(item_evento).remove();
                    Materialize.toast('Evento eliminado', 3000, 'blue');
                } else {
                    Materialize.toast('Ocurrió un error, vuelve a intentarlo', 3000, 'red');
                }
            }
        });
    });
    */

   //Verificar datos y guardar el evento
   $('#guardar-evento').on('click', function () {
        var titulo = $('#titulo').val();
        var descripcion = $('#descripcion').val();
        var puntos = $('#puntos-otorgados').val();
        var area = $('#area-responsable').val();
        var tipo_evento = $('#tipo-seleccionado').val();
        var fecha_inicio = $('#fecha-inicio').val();
        var fecha_fin = $('#fecha-fin').val();
        var hora_inicio = $('#hora-inicio').val();
        var hora_fin = $('#hora-fin').val();
        var tipo_evento = $("#tipo-evento").val();
        var evaluar_fecha = false;

        if (titulo == '' || titulo == null) {
            $('#titulo').addClass('invalid');
        } else {
            $('#titulo').removeClass('invalid');
        }

        if (descripcion == '' || descripcion == null) {
            $('#descripcion').addClass('invalid');
        } else {
            $('#descripcion').removeClass('invalid');
        }

        if (puntos == '' || puntos == null) {
            $('#puntos-otorgados').addClass('invalid');
        } else {
            $('#puntos-otorgados').removeClass('invalid');
        }

        if (area == '' || area == null) {
            $('#area-responsable').addClass('invalid');
        } else {
            $('#area-responsable').removeClass('invalid');
        }

        if (tipo_evento == '0') {
            $('#tipo-evento').addClass('invalid');
        } else {
            $('#tipo-evento').removeClass('invalid');
        }

        if (fecha_inicio == '' || fecha_inicio == null) {
            $('#fecha-inicio').addClass('invalid');
            evaluar_fecha = false;
        } else {
            $('#fecha-inicio').removeClass('invalid');
            evaluar_fecha = true;
        }

        if (fecha_fin == '' || fecha_fin == null) {
            $('#fecha-fin').addClass('invalid');
            evaluar_fecha = false;
        } else {
            $('#fecha-fin').removeClass('invalid');
            evaluar_fecha = true;
        }

        if (hora_inicio == '' || hora_inicio == null) {
            $('#hora-inicio').addClass('invalid');
            evaluar_fecha = false;
        } else {
            $('#hora-inicio').removeClass('invalid');
            evaluar_fecha = true;
        }

        if (hora_fin == '' || hora_fin == null) {
            $('#hora-fin').addClass('invalid');
            evaluar_fecha = false;
        } else {
            $('#hora-fin').removeClass('invalid');
            evaluar_fecha = true;
        }

        var mensaje_fecha = false;
        if (evaluar_fecha) {
            if (fecha_inicio == fecha_fin) {
                if (hora_fin < hora_inicio || hora_inicio == hora_fin) {
                    $('#hora-inicio').addClass('invalid');
                    $('#hora-fin').addClass('invalid');
                    Materialize.toast('La hora de finalización debe ser mayor a la hora de inicio', 3000, 'red');
                    mensaje_fecha = true;
                }
            } else if (fecha_inicio > fecha_fin) {
                $('#fecha-inicio').addClass('invalid');
                $('#fecha-fin').addClass('invalid');
                Materialize.toast('La fecha de finalización debe ser mayor a la fecha de inicio', 3000, 'red');
                mensaje_fecha = true;
            }
        }

        var valido = $('#form-nuevo-evento').find('.invalid').length;
        if (valido == 0) {
            $('#form-nuevo-evento').submit();
        } else if (!mensaje_fecha) {
            Materialize.toast('Llena todos los campos', 3000, 'red');
        }
   });

   /**
    * Función index para eliminar
    */
    $(".deleteP").click(function(){
        var btn = $(this),
            yesButton = null,
            id;
        $('#deleteModalEv').openModal();
        $("#id-eliminar").val(btn.data('id'));
    });
});

