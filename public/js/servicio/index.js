$(function () {
    
        //Funcionalidad de los botones para eliminar un joven.
       $(document).on('click', '.borrar', function (e) {
            var btn = $(this),
                yesButton = null,
                id;
            $("#modal-borrar").openModal();
            $("#id_orden_atencion").val(btn.data('orden-id'));
        });
    
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getOrdenes(page, $("#icon_search").val());
    
        });
    
        $(".header").on('click', function () {
            if ($(this).find('i').text() == 'arrow_drop_up') {
                $(this).find('i').text('arrow_drop_down');
            } else {
                $(this).find('i').text('arrow_drop_up');
            }
        });
    
    
        $(document).on('click', '.header', function () {
            if (columna == $(this).data('field')) {
                if (tipo == "asc") {
                    tipo = "desc";
                }
                else {
                    tipo = "asc";
                }
            }
            else {
                tipo = "asc";
            }
            columna = $(this).data('field')
    
            getOrdenes(1, $("#icon_search").val());
        });
    
        $("#icon_search").on("keyup paste change", function (e) {
            getOrdenes(1, $(this).val())
        })
    
        $(document).on('click', '.header', function(){
            $("#arrowdown").hide();
            $("#arrowup").show();
            
        })
    
    
    });
    
    var xhr, columna = "fecha_inicio", tipo = "asc";
    function getOrdenes(page, q) {
        if (xhr) {
            xhr.abort();
        }
        xhr = $.ajax({
            url: $("#_url").val() + '/servicios/buscar',
            data: {
                page: page,
                q: q,
                columna: columna,
                tipo: tipo
            }
        }).done(function (data) {
            $("#table").html(data);
        });
    }
    
    