---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#general
<!-- START_b7802a3a2092f162a21dc668479801f4 -->
## api/password/email

> Example request:

```bash
curl -X POST "http://localhost/api/password/email" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/password/email",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/password/email`


<!-- END_b7802a3a2092f162a21dc668479801f4 -->

<!-- START_ded4fcd6b8ce5859e30b09d01516edcb -->
## Metodo para la obtención de los items publicitarios que se estarán mostrando en la interfaz principal.

> Example request:

```bash
curl -X GET "http://localhost/api/publicidad" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/publicidad",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/publicidad`

`HEAD api/publicidad`


<!-- END_ded4fcd6b8ce5859e30b09d01516edcb -->

<!-- START_b1cd176a3c4faeabcd5ccbc9c02f65e5 -->
## Metodo para la obtención de convocatorias para la app.

> Example request:

```bash
curl -X GET "http://localhost/api/convocatorias" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/convocatorias",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/convocatorias`

`HEAD api/convocatorias`


<!-- END_b1cd176a3c4faeabcd5ccbc9c02f65e5 -->

<!-- START_3a3b60028c482137634cbd74524f1c83 -->
## Metodo para la obtención de convocatorias para la app.

> Example request:

```bash
curl -X GET "http://localhost/api/promociones" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/promociones",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/promociones`

`HEAD api/promociones`


<!-- END_3a3b60028c482137634cbd74524f1c83 -->

<!-- START_564843c54c8123bc3232e46168d12c88 -->
## api/regiones

> Example request:

```bash
curl -X GET "http://localhost/api/regiones" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/regiones",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/regiones`

`HEAD api/regiones`


<!-- END_564843c54c8123bc3232e46168d12c88 -->

<!-- START_b60ed79217f7964a3d339fe4822f4c2a -->
## api/eventos

> Example request:

```bash
curl -X GET "http://localhost/api/eventos" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/eventos",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/eventos`

`HEAD api/eventos`


<!-- END_b60ed79217f7964a3d339fe4822f4c2a -->

<!-- START_c830eaf07ec11546fbdf3d175b7bfd51 -->
## api/eventos/marcar

> Example request:

```bash
curl -X POST "http://localhost/api/eventos/marcar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/eventos/marcar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/eventos/marcar`


<!-- END_c830eaf07ec11546fbdf3d175b7bfd51 -->

<!-- START_3d3b9b4b1fb504d267251ac566576528 -->
## api/eventos/registrar

> Example request:

```bash
curl -X POST "http://localhost/api/eventos/registrar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/eventos/registrar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/eventos/registrar`


<!-- END_3d3b9b4b1fb504d267251ac566576528 -->

<!-- START_3479dce9d625a42cca93da7a9ed08661 -->
## api/notificacionres

> Example request:

```bash
curl -X GET "http://localhost/api/notificacionres" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificacionres",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/notificacionres`

`HEAD api/notificacionres`


<!-- END_3479dce9d625a42cca93da7a9ed08661 -->

<!-- START_a7cf10f84c7898002f9249002c76a179 -->
## api/eventos/usuariosregistrados

> Example request:

```bash
curl -X GET "http://localhost/api/eventos/usuariosregistrados" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/eventos/usuariosregistrados",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "status": 200,
    "success": true,
    "errors": [],
    "data": []
}
```

### HTTP Request
`GET api/eventos/usuariosregistrados`

`HEAD api/eventos/usuariosregistrados`


<!-- END_a7cf10f84c7898002f9249002c76a179 -->

<!-- START_f3fea2bc784869610a889ca9cf2cb964 -->
## api/eventos/usuariosinteresados

> Example request:

```bash
curl -X GET "http://localhost/api/eventos/usuariosinteresados" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/eventos/usuariosinteresados",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "status": 200,
    "success": true,
    "errors": [],
    "data": []
}
```

### HTTP Request
`GET api/eventos/usuariosinteresados`

`HEAD api/eventos/usuariosinteresados`


<!-- END_f3fea2bc784869610a889ca9cf2cb964 -->

<!-- START_d2e6e9773f8741e58c5e9832e9fdee01 -->
## Función para verificar el acceso de un usuario API

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/login" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/login",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/login`


<!-- END_d2e6e9773f8741e58c5e9832e9fdee01 -->

<!-- START_21b088fbbb121561b4d6aa8a587f95f4 -->
## Usuario: Registrar
params: [curp*, email, password*, password_confirmation*, nombre*, apellido_paterno*, apellido_materno*, genero*,
codigo_postal*, fecha_nacimiento*, estado_nacimiento, id_ocupacion, telefono, estado, ruta_imagen, id_google, id_facebook].

Método que sirve para registrar usuarios.

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/registrar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/registrar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/registrar`


<!-- END_21b088fbbb121561b4d6aa8a587f95f4 -->

