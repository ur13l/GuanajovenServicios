$(function() {
  //Evita que los campos Date se empalmen
    $('.datepicker').change(function(){
        var input = $(this);
        var label = $('[for='+input.attr('id')+']');

        if( input.val().length > 0 ){
          label.addClass('active');
        }else {
          label.removeClass('active');
        }
    });

    $("#agrega-promocion").click(function() {
        $("#addPromocion").openModal();
    });


  //Necesario para sustituir el select común de HTML5 por el de Materialize
   $('select').material_select();
    //Validación de formulario para nueva convocatoria
    $("#form-crear").validate({
        submitHandler: function(form) {
          $("#fecha_inicio").val(moment($("#fecha_inicio").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
          $("#fecha_fin").val(moment($("#fecha_fin").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
          form.submit();
        },

        rules: {
            "empresa": {
                required: true
            },
            "convenio": {
                required: true
            },
            "nombre_comercial": {
                required: true
            },
            "razon_social": {
                required: true
            },
            "imagen": {
                required: true
            },
            "estatus": {
                required: true
            },
            "prioridad": {
                required: true
            },
            "url_empresa": {
                required: true
            }
        },
        messages:{
            "empresa": "Este campo es obligatorio",
            "convenio": "Este campo es obligatorio",
            "nombre_comercial": "Este campo es obligatorio",
            "razon_social": "Este campo es obligatorio",
            "imagen": "Este campo es obligatorio",
            "estatus": "Este campo es obligatorio",
            "prioridad": "Este campo es obligatorio",
            "url_empresa": "Este campo es obligatorio",
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            $(element).addClass('invalid');
            $(error).css('color', '#F44336 ');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
});
