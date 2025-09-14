<?php

require_once '../model/usuarios.php';
session_start();
$mensaje = $_SESSION["mensaje"];
$pagina = $_SESSION["pagina"];

if($pagina == "index"){
    $id = $_SESSION["id"];
}


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
    <div class="custom-bg text-dark">
        <div class="d-flex align-items-center justify-content-center min-vh-100 px-2">
            <div class="text-center">
                <h1 class="display-1 fw-bold">404</h1>
                <p class="fs-2 fw-medium mt-4">Oops! Ha ocurrido un error</p>
                <p class="mt-4 mb-5 fs-4 fw-bold text-danger"><?php echo $mensaje ?></p>
                <?php if ($pagina == "login") {
                    header("refresh:2; url=../views/login.php");
                } ?>
                <?php if ($pagina == "crearEmpleado") {
                    header("refresh:2; url=../views/crearEmpleado.php");
                } ?>
                <?php if ($pagina == "editarEmpleado") {
                    header("refresh:2; url=../views/crearEmpleado.php");
                } ?>

                <?php if ($pagina == "index") {
                    header("refresh:2; url=../index.php" . "?" . "IDempleado=" . $id);
                } ?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>