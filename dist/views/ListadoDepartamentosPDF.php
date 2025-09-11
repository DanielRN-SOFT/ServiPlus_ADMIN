<?php
require_once '../model/MYSQL.php';
$mysql =  new MySQL;
$mysql->conectar();
$departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos");
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
    <div class="row g-0">
        <div class="col-md-12 d-flex justify-content-center align-items-center min-vh-100 bg-body-secondary">
            <div class="">
                <form action="./generar_pdf_departamento.php" method="post" class="bg-body-tertiary p-5 rounded-4 shadow">
                    <h1 class="form-label mb-4 text-primary fw-bold text-center" for="">Departamento</h1>
                    <?php while ($fila = $departamentos->fetch_assoc()): ?>
                        <div class="form-check">

                            <input class="form-check-input" type="radio" name="departamento" id="<?php echo $fila["nombreDepartamento"] ?>" value="<?php echo $fila["IDdepartamento"] ?>">
                            <label class="form-check-label fs-4" for="<?php echo $fila["nombreDepartamento"] ?>">
                                <?php echo $fila["nombreDepartamento"] ?>
                            </label>

                        </div>
                    <?php endwhile; ?>

                    <button class="btn btn-primary w-100 mt-4 fw-bold fs-5">Generar PDF</button>

                    <div class="text-center mt-3">
                        <a href="../index.php" class="">Volver al listado de empleados</a>
                    </div>

                </form>


            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>