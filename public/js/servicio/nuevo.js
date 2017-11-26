$(function() {
    $('select').material_select();
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

    $('#id_usuarios_involucrados_autocomplete').materialize_autocomplete({
        multiple: {
            enable: true
        },
        appender: {
            el: '.ac-users'
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
            $.get($("#_url").val() + "/servicios/usuariosautocomplete", {q: value}).success(function(data) {
                callback(value, JSON.parse(data));
              });
            
        }
    });
})