
$(document).on("click", ".btn-login", function(e){
    e.preventDefault();
    let numDocumento = document.getElementById("numDocumento").value;
    let password = document.getElementById("password").value;
    if(numDocumento.trim() == "" || password.trim() == ""){
        Swal.fire("Atencion", "Todos los campos son obligatorios", "warning");
        return
    }
    const form = document.getElementById("frmLogin");
    const formData = new FormData(form);
    $.ajax({
        url: "../controllers/login.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(respuesta){
           if(respuesta.success){
                window.location.href = "../index.php"
           }else{
            Swal.fire("ERROR", respuesta.message, "error");
           }
        }
    })
    });