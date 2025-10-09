<?php
// Validacion de Inicio sesion
session_start();

if ($_SESSION['acceso'] == NULL || $_SESSION["acceso"] == false) {
    header("Location: ./login.php");
    exit();
}

require_once '../model/MYSQL.php';
$mysql = new MySQL();
$mysql->conectar();

$id = intval($_GET['id']);
$empleados = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE IDempleado = '$id'");
$cargos = $mysql->efectuarConsulta("SELECT * FROM cargos WHERE estadoCargo = 'Activo'");
$departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos WHERE estadoDepartamento = 'Activo'");
$roles = $mysql->efectuarConsulta("SELECT * FROM roles");

$mysql->desconectar();
?>


<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE | Crear Empleado</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE | Dashboard v2" />
    <meta name="author" content="ColorlibHQ" />
    <meta
        name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta
        name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="./css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
        media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->

    <!-- apexcharts -->

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />


</head>

<body class="">

    <div class="row">
        <div class="col-sm-12">
            <form action="" method="post" enctype="multipart/form-data" id="frmEditarEmpleado" class="px-3">
                <div class="row">
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
                                <option value="Activo" <?php echo ($fila["estado"] == "Activo") ? 'selected' : "" ?>>Activo</option>
                                <option value="Inactivo" <?php echo ($fila["estado"] == "Inactivo") ? 'selected' : "" ?>>Inactivo</option>

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
                        <img src="<?php echo $fila["imagen"] ?>" class="img-fluid w-50" alt="">
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
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" value="">
                    </div>
                    <div class="col-md-6">
                        <label for="newPassword" class="form-label">Contraseña nueva:</label>
                        <input type="password" class="form-control" id="oldPassword" name="newPassword" value="">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/4c0cbe7815.js" crossorigin="anonymous"></script>

</body>
<!--end::Body-->

</html>