$(function() {
    $('select').material_select();
    $('#id_usuario_responsable').autocomplete({
        serviceUrl: '/servicios/usuariosautocomplete',
        onSelect: function (suggestion) {
            alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
        }
    });
})