
$(document).on("click", ".btn-pdf-dpto", function(){
    $.ajax({
        url: "./views/ListadoDepartamentosPDF.php",
        type: "GET",
        success: function(frmHTML){
            Swal.fire({
                title: '<span class="text-center"> Listado de <br> departamentos </span',
                html: frmHTML,
                showCancelButton: true,
                confirmButtonText: "Generar PDF",
                cancelButtonText: "Cancelar",
                customClass:{
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                preConfirm: () =>{
                    const frmListado = document.getElementById("frm-listado");
                    const formData = new FormData(frmListado);

                   // Crear formulario temporal para enviar con POST y abrir en nueva pestaña
                    const form = document.createElement("form");
                    form.method = "POST";
                    form.action = "./views/generar_pdf_departamento.php";
                    form.target = "_blank"; // abrir en nueva pestaña

                    // P    asar los valores del formData al formulario
                    for (let [key, value] of formData.entries()) {
                        const input = document.createElement("input");
                        input.type = "hidden";
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    form.submit(); // enviamos
                    form.remove(); // limpiar después

                    return true; // indica a SweetAlert que todo salió bien
                }
            }).then((result) =>{
                if(result.isConfirmed){
                    Swal.fire("Éxito ✅", "PDF generado con éxito", "success");
                }
            })
        }
    })
})