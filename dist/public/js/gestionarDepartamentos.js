
$(document).ready(function(){
    $("#crearDepartamento").on("click", function(){
        $.ajax({
            url: "./crearDepartamento.php",
            type: "GET",
            success: function(frmHTML){
                Swal.fire({
                    title: '<span class="text-primary">Crear un nuevo <br> departamento</span>',
                    html: frmHTML,
                    showCancelButton: true,
                    confirmButtonText: "Agregar",
                    cancelButtonText: "Cancelar",
                    customClass: {
                        confirmButton: "btn btn-success p-2",
                        cancelButton: "btn btn-danger p-2"
                    },
                    preConfirm: () =>{
                        const formulario = document.getElementById("frmCrearDepartamento");
                        const formData = new FormData(formulario);
                        return $.ajax({
                            url: "../controllers/procesarCrearDepartamento.php",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json"
                        }).then(respuesta =>{
                            if(!respuesta.success){
                                Swal.showValidationMessage(respuesta.message)
                            }
                            return respuesta;
                        })
                    }
                }).then(result =>{
                    if(result.isConfirmed && result.value.success){
                        Swal.fire("Exito", result.value.message, "success").then(() =>{
                            location.reload();
                        })
                    }
                })
            }
        })
    })
})


$(document).on("click", ".btn-editar", function(){
   let IDdepartamento = $(this).data("id") 
   console.log(IDdepartamento);
   $.ajax({
    url: "./editarDepartamento.php",
    type: "GET",
    data: {id: IDdepartamento},
    success: function(frmHTML){
        Swal.fire({
            title: '<p class="text-warning">Editar departamento</p>',
            html: frmHTML,
            showCancelButton: true,
            confirmButtonText: "Guardar cambios",
            cancelButtonText: "Cancelar",
            customClass: {
                confirmButton: "btn btn-success p-2",
                cancelButton: "btn btn-danger p-2"
            },
            preConfirm: () =>{
                const formulario = document.getElementById("frmEditarDepartamento");
                const formData = new FormData(formulario);
                return $.ajax({
                    url: "../controllers/procesarEditarDepartamento.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json"
                }).then((respuesta) =>{
                    if(!respuesta.success){
                        Swal.showValidationMessage(respuesta.message)
                    }
                    return respuesta;
                })
            }
        }).then((result) =>{
            if(result.value.success && result.isConfirmed){
                Swal.fire("Exito", result.value.message, "success").then(() =>{
                    location.reload();
                })
            }
        })
    }
   })
})



$(document).on("click", ".btn-eliminar-dep", function(){
    let IDdepartamento = $(this).data("id");
    let nombre = $(this).data("nombre");
    console.log(IDdepartamento);
    Swal.fire({
        title: '<p class="text-danger"> Eliminar departamento <p>',
        html: `¿Esta seguro de realizar esta accion?<br> <strong>Nombre: </strong> ${nombre}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar departamento",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        preConfirm: () =>{
           return $.ajax({
                url: "../controllers/procesarEliminarDepartamento.php",
                type: "POST",
                data: {id: IDdepartamento},
                dataType: "json"
            }).then(respuesta => {
                if(!respuesta.success){
                    Swal.showValidationMessage(respuesta.message);
                }
                return respuesta
            })
        }
    }).then(resultado =>{
        if(resultado.isConfirmed && resultado.value.success){
            Swal.fire("Exito", resultado.value.message, "success").then(() =>{
                location.reload();
            })
        }
    })
})


$(document).on("click", ".btn-reintegrar", function(){
    let IDdepartamento = $(this).data("id");
    let nombre = $(this).data("nombre");
    console.log(nombre)
    console.log(IDdepartamento);

    Swal.fire({
        title: '<p class="text-success"> Reintegrar departamento </p>',
        html: `¿Desea reintegrar este departamento? <br> <strong> Nombre:</strong> ${nombre}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, reintegar empleado",
        cancelButtonText: "Cancelar",
        customClass:{
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        preConfirm: () =>{
            return $.ajax({
                url: "../controllers/procesarEliminarDepartamento.php",
                type: "POST",
                data: {id: IDdepartamento},
                dataType: "json"
            }).then(respuesta =>{
                if(!respuesta.success){
                    Swal.showValidationMessage(respuesta.message)
                }
                return respuesta
            })
        }
    }).then(resultado =>{
        if(resultado.isConfirmed && resultado.value.success){
            Swal.fire("Exito", resultado.value.message, "success").then(() =>{
                location.reload();
            });
        }
    })
})