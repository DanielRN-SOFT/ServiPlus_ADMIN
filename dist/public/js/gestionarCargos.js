
// Crear
$(document).ready(function(){
    $("#crearCargo").on("click", function(){
        $.ajax({
            url: "./crearCargo.php",
            type: "GET",
            success: function(frmHTML){
                Swal.fire({
                    title: '<span class="text-success"> Crear cargo </span>',
                    html: frmHTML,
                    showCancelButton: true,
                    confirmButtonText: "Agregar",
                    cancelButtonText: "Cancelar",
                    customClass:{
                        confirmButton: "btn btn-confirmar btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    preConfirm: function(){
                        const formulario = document.getElementById("frmCrearCargo");
                        const formData = new FormData(formulario);
                        return $.ajax({
                            url: "../controllers/procesarCrearCargo.php",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json"
                        }).then(respuesta =>{
                            if(!respuesta.success){
                                Swal.showValidationMessage(respuesta.message);
                            }
                            return respuesta
                        })
                    }
                }).then(resultado =>{
                   if(resultado.isConfirmed && resultado.value.success){
                    Swal.fire("Exito", resultado.value.message, "success").then(()=>{
                        location.reload();
                    });
                   }
                })
            }
        })
    })
})



// EDITAR

$(document).on("click", ".btn-editar", function(){
   let IDcargo = $(this).data("id");
   $.ajax({
    url: "./editarCargo.php",
    type: "GET",
    data: {id: IDcargo},
    success: function(frmHTML){
        Swal.fire({
            title: '<span class = "text-primary"> Editar cargo </span>',
            html: frmHTML,
            showCancelButton: true,
            confirmButtonText: "Guardar",
            cancelButtonText: "Cancelar",
            customClass: {
                confirmButton: "btn btn-confirmar btn-success",
                cancelButton: "btn btn-danger"
            },
            preConfirm: () =>{
                const formulario = document.getElementById("frmEditarCargo");
                const formData = new FormData(formulario);
                return $.ajax({
                    url: "../controllers/procesarEditarCargo.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                }).then(respuesta =>{
                    if(!respuesta.success){
                        Swal.showValidationMessage(respuesta.message);
                    }
                    return respuesta;
                })
            }
        }).then(resultado =>{
            if(resultado.isConfirmed && resultado.value.success){
                Swal.fire("Exito", resultado.value.message, "success").then(()=>{
                    location.reload();
                })
            }
        })
    }
   })
})

// Eliminar
$(document).on("click", ".btn-eliminar", function(){
    let IDcargo = $(this).data("id");
    let nombreCargo = $(this).data("nombre");
    Swal.fire({
        title: '<div class="text-danger"> Eliminar cargo </div>',
        html: `<div> ¿Esta seguro de realizar esta accion? <br> <strong> Nombre: </strong> ${nombreCargo} </div>`,
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
        icon: "warning",
        customClass:{
            confirmButton: "btn btn-confirmar btn-success",
            cancelButton: "btn btn-danger"
        },
        preConfirm: function(){
            return $.ajax({
                url: "../controllers/procesarEliminarCargo.php",
                type: "POST",
                data: {id: IDcargo},
                dataType: "json"
            }).then(respuesta =>{
                if(!respuesta.success){
                    Swal.fire(respuesta.message);
                }
                return respuesta
            })
        }
    }).then(resultado =>{
        if(resultado.isConfirmed && resultado.value.success){
            Swal.fire("Exito", resultado.value.message, "success").then(()=>{
                location.reload();
            });
        }
    })
})

// Reintegrar
$(document).on("click", ".btn-reintegrar", function(){
    let IDcargo = $(this).data("id");
    let nombreCargo = $(this).data("nombre");
    Swal.fire({
        title: '<div class="text-success"> Reintegrar cargo </div>',
        html: `<div> ¿Esta seguro de realizar esta accion? <br> <strong> Nombre: </strong> ${nombreCargo} </div>`,
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar",
        icon: "warning",
        customClass:{
            confirmButton: "btn btn-confirmar btn-success",
            cancelButton: "btn btn-danger"
        },
        preConfirm: function(){
            return $.ajax({
                url: "../controllers/procesarEliminarCargo.php",
                type: "POST",
                data: {id: IDcargo},
                dataType: "json"
            }).then(respuesta =>{
                if(!respuesta.success){
                    Swal.fire(respuesta.message);
                }
                return respuesta
            })
        }
    }).then(resultado =>{
        if(resultado.isConfirmed && resultado.value.success){
            Swal.fire("Exito", resultado.value.message, "success").then(()=>{
                location.reload();
            });
        }
    })
})