<!-- START_20b5adfbd9143f4e0cad0836ffedec2b -->
## Usuario: Actualizar
params: [nombre*, id_genero*, codigo_postal*, apellido_paterno*, curp*, estado_nacimiento*, fecha_nacimiento,
estado_nacimiento, id_ocupacion, telefono, id_estado, id_municipio].

Función que permite la actualización de datos de un usuario, la información principal no puede ser modificada.

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/actualizar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/actualizar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/actualizar`


<!-- END_20b5adfbd9143f4e0cad0836ffedec2b -->

<!-- START_de216853be6ccf9e6c46f33aec68ac48 -->
## Usuario: Verificar Email
params: [email]
Método que revisa la existencia de un email registrado en la base de datos.

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/verificarcorreo" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/verificarcorreo",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/verificarcorreo`


<!-- END_de216853be6ccf9e6c46f33aec68ac48 -->

<!-- START_d22e5bc16440fc4164d8c616c5bacc0c -->
## Función para verificar el acceso de usuario mediante Googl

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/logingoogle" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/logingoogle",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/logingoogle`


<!-- END_d22e5bc16440fc4164d8c616c5bacc0c -->

<!-- START_17696e8ccdcda7ee1a4de34c33d89356 -->
## Función para verificar el acceso de usuario mediante Facebook

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/loginfacebook" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/loginfacebook",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/loginfacebook`


<!-- END_17696e8ccdcda7ee1a4de34c33d89356 -->

<!-- START_e8c41ed5554ca9adc0005f3dbac43142 -->
## Función para logueo de administradores

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/login_admin" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/login_admin",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/login_admin`


<!-- END_e8c41ed5554ca9adc0005f3dbac43142 -->

<!-- START_9f45dca9b2c6e559fb610a3b4c5d65b2 -->
## Usuario: Obtener CURP
params: [curp].

Método público para la obtención de datos pasando como parámetro un CURP válido.

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/curp" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/curp",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/curp`


<!-- END_9f45dca9b2c6e559fb610a3b4c5d65b2 -->

<!-- START_b16886e5139d99d533fa301bbb72fdcd -->
## public: getPosition
Método que devuelve la posición del usuario

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/posicion" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/posicion",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/posicion`


<!-- END_b16886e5139d99d533fa301bbb72fdcd -->

<!-- START_3fb0b69821f1faff6d72e7610911f0b1 -->
## api/usuarios/actualizar-token-guanajoven

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/actualizar-token-guanajoven" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/actualizar-token-guanajoven",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/actualizar-token-guanajoven`


<!-- END_3fb0b69821f1faff6d72e7610911f0b1 -->

<!-- START_a5c6310c3509d478f05f37ef97fbd242 -->
## Perfil: Actualizar
params: [id_nivel_estudios*, id_pueblo_indigena*, id_capacidad_diferente*, premios*, proyectos_sociales*, apoyo_proyectos_sociales*,
api_token].

Función que actualiza el perfil del usuario.

> Example request:

```bash
curl -X POST "http://localhost/api/profile/update" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/profile/update",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/profile/update`


<!-- END_a5c6310c3509d478f05f37ef97fbd242 -->

<!-- START_d39253d97516a63d1f99e288899f56df -->
## Perfil: Devuelve información
params: [] api_token].

Función que devuelve el perfil del usuario.

> Example request:

```bash
curl -X POST "http://localhost/api/profile/get" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/profile/get",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/profile/get`


<!-- END_d39253d97516a63d1f99e288899f56df -->

<!-- START_70e91d78bffe5e8d92d159e22db749ae -->
## Notificación: RegistrarToken
params: [id_usuario, device_token, os]
Función para guardar un nuevo token de dispositivo y asociarlo a una cuenta de usuario.

> Example request:

```bash
curl -X POST "http://localhost/api/notificaciones/enviartoken" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificaciones/enviartoken",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/notificaciones/enviartoken`


<!-- END_70e91d78bffe5e8d92d159e22db749ae -->

<!-- START_00b38dcb08eb8dcb4cd63733c81de971 -->
## Función para eliminar un token de dispositivo de la base de datos

> Example request:

```bash
curl -X POST "http://localhost/api/notificaciones/cancelartoken" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificaciones/cancelartoken",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/notificaciones/cancelartoken`


<!-- END_00b38dcb08eb8dcb4cd63733c81de971 -->

<!-- START_dc38e9e8368c2dcaf0b58b9655aebb1f -->
## api/notificaciones/convocatoria

> Example request:

```bash
curl -X POST "http://localhost/api/notificaciones/convocatoria" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificaciones/convocatoria",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/notificaciones/convocatoria`


<!-- END_dc38e9e8368c2dcaf0b58b9655aebb1f -->

