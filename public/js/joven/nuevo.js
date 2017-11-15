$(function(){
  $('#form-nj').validate({
    rules:{
      ruta_imagen:"required",
      email:"required",
      password:"required",
      confirmar_password: "required",
      nombre:"required",
      apellido_paterno:"required",
      apellido_materno:"required",
      fecha_nacimiento:"required",
      codigo_postal:"required",
      curp:"required"
    },
    messages:{
      ruta_imagen:"Este campo es obligatorio",
      email: "Este campo es obligatorio",
      password: "Este campo es obligatorio",
      confirmar_password: "Este campo es obligatorio",
      nombre: "Este campo es obligatorio",
      apellido_paterno: "Este campo es obligatorio",
      apellido_materno: "Este campo es obligatorio",
      fecha_nacimiento: "Este campo es obligatorio",
      codigo_postal: "Este campo es obligatorio",
      curp: "Este campo es obligatorio"
    },
    errorElement : 'span',
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if($(element).attr('type') == "file"){
            element = $(element).parent().parent().parent().find('[type=text]');
        }
        $(element).addClass('invalid');
        $(error).css('color', '#F44336 ');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element)[0];
        }
    },
    submitHandler:function(form){
     // $("#fecha_nacimiento").val(moment($("#fecha_nacimiento").val(), "DD MMM, YYYY").format("DD/MM/YYYY"));
      form.submit();
    }
  });

  
  $(document).on('click', '#btnSiguiente', function () {
    $("#tab-perfil").removeClass('disabled');
    $("#tab-perfil>a").trigger('click');
    $("#tab-usuario").addClass('disabled')
  });

  $(document).on('click', '#btnSiguiente2', function(){
    $("#tab-documentos").removeClass('disabled');
    $("#tab-documentos>a").trigger('click');
    $("#tab-perfil").addClass('disabled')
  });

  $(document).on('click', "#btnAnterior", function(){
    $("#tab-usuario").removeClass('disabled');
    $("#tab-usuario>a").trigger('click');
    $("#tab-perfil").addClass('disabled')
  });

  $(document).on('click', "#btnAnterior2", function(){
    $("#tab-perfil").removeClass('disabled');
    $("#tab-perfil>a").trigger('click');
    $("#tab-documentos").addClass('disabled')
  });

  //Funcionalidad para obtener CURP y campos correspondientes. 
  $("#curp").on("keyup paste change", function(e){
    var nCar = $(this).val().length;
    if(nCar == 18) {
      $.ajax({
        url: $("#_url").val() + "/api/usuarios/curp",
        method: "POST",
        data: {
          curp: $(this).val()
        },
        success: function(res) {
          $(".label-curp").addClass("active");
          $("#nombre").val(res.data.nombres);
          $("#apellido_paterno").val(res.data.PrimerApellido);
          $("#apellido_materno").val(res.data.SegundoApellido);
          $("#fecha_nacimiento").val(res.data.fechNac);
          $("#id_genero").val(res.data.sexo);
          $("#id_estado_nacimiento").val(res.data.cveEntidadNac);
        }
      })
    }
  });

});

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#image')
              .attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
  }
}
