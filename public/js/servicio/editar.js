$(function() {
    
        //Marca los selects con el estilo de Material Design.
        $('select').material_select();
    
        //Lógica para el autocomplete de usuario responsable.
        $('#id_usuario_responsable_autocomplete').materialize_autocomplete({
            multiple: {
                enable: false
            },
            dropdown: {
                el: '#usuarioResponsableDropdown',
                itemTemplate: '<li class="ac-item" data-id="<%= item.id %>" data-text=\'<%= item.text %>\'><a href="javascript:void(0)"><%= item.highlight %></a></li>'
            },
            onSelect: function (item) {
                $('#id_usuario_responsable').val(item.id);
            },
            getData: function (value, callback) {
                $.get($("#_url").val() + "/servicios/usuariosautocomplete", {q: value}).success(function(data) {
                    callback(value, JSON.parse(data));
                  });
                
            }
        });
    
        //Autocompletar múltiple de usuarios involucrados.
        $('#id_usuarios_involucrados_autocomplete').materialize_autocomplete({
            multiple: {
                enable: true
            },
            appender: {
                el: '.ac-users'
            },
            hidden: {
                enable: true,
                inputName: 'id_usuarios_involucrados'
            },
            dropdown: {
                el: '#usuariosInvolucradosDropdown'
            },onSelect: function (item) {
                console.log(item);
            },
            onAppend: function(item) {
                console.log(item);
            },
            getData: function (value, callback) {
                $.get($("#_url").val() + "/servicios/usuariosautocomplete", {q: value}).success(function(data) {
                    callback(value, JSON.parse(data));
                  });
                
            }
        });
    
        //Autocompletar autocomplete de joven responsable.        
        $('#id_joven_responsable_autocomplete').materialize_autocomplete({
            multiple: {
                enable: false
            },
            dropdown: {
                el: '#jovenResponsableDropdown',
                itemTemplate: '<li class="ac-item" data-id="<%= item.id %>" data-text=\'<%= item.text %>\'><a href="javascript:void(0)"><%= item.highlight %></a></li>'
            },
            onSelect: function (item) {
                $('#id_joven_responsable').val(item.id);
            },
            getData: function (value, callback) {
                $.get($("#_url").val() + "/servicios/jovenesautocomplete", {q: value}).success(function(data) {
                    callback(value, JSON.parse(data));
                  });
                
            }
        });
    
        //Autocomplete múltiple para beneficiados relacionados.
        $('#id_beneficiados_relacionados_autocomplete').materialize_autocomplete({
            multiple: {
                enable: true
            },
            appender: {
                el: '.ac-jovenes'
            },
            hidden: {
                enable: true,
                inputName: 'id_beneficiados_relacionados'
            },
            dropdown: {
                el: '#jovenesInvolucradosDropdown'
            },onSelect: function (item) {
            },
            onAppend: function(item) {
            },
            getData: function (value, callback) {
                $.get($("#_url").val() + "/servicios/jovenesautocomplete", {q: value}).success(function(data) {
                    callback(value, JSON.parse(data));
                  });
                
            }
        });
    
        //Validación de formulario para nuevo usuario
        $("#form").validate({
            submitHandler: function(form) {
                $("#fecha_inicio").val(moment($("#fecha_inicio").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
                $("#fecha_propuesta").val(moment($("#fecha_propuesta").val(), "DD MMM, YYYY").format("YYYY-MM-DD"));
                form.submit();
            },
            ignore: [], 
            rules: {
                "titulo": { required: true },
                "descripcion": { required: true },
                "fecha_inicio": { required: true },
                "fecha_propuesta": { required: true },
                "costo_estimado": { required: true },
                "id_centro_poder_joven": { required: true },
                "id_servicio": { required: true },
                "id_joven_responsable": { required: true },
                "id_usuario_responsable": { required: true }
            },
            messages:{
                "titulo": "Este campo es obligatorio",
                "descripcion": "Este campo es obligatorio",
                "fecha_inicio": "Este campo es obligatorio",
                "fecha_propuesta": "Este campo es obligatorio",
                "costo_estimado": "Este campo es obligatorio",
                "id_centro_poder_joven": "Este campo es obligatorio",
                "id_servicio": "Este campo es obligatorio",
                "id_joven_responsable": "Este campo es obligatorio",
                "id_usuario_responsable": "Este campo es obligatorio"
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

        var counter = 0;

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
            divTitulo = $("<div class='input-field col s5 l6'/>"),
            divFile = $("<div class='file-field input-field col s5 m3 l2'/>"),
            divX = $("<div class='col s2'/>"),
            spanX = $("<span class='col s12 center-align'>");

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

        row.append(divTitulo)
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
})