<!-- START_ff98ccc101211aeb2d68239b521a5d7a -->
## api/notificaciones/evento

> Example request:

```bash
curl -X POST "http://localhost/api/notificaciones/evento" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificaciones/evento",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/notificaciones/evento`


<!-- END_ff98ccc101211aeb2d68239b521a5d7a -->

<!-- START_e4719b4b11ad6ef40aa8fb09e9e356d3 -->
## Función para obtener url dando el título y mensaje

> Example request:

```bash
curl -X POST "http://localhost/api/notificaciones/notificacionurl" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificaciones/notificacionurl",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/notificaciones/notificacionurl`


<!-- END_e4719b4b11ad6ef40aa8fb09e9e356d3 -->

<!-- START_fff188eea050f5933a2f36963460eb14 -->
## api/notificaciones/convocatoria/registrada

> Example request:

```bash
curl -X GET "http://localhost/api/notificaciones/convocatoria/registrada" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificaciones/convocatoria/registrada",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/notificaciones/convocatoria/registrada`

`HEAD api/notificaciones/convocatoria/registrada`

`POST api/notificaciones/convocatoria/registrada`

`PUT api/notificaciones/convocatoria/registrada`

`PATCH api/notificaciones/convocatoria/registrada`

`DELETE api/notificaciones/convocatoria/registrada`

`OPTIONS api/notificaciones/convocatoria/registrada`


<!-- END_fff188eea050f5933a2f36963460eb14 -->

<!-- START_791c9c793b50e8e8fa4a5c508c70f88e -->
## api/notificaciones/evento/registrado

> Example request:

```bash
curl -X GET "http://localhost/api/notificaciones/evento/registrado" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/notificaciones/evento/registrado",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/notificaciones/evento/registrado`

`HEAD api/notificaciones/evento/registrado`

`POST api/notificaciones/evento/registrado`

`PUT api/notificaciones/evento/registrado`

`PATCH api/notificaciones/evento/registrado`

`DELETE api/notificaciones/evento/registrado`

`OPTIONS api/notificaciones/evento/registrado`


<!-- END_791c9c793b50e8e8fa4a5c508c70f88e -->

<!-- START_3348fa3af7b358fc3531b8655947bac3 -->
## api/chat/enviar

> Example request:

```bash
curl -X POST "http://localhost/api/chat/enviar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/chat/enviar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/chat/enviar`


<!-- END_3348fa3af7b358fc3531b8655947bac3 -->

<!-- START_210b7ecbd7a31bd63c533853fae41813 -->
## api/chat/mensajes

> Example request:

```bash
curl -X POST "http://localhost/api/chat/mensajes" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/chat/mensajes",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/chat/mensajes`


<!-- END_210b7ecbd7a31bd63c533853fae41813 -->

<!-- START_aa0a350da3ac46965be3c669b789ebd7 -->
## api/chat/mensajesAdmin

> Example request:

```bash
curl -X POST "http://localhost/api/chat/mensajesAdmin" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/chat/mensajesAdmin",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/chat/mensajesAdmin`


<!-- END_aa0a350da3ac46965be3c669b789ebd7 -->

<!-- START_37e1cd18b47ab0cccbf8990a5106f4dc -->
## api/chat/enviarAdmin

> Example request:

```bash
curl -X POST "http://localhost/api/chat/enviarAdmin" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/chat/enviarAdmin",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/chat/enviarAdmin`


<!-- END_37e1cd18b47ab0cccbf8990a5106f4dc -->

<!-- START_f00ab912db82ac457b79e94e062ecc53 -->
## api/documentos/pdf/idguanajoven

> Example request:

```bash
curl -X GET "http://localhost/api/documentos/pdf/idguanajoven" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/documentos/pdf/idguanajoven",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/documentos/pdf/idguanajoven`

`HEAD api/documentos/pdf/idguanajoven`


<!-- END_f00ab912db82ac457b79e94e062ecc53 -->

<!-- START_0d357ee9448e2c172701af5826bd9ded -->
## api/documentos/excel/reporteevento

> Example request:

```bash
curl -X GET "http://localhost/api/documentos/excel/reporteevento" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/documentos/excel/reporteevento",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "success": true,
    "status": 200,
    "errors": [
        "Evento sin registros"
    ],
    "data": false
}
```

### HTTP Request
`GET api/documentos/excel/reporteevento`

`HEAD api/documentos/excel/reporteevento`


<!-- END_0d357ee9448e2c172701af5826bd9ded -->

<!-- START_16441b8bff5632faad7d19b6cf524200 -->
## api/promociones/registrar

> Example request:

```bash
curl -X POST "http://localhost/api/promociones/registrar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/promociones/registrar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/promociones/registrar`


<!-- END_16441b8bff5632faad7d19b6cf524200 -->

