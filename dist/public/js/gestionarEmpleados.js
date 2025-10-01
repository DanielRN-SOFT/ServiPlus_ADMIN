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
                      // 👇 devolvemos la promesa de $.ajax
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

    // AJAX con ese ID
    $.ajax({
        url: "./views/editarEmpleado.php",
        type: "GET",
        data: {id: IDempleado},
        success: function(frmHTML){
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
                preConfirm: () =>{
                    const form = document.getElementById("frmEditarEmpleado");
                    if (!form.checkValidity()) {
                      form.reportValidity(); // Muestra los mensajes nativos del navegador
                      return false; // SweetAlert no cierra
                    }
                    const datos = new FormData(form);

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
    let IDempleado = $(this).data("id");
    let nombreEmpleado = $(this).data("nombre");
    let numDocumento = $(this).data("num");
    console.log("ID: " + IDempleado);
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
            preConfirm: () =>{
                return $.ajax({
                     url: "./controllers/procesarEliminarEmpleado.php",
                    type: "POST",
                    data: {id: IDempleado},
                    dataType: "json"
                }).then((respuesta) =>{
                    if(!respuesta.success){
                        Swal.showValidationMessage(respuesta.message)
                    }
                    return respuesta
                })
            }
         }).then((result) =>{
            if(result.isConfirmed && result.value.success){
                Swal.fire("Exito", result.value.message, "success").then(() =>{
                    location.reload();
                })
                
            }
         })
})

// Reintegrar empleado
$(document).on("click", ".btn-reintegrar", function(){
    let IDempleado = $(this).data("id");
    let nombreEmpleado = $(this).data("nombre");
    let numDocumento = $(this).data("num");
    console.log("ID: " + IDempleado);
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
            preConfirm: () =>{
                return $.ajax({
                     url: "./controllers/procesarEliminarEmpleado.php",
                    type: "POST",
                    data: {id: IDempleado},
                    dataType: "json"
                }).then((respuesta) =>{
                    if(!respuesta.success){
                        Swal.showValidationMessage(respuesta.message)
                    }
                    return respuesta
                })
            }
         }).then((result) =>{
            if(result.isConfirmed && result.value.success){
                Swal.fire("Exito", result.value.message, "success").then(() =>{
                    location.reload();
                })
            }
         })
})

