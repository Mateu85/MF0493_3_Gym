
$(document).ready(function(){
        $("button").click(function(){

            var mensajes = "";
                   var nombre = document.getElementById("nombre");
                   var apellido = document.getElementById("apellido");
                   var email = $("input[id='email']");
                   var tlf = $("input[id='tlf']");
                   var dni = $("input[id='dni']");
                   var any = $("input[id='any']");
                   var provincias = $("select");
                   var mensaje = document.getElementById("mensaje");


                   if(nombre.value == ""){
                       mensajes = "Rellena el campo Nombre<br>";
                       nombre.style.border = "1px solid red";
                       nombre.classList.add("placeholder_val_ko");
                       nombre.classList.remove("placeholder_val_ok");
                       document.getElementsByClassName("result_nombre")[0].innerHTML = mensajes;
                   }else{
                       nombre.removeAttribute("style");
                       nombre.classList.add("placeholder_val_ok");
                       nombre.classList.remove("placeholder_val_ko");
                       mensajes = "";
                       document.getElementsByClassName("result_nombre")[0].innerHTML = mensajes;
                   }

                   if(apellido.value == ""){
                       mensajes = "Rellena el campo Apellido<br>";
                       apellido.style.border = "1px solid red";
                       apellido.classList.add("placeholder_val_ko");
                       apellido.classList.remove("placeholder_val_ok");
                       document.getElementsByClassName("result_apellido")[0].innerHTML = mensajes;
                   }else{
                       apellido.removeAttribute("style");
                       apellido.classList.add("placeholder_val_ok");
                       apellido.classList.remove("placeholder_val_ko");
                       mensajes = "";
                       document.getElementsByClassName("result_apellido")[0].innerHTML = mensajes;
                   }

                  if(email.val() == ""){
                      mensajes = "Rellena el campo Email<br>";
                      email.css("border","1px solid red");
                      email.addClass("placeholder_val_ko");
                      email.removeClass("placeholder_val_ok");
                      $(".result_email").html(mensajes);

                  }else if(!email_validar(email.val())){
                      mensajes = "El email no cumple el formato nombre@dominio.ext)<br>";
                      email.css("border","1px solid red");
                      email.css("color","red");
                      $(".result_email").html(mensajes);
                  }else{
                      email.removeAttr("style");
                      email.addClass("placeholder_val_ok");
                      email.removeClass("placeholder_val_ko");
                      mensajes = "";
                      $(".result_email").html(mensajes);
                  }

                  if(tlf.val() == ""){
                      mensajes = "Rellena el campo Teléfono<br>";
                      tlf.css("border","1px solid red");
                      tlf.addClass("placeholder_val_ko");
                      tlf.removeClass("placeholder_val_ok");
                      $(".result_tlf").html(mensajes);

                  }else if(!telefono_validar(tlf.val())){
                      mensajes = "El teléfono no tiene el formato (9/7/6xxxxxxxx)<br>";
                      tlf.css("border","1px solid red");
                      tlf.css("color","red");
                      $(".result_tlf").html(mensajes);
                  }else{
                      tlf.removeAttr("style");
                      tlf.addClass("placeholder_val_ok");
                      tlf.removeClass("placeholder_val_ko");
                      mensajes = "";
                      $(".result_tlf").html(mensajes);
                  }

                  if(dni.val() == ""){
                      mensajes = "Rellena el campo DNI<br>";
                      dni.css("border","1px solid red");
                      dni.addClass("placeholder_val_ko");
                      dni.removeClass("placeholder_val_ok");
                      $(".result_dni").html(mensajes);

                  }else if(!dni_validar(dni.val())){
                      mensajes = "El DNI introducido no es correcto<br>";
                      dni.css("border","1px solid red");
                      dni.css("color","red");
                      $(".result_dni").html(mensajes);
                  }else{
                      dni.removeAttr("style");
                      dni.addClass("placeholder_val_ok");
                      dni.removeClass("placeholder_val_ko");
                      mensajes = "";
                      $(".result_dni").html(mensajes);
                  }

                   if(any.val() == ""){
                       mensajes = "Rellena el campo Año de Nacimiento<br>";
                       any.css("border","1px solid red");
                       any.addClass("placeholder_val_ko");
                       any.removeClass("placeholder_val_ok");
                       $(".result_any").html(mensajes);

                   }else if(any.val()>2002){
                       mensajes = "Eres menor de edad<br>";
                       any.css("border","1px solid red");
                       any.css("color","red");
                       $(".result_any").html(mensajes);
                   }else{
                       any.removeAttr("style");
                       any.addClass("placeholder_val_ok");
                       any.removeClass("placeholder_val_ko");
                       mensajes = "";
                       $(".result_any").html(mensajes);
                   }

                   if(provincias.val() == "[Selecciona]"){
                       mensajes = "Rellena la provincia<br>";
                       provincias.css("border","1px solid red");
                       provincias.addClass("placeholder_val_ko");
                       provincias.removeClass("placeholder_val_ok");
                       $(".result_provincias").html(mensajes);

                     }else{
                       provincias.removeAttr("style");
                       provincias.addClass("placeholder_val_ok");
                       provincias.removeClass("placeholder_val_ko");
                       mensajes = "";
                       $(".result_provincias").html(mensajes);
                   }

                   if(mensaje.value == ""){
                       mensajes = "Rellena el campo Mensaje<br>";
                       mensaje.style.border = "1px solid red";
                       mensaje.classList.add("placeholder_val_ko");
                       mensaje.classList.remove("placeholder_val_ok");
                       document.getElementsByClassName("result_mensaje")[0].innerHTML = mensajes;
                   }else{
                       mensaje.removeAttribute("style");
                       mensaje.classList.add("placeholder_val_ok");
                       mensaje.classList.remove("placeholder_val_ko");
                       mensajes = "";
                       document.getElementsByClassName("result_mensaje")[0].innerHTML = mensajes;
                   }

                   // el formulario se envia si esta validado solamente el nombre y apellidos
                   if (nombre.className == "placeholder_val_ko"
                   ||  apellido.className == "placeholder_val_ko"){
                       event.preventDefault();
                   } else {
                       // alert("El usuario se ha registrado correctamente");
                       //AJAX Challenge 7
                       event.preventDefault();
                       // Registro

                       $.ajax({
                           type: 'post',
                           url: 'contactoSend',
                           dataType: 'json',
                           data: $("#contacto").serialize(),
                           success: function(res){
                               $("#pensandoCont").html(res);
                           },
                           beforeSend: function(){
                               $("#pensandoCont").css('text-align','justify');
                               $("#pensandoCont").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>');
                           },
                           error: function(){
                               $("#pensandoCont").html('error');
                           },
                       });

                   }

        });
});


