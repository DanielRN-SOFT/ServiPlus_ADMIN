$(document).ready(function(){
    $("#abrirEditarForm").on("click", function (){
       $.ajax({
        url: "./views/editarEmpleado.php",
        type: "GET",
        success: function(frmHTML){
            Swal.fire({
                title: "Crear un nuevo empleado",
                html: frmHTML,
                showCancelButton: true,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
                preConfirm: () =>{
                   const form = document.getElementById("frmEditarEmpleado");
                   const formData = new FormData(form);
                    return $.ajax({
                        url: "./controllers/procesarCrearEmpleado.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json"
                    }).then((respuesta) =>{
                        if(!respuesta.success){
                            Swal.showValidationMessage(respuesta.message);

                        }
                        return respuesta;
                    });
                }
            }).then((result) => {
                if(result.isConfirmed && result.value.success){
                    Swal.fire("Exito", result.value.message, 'success')
                }
            })
        }
       })
    })
})