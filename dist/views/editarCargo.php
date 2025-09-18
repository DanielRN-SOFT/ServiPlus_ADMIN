<?php

require_once '../model/MYSQL.php';

session_start();
if ($_SESSION["acceso"] == false && $_SESSION["acceso"] == null) {
    header("Location: ./login.php");
}

$mysql = new MySQL();
$mysql->conectar();

$id = $_GET["id"];

$cargos = $mysql->efectuarConsulta("SELECT * FROM cargos WHERE IDcargo = $id");
$filaCargo = $cargos->fetch_assoc();
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
    <form action="" id="frmEditarCargo" method="post">
        <div class="row">
            <input type="hidden" value="<?php echo $filaCargo["IDcargo"]?>" name="id">
            <div class="col-sm-6">
                <label class="form-label" for="nombreCargo">Nombre:</label>
                <input class="form-control" id="nombreCargo" name="nombreCargo" type="text" value="<?php echo $filaCargo["nombreCargo"] ?>">
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="estadoCargo">Estado:</label>
                <select class="form-control" id="estadoCargo" class="form-select" name="estadoCargo" type="text">
                    <option value="Activo" <?php echo ($filaCargo["estadoCargo"] == "Activo") ? "selected" : "" ?>>Activo</option>
                    <option value="Inactivo" <?php echo ($filaCargo["estadoCargo"] == "Inactivo") ? "selected" : "" ?>>Inactivo</option>
                </select>
            </div>
        </div>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>