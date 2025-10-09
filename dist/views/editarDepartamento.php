<?php
// Validacion de inicio de sesion
session_start();
if ($_SESSION["acceso"] == false && $_SESSION["acceso"] == null) {
    header("Location: ./login.php");
}

require_once '../model/MYSQL.php';
$mysql = new MySQL();
$mysql->conectar();
$id = $_GET["id"];


$departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos WHERE IDdepartamento = $id");
$filaDpto = $departamentos->fetch_assoc();

$mysql->desconectar();


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <form action="" id="frmEditarDepartamento" method="post">
        <input class="form-control" id="nombreDepartamento" value="<?php echo $filaDpto["IDdepartamento"] ?>" name="id" type="hidden">
        <div class="row">
            <div class="col-sm-8">
                <div class="mb-3">
                    <label class="form-label" for="nombreDepartamento">Nombre:</label>
                    <input class="form-control" id="nombreDepartamento" value="<?php echo $filaDpto["nombreDepartamento"] ?>" name="nombreDepartamento" type="text">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label" for="nombreDepartamento">Estado:</label>
                    <select class="form-select" id="nombreDepartamento" value="<?php echo $fila["estadoDepartamento"] ?>" name="estadoDepartamento" type="text">

                        <option value="Activo" <?php echo ("Activo" == $filaDpto["estadoDepartamento"] ? "selected" : "") ?>>Activo</option>
                        <option value="Inactivo" <?php echo ("Inactivo" == $filaDpto["estadoDepartamento"]) ? "selected" : "" ?>>Inactivo</option>

                    </select>
                </div>
            </div>
        </div>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>