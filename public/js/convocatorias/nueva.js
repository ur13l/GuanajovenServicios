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

    //Validación de formulario para nueva convocatoria
    $("#form-crear").validate({
        submitHandler: function(form) {
            $("#fecha_inicio").val(moment($("#fecha_inicio").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
            $("#fecha_cierre").val(moment($("#fecha_cierre").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
            form.submit();
        },
        rules: {
            titulo: {
                required: true
            },
            "fecha_inicio": {
                required: true
            },
            "fecha_cierre": {
                required: true
            },
            descripcion: {
                required: true
            },
            imagen: {
                required: true
            },
            documentos: {
                required: true
            }
        },
        messages:{
            titulo: "Este campo es obligatorio",
            "fecha_inicio": "Este campo es obligatorio",
            "fecha_cierre": "Este campo es obligatorio",
            descripcion: "Este campo es obligatorio",
            imagen: "Este campo es obligatorio",
            documentos: "Este campo es obligatorio",
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
