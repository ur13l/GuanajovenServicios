/**
 * Archivo JavaScript para la vista de edición de convocatorias
 * Autor: Uriel Infante
 * Fecha: 04/05/17
 */


jQuery.validator.addMethod('fecha_menor', (value, element, params) => {
    var fechaInicio = moment($(params[0]).val(), "DD MMM, YYYY"),
        fechaFin = moment(value, "DD MMM, YYYY");

    return fechaFin.isAfter(fechaInicio);
});

$(function() {


    var counter = 0;
    //Se asigna un formato a las fechas a la hora que carga la interfaz
    $("#fecha_inicio").val(moment($("#fecha_inicio").val(), "YYYY-MM-DD").format("DD MMMM, YYYY"));
    $("#fecha_cierre").val(moment($("#fecha_cierre").val(), "YYYY-MM-DD").format("DD MMMM, YYYY"));

    $(".datepicker").change(function() {

        $(this).val(moment($(this).val(), "DD MMMM, YYYY").format("DD MMMM, YYYY"))
    })

    //Funcionalidad de botón eliminar
    $(".delete-doc").click(function(event) {
        var elem = $(this).parent().parent().parent(),
            id = $(this).data('id');
        $("#deleteModalDoc").openModal();

        /**
         * Se asigna el evento al botón de yes para
         */
        $("#yesBtn").unbind()
            .click({
                elem: elem,
                id: id
            }, function(event) {
                var arrIds = JSON.parse($("#input-deleted-docs").val());
                arrIds.push(id);
                $("#input-deleted-docs").val(JSON.stringify(arrIds));
                event.data.elem.remove();
                $("#deleteModalDoc").closeModal();
            });
    });

    //Funcionalidad de botón eliminar en nuevos
    $(document).on('click', '.delete-doc-nuevo', function(event) {
        var elem = $(this).parent().parent().parent();
        $("#deleteModalDoc").openModal();

        /**
         * Se asigna el evento al botón de yes para
         */
        $("#yesBtn").unbind()
            .click({
                elem: elem
            }, function(event) {
                event.data.elem.remove();
                $("#deleteModalDoc").closeModal();
            });
    });

    //Funcionalidad de botón Agregar documento
    $("#agregar-documento").click(function() {
        var section = $("<div class='section'/>"),
            row = $("<div class='row'/>"),
            img = $("<div class='col m2 hide-on-small-and-down'/>"),
            spanImg = $("<span class='col l12 center-align'>"),
            divTitulo = $("<div class='input-field col s5 l6'/>"),
            divFile = $("<div class='file-field input-field col s5 m3 l2'/>"),
            divX = $("<div class='col s2'/>"),
            spanX = $("<span class='col s12 center-align'>");

        //Se agrega la imagen al div img;
        spanImg.append('<img src="../../img/ic_unknow.png" alt="">');
        img.append(spanImg);
        //Se agrega input y label de título
        divTitulo
            .append(`<input class="doc-titulo-nuevo" name="doc-titulo-nuevo[${counter}]" type="text" value=""  class="validate">`)
            .append('<label for="titulo">Título</label>');
        //Se agregan los inputs de archivo
        divFile.append(`
           <div class="btn accent-color">
                <span>Agregar </span>
                <input type="file" class="input-file-nuevo" name="doc-file-nuevo[${counter}]" >
            </div>
        `);

        //El div para cerrar
        spanX.append(`
           <a class="large center center-align delete-doc grey-text" style="margin-top:30px; cursor: pointer" ><i class="material-icons">delete</i></a> 
        `);
        divX.append(spanX);

        row.append(img)
            .append(divTitulo)
            .append(divFile)
            .append(divX);

        section.append(row);

        counter++;

        //Se agrega el documento al HTML container
        $("#doc-container").append(section);

        //Método utilizado para validar los inputs file.
        $(".input-file-nuevo").each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Cargar el archivo es obligatorio. "
                }

            });
        });

        //Método utilizado para validar los inputs file.
        $(".doc-titulo-nuevo").each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Escriba el título del documento. "
                }

            });
        });
    });

    //Validación de formulario para nueva convocatoria
    $("#form-editar").validate({
        submitHandler: function(form) {
            $("#fecha_inicio").val(moment($("#fecha_inicio").val(), "DD MMMM, YYYY").format("YYYY-MM-DD"));
            $("#fecha_cierre").val(moment($("#fecha_cierre").val(), "DD MMMM, YYYY").format("YYYY-MM-DD"));
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
                required: true,
                fecha_menor: ["#fecha_inicio"]
            },
            descripcion: {
                required: true
            },
            "doc-file-nuevo": {
                required: true
            }
        },
        messages: {
            titulo: "Este campo es obligatorio",
            fecha_inicio: "Este campo es obligatorio",
            fecha_cierre: {
                required: "Este campo es obligatorio",
                fecha_menor: "La fecha de cierre debe ser después de la de apertura"
            },
            descripcion: "Este campo es obligatorio",
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if ($(element).attr('type') == "file") {
                element = $(element).parent().parent().parent().find('[type=text]');
            }
            $(element).addClass('invalid');
            $(error).css('color', '#F44336 ');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element)[0];
            }
        }
    });

    //Método para cambiar la imagen
    $("#imagen").on('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#img-convocatoria")
                    .error(() => $("#img-convocatoria").attr("src", "../../img/ic_unknow.png"))
                    .attr('src', e.target.result)
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    $("#imagen").change(function() {
        $("#img-convocatoria").attr('src', $(this).val());
    });


    $("#input-doc-file").change(function(event) {

    });

    $(document).on('change', ".input-file-nuevo, .input-doc-file", function(event) {

        var span = $(this).parent().find('span'),
            fileName = $(this).val(),
            ext = fileName.split('.').pop(),
            img = $($(this).parent().parent().parent().find('img'));


        switch (ext) {

            case "pdf":
                img.attr('src', '../../img/ic_pdf.png');
                break;
            case "doc":
            case "docx":
                img.attr('src', '../../img/ic_doc.png');
                break;
            case "xlsx":
            case "xls":
                img.attr('src', '../../img/ic_xls.png');
                break;
            default:
                img.attr('src', '../../img/ic_unknow.png');
                break;

        }
        span.html("Cambiar");
    });
});