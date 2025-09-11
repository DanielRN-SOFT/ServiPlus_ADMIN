<?php
require_once '../../model/MYSQL.php';


$mysql = new MySQL();
$mysql->conectar();

$id = $_GET["IDempleado"];

$empleados = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE IDempleado = '$id'");
$cargos = $mysql->efectuarConsulta("SELECT * FROM cargos");
$departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos");
$roles = $mysql->efectuarConsulta("SELECT * FROM roles");



$mysql->desconectar();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ServiPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://kit.fontawesome.com/4c0cbe7815.js" crossorigin="anonymous"></script>
</head>

<body class="bg-editar">
    <div class="row bg-sombra">
        <main class="row">
            <div class="col-md-5 col-sm-10 mx-auto bg-body-tertiary p-4 rounded-4 shadow mt-4 mb-4">
                <form action="../controllers/editarEmpleado.php" method="post" enctype="multipart/form-data" class="px-3">
                    <div class="row">
                        <h2 class="text-center text-warning fw-bold mb-4 ">Edición de Empleados</h2>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <?php $fila = $empleados->fetch_assoc() ?>
                                <label for="nombre" class="form-label">Nombre completo:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $fila["nombre"] ?>">


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="numDocumento" class="form-label">Numero de documento:</label>
                                <input type="number" class="form-control" id="numDocumento" name="numDocumento" value="<?php echo $fila["numDocumento"] ?>">
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <select class="form-select" aria-label="Default select example" id="cargo" name="cargo">
                            <?php while ($filaCargos = $cargos->fetch_assoc()): ?>
                                <option value="<?php echo $filaCargos["IDcargo"] ?>" <?php echo ($fila["cargo_id"] == $filaCargos["IDcargo"]) ? 'selected' : "" ?>><?php echo $filaCargos["nombreCargo"] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fs-5" for="">Departamento</label>
                                <?php while ($filaDepartamentos = $departamentos->fetch_assoc()): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="departamento" id="<?php echo $filaDepartamentos["nombreDepartamento"] ?>" value="<?php echo $filaDepartamentos["IDdepartamento"] ?>" <?php echo ($fila["departamento_id"] == $filaDepartamentos["IDdepartamento"]) ? 'checked' : "" ?>>

                                        <label class="form-check-label" for="<?php echo $filaDepartamentos["nombreDepartamento"] ?>">
                                            <?php echo $filaDepartamentos["nombreDepartamento"] ?>
                                        </label>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de ingreso:</label>
                                <input type="date" class="form-control" id="fecha" name="fechaIngreso" value="<?php echo $fila["fechaIngreso"] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="salario" class="form-label">Salario base:</label>
                                <input type="number" class="form-control" id="salario" name="salarioBase" value="<?php echo $fila["salarioBase"] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="correoElectronico" class="form-label">Correo Electronico:</label>
                                <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" value="<?php echo $fila["correoElectronico"] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono de contacto:</label>
                                <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $fila["telefono"] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cargo" class="form-label">Estado</label>
                                <select class="form-select" aria-label="Default select example" id="cargo" name="estado" required>
                                    <option value="Activo" <?php echo ($fila["estado"] == "Activo") ? 'checked' : "" ?>>Activo</option>
                                    <option value="Inactivo" <?php echo ($fila["estado"] == "Inactivo") ? 'checked' : "" ?>>Inactivo</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 mb-3">
                        <div class="col-md-8">
                            <div class="mt-2">
                                <label for="foto" class="form-label">Seleccione una imagen:</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.jpeg,.png">
                                <input type="hidden" name="id" value="<?php echo $fila["IDempleado"] ?>">
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <label for="">Imagen actual</label>
                            <img src="<?php echo "../" . $fila["imagen"] ?>" class="img-fluid w-50" alt="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol:</label>
                                <select class="form-select" id=rol" name="rol" required>
                                    <?php while ($filaRoles = $roles->fetch_assoc()): ?>
                                        <option value="<?php echo $filaRoles["id_rol"] ?>" <?php echo ($fila["rol_id"] == $filaRoles["id_rol"] ? "selected" : "") ?>><?php echo $filaRoles["nombre_rol"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="oldPassword" class="form-label">Contraseña antigua:</label>
                            <input type="text" class="form-control" id="oldPassword" name="oldPassword" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="newPassword" class="form-label">Contraseña nueva:</label>
                            <input type="text" class="form-control" id="oldPassword" name="newPassword" value="" >
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold fs-5">Enviar</button>
                    <div class="text-center mt-3">
                        <a href="../index.php" class="text-center">Volver al listado de empleados</a>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>