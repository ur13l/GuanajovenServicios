$(function() {

    $.each($(".fecha_inicio"), function(index, val) {
      $(val).text(moment($(val).text(), "YYYY-MM-DD").format("DD MMMM, YYYY"));
    });

    $.each($(".fecha_fin"), function(index, val) {
      $(val).text(moment($(val).text(), "YYYY-MM-DD").format("DD MMMM, YYYY"));
    });


    //Muesta el modal con el formulario lleno de informacion para editar
    $(".editar-button").click(function() {
        id_promocion = $($(this).parent().siblings()[0].children[0]).val();
        codigo_promocion = $($(this).parent().siblings()[0].children[1]).val();
        url_promocion = $($(this).parent().siblings()[0].children[2]).val();
        bases = $($(this).parent().siblings()[0].children[3]).val();
        titulo = $($(this).parent().siblings()[0]).text();
        descripcion = $($(this).parent().siblings()[1]).text();
        fecha_inicio = $($(this).parent().siblings()[2]).text();
        fecha_fin = $($(this).parent().siblings()[3]).text();
        titulo = titulo.replace(/\s/g, '');
        $("#editPromocion").openModal();
        $("#editid_promocion").val(id_promocion);
        $("#editdescripcion").val(descripcion);
        $("#editbases").val(bases);
        $("#editfecha_inicio").val(fecha_inicio);
        $("#editfecha_fin").val(fecha_fin);
        $("#editcodigo_promocion").val(codigo_promocion);
        $("#editurl_promocion").val(url_promocion);
        $("#edittitulo").val(titulo);
        $(".isTrue").addClass("active");
    });


    //Necesario para sustituir el select común de HTML5 por el de Materialize
    $('select').material_select();


    $(".datepicker").change(function() {
        $(this).val(moment($(this).val(), "DD MMMM, YYYY").format("DD MMMM, YYYY"));
        var input = $(this);
        var label = $('[for='+input.attr('id')+']');

        if( input.val().length > 0 ){
          label.addClass('active');
        }else {
          label.removeClass('active');
        }
    });

    //Validación de formulario para nueva convocatoria
    $("#form-editar").validate({
        submitHandler: function(form) {
        $("#editfecha_inicio").val(moment($("#editfecha_inicio").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
        $("#editfecha_fin").val(moment($("#editfecha_fin").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
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
        messages: {
            "empresa": "Este campo es obligatorio",
            "convenio": "Este campo es obligatorio",
            "nombre_comercial": "Este campo es obligatorio",
            "razon_social": "Este campo es obligatorio",
            "imagen": "Este campo es obligatorio",
            "estatus": "Este campo es obligatorio",
            "prioridad": "Este campo es obligatorio",
            "url_empresa": "Este campo es obligatorio",
        },
        errorElement: 'div',
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
