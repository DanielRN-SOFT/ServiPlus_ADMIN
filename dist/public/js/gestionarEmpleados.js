// CREAR EMPLEADO
// Espera a que el documento esté listo (todo el DOM cargado)
$(document).ready(function(){
// Detecta el click en el botón con id="abrirCrearFrm"
    $("#abrirCrearFrm").on("click", function (){
         // Hace una petición AJAX para cargar el formulario desde un archivo PHP
       $.ajax({
        url: "./views/crearEmpleado.php",
        type: "GET",
        success: function(frmHTML){ // si la petición es exitosa, frmHTML trae el <form> generado en PHP
            Swal.fire({
                title: '<strong class="text-success fw-bold"> Crear empleado </strong',
                html: frmHTML,
                showCancelButton: true,
                confirmButtonText: "Agregar",
                cancelButtonText: "Cancelar",
                 customClass: {
                confirmButton: "btn btn-confirmar btn-success",
                cancelButton: "btn btn-eliminar btn-danger"
            },
                  // preConfirm se ejecuta antes de cerrar el modal, cuando das clic en "Enviar"
                preConfirm: () =>{
                    // Captura el formulario insertado en el SweetAlert
                   const form = document.getElementById("frmCrearEmpleado");
                   
                   // Crea un objeto FormData con todos los campos del formulario (incluye archivos)
                   const formData = new FormData(form);
                

                      // Envía los datos del formulario al backend (procesarCrearEmpleado.php)
                      // devolvemos la promesa de $.ajax
                    return $.ajax({ 
                        url: "./controllers/procesarCrearEmpleado.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json"
                    }).then((respuesta) =>{ // cuando el servidor responde

                        // Si la respuesta trae error, lo muestra dentro del modal
                        if(!respuesta.success){
                            Swal.showValidationMessage(respuesta.message);

                        }
                        // Retorna la respuesta al then() final de SweetAlert
                        return respuesta; // este valor se pasa a result.value
                    });
                }
            }).then((result) => { // esto se ejecuta cuando el modal se cierra

                  // Si el usuario confirmó y el backend respondió con success=true
                if(result.isConfirmed && result.value.success){
                    Swal.fire("Exito", result.value.message, 'success').then(() =>{
                        location.reload();
                    })

                
                }
            })
        }
       })
    })
})


// EDITAR EMPLEADO

$(document).on("click", ".btn-editar", function(){
    let IDempleado = $(this).data("id"); // Captura el id unico del empleado
    console.log("Editar empleado con ID: ", IDempleado);

    // Llamar el formulario de editar junto con el ID enviado
    $.ajax({
        url: "./views/editarEmpleado.php",
        type: "GET",
        data: {id: IDempleado},
        success: function(frmHTML){
            // Dispara el sweet alert
            Swal.fire({
                title: '<strong class="text-primary fw-bold"> Editar empleado </strong',
                html: frmHTML,
                showCancelButton: true,
                confirmButtonText: "Guardar cambios",
                cancelButtonText: "Cancelar",
                customClass: {
                confirmButton: "btn btn-confirmar btn-success",
                cancelButton: "btn btn-eliminar btn-danger"
            },
            // Ejecutar las acciones antes de cerrar la modal
                preConfirm: () =>{

                    // Capturar los datos ingresados en el FORMULARIO
                    const form = document.getElementById("frmEditarEmpleado");
                    const datos = new FormData(form);

                    // Esperar el retorno del controlador php
                    return $.ajax({
                        url: "./controllers/procesarEditarEmpleado.php",
                        type: "POST",
                        data: datos,
                        processData: false,
                        contentType: false,
                        dataType: "json"
                    }).then((respuesta) =>{ // cuando el servidor responde

                        // Si la respuesta trae error, lo muestra dentro del modal
                        if(!respuesta.success){
                            Swal.showValidationMessage(respuesta.message);

                        }
                        // Retorna la respuesta al then() final de SweetAlert
                        return respuesta; // este valor se pasa a result.value
                    });
                }
            }).then((result) =>{
                // Si success == true y se confirma la accion mande un alerta de EXITO
                    if(result.isConfirmed && result.value.success){
                    Swal.fire("Éxito", result.value.message, "success").then(() =>{
                        location.reload();
                    });

                 
                }
            })
        }
    })
})


// Eliminar empleado

$(document).on("click", ".btn-eliminarEmp", function(){
    // Capturar el ID del empleado
    let IDempleado = $(this).data("id");
    // Capturar el nombre
    let nombreEmpleado = $(this).data("nombre");
    // Capturar el numDoc
    let numDocumento = $(this).data("num");
        // Disparar la alerta
         Swal.fire({
            title: '<strong class="text-danger">Eliminar</strong>',
            html: `¿Esta seguro de eliminar este empleado?<br> <strong>Nombre:</strong> ${nombreEmpleado} <br> 
            <strong> Numero de documento: </strong> ${numDocumento}`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar empleado',
            cancelButtonText: "Cancelar",
            customClass: {
                confirmButton: "btn btn-confirmar btn-success",
                cancelButton: "btn btn-eliminar btn-danger"
            },
            // Ejecutar esta accion antes de cerrar la modal
            preConfirm: () =>{
                // Retornar una respuesta del controlador
                return $.ajax({
                     url: "./controllers/procesarEliminarEmpleado.php",
                    type: "POST",
                    data: {id: IDempleado},
                    dataType: "json"
                }).then((respuesta) =>{
                    // Si la respuesta del success == false mande la alerta
                    if(!respuesta.success){
                        Swal.showValidationMessage(respuesta.message)
                    }
                    return respuesta
                })
            }
         }).then((result) =>{
            // Si el valor del success == true y es confirmado
            if(result.isConfirmed && result.value.success){
                Swal.fire("Exito", result.value.message, "success").then(() =>{
                    location.reload();
                })
                
            }
         })
})

// Reintegrar empleado
$(document).on("click", ".btn-reintegrar", function(){
    // Capturo el ID del empleado
    let IDempleado = $(this).data("id");
    //Capturo el nombre
    let nombreEmpleado = $(this).data("nombre");
    // Capturo el numDoc
    let numDocumento = $(this).data("num");
        // Disparo la alerta
         Swal.fire({
            title: '<strong class="text-success">Reintegrar empleado</strong>',
            html: `¿Esta seguro de reintegrar este empleado?<br> <strong>Nombre:</strong> ${nombreEmpleado} <br> 
            <strong> Numero de documento: </strong> ${numDocumento}`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Si, restablecer empleado',
            cancelButtonText: "Cancelar",
            customClass: {
                confirmButton: "btn btn-confirmar btn-success",
                cancelButton: "btn btn-eliminar btn-danger"
            },
            // Accion antes de
            preConfirm: () =>{
                // Retornar la respuesta del controlador
                return $.ajax({
                     url: "./controllers/procesarEliminarEmpleado.php",
                    type: "POST",
                    data: {id: IDempleado},
                    dataType: "json"
                }).then((respuesta) =>{
                    // Si la respuesta de success = false
                    if(!respuesta.success){
                        Swal.showValidationMessage(respuesta.message)
                    }
                    //Si no retorne la respuesta
                    return respuesta
                })
            }
         }).then((result) =>{
            // Si el success == true y el resultado fue confirmado por el usuario
            if(result.isConfirmed && result.value.success){
                Swal.fire("Exito", result.value.message, "success").then(() =>{
                    location.reload();
                })
            }
         })
})