/*
* @name: telefono_validar
* @author: Clase CIFO VIOLETA
* @versio: 1.0
* @description: Valida un formato de teléfono mediante RegExp
* @date: 08/1/20
* @params: tlf.val()
* @return: true/false
*/
function telefono_validar(tlf){
    var patt = new RegExp(/^[9|7|6]{1}([\d]{2}[-]*){3}[\d]{2}$/);
    return patt.test(tlf);
}

/*
* @name: email_validar
* @author: Clase CIFO VIOLETA
* @versio: 1.0
* @description: Valida un formato de un email mediante RegExp
* @date: 08/1/20
* @params: email.val()
* @return: true/false
*/
function email_validar(email){
    var patt = new RegExp(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    return patt.test(email);
}
/*
* @name: dni_validar
* @author: Clase CIFO VIOLETA
* @versio: 1.0
* @description: Valida un formato de DNI mediante RegExp
* @date: 09/1/20
* @params: dni.val()
* @return: true/false
*/
function dni_validar(dni){
    var patt = new RegExp(/^\d{8}[a-zA-Z]$/);
    var numero;
    var letr;
    var letra;

    if(patt.test(dni)){
        numero = dni.substr(0,dni.length-1);
        letr = dni.substr(dni.length-1,1);
        numero = numero % 23;
        letra='TRWAGMYFPDXBNJZSQVHLCKET';
        letra=letra.substring(numero,numero+1);
        if (letra!=letr.toUpperCase()) {
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}
