<?php
require_once '../controllers/crearEmpleado.php';
session_start();

if ($_SESSION['acceso'] == NULL || $_SESSION["acceso"] == false) {
    header("Location: ./login.php");
    exit();
}
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
            <form action="" id="frmCrearEmpleado" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre completo:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="numDocumento" class="form-label">Numero de documento:</label>
                            <input type="number" class="form-control" id="numDocumento" name="NumDocumento" required>
                        </div>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="" class="form-label">Cargo</label>
                    <select class="form-select" aria-label="Default select example" id="" name="cargo" required>
                        <?php while ($fila = $cargos->fetch_assoc()): ?>
                            <option value="<?php echo $fila["IDcargo"] ?>"><?php echo $fila["nombreCargo"] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fs-5" for="">Departamento</label>
                            <?php while ($fila = $departamentos->fetch_assoc()): ?>
                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="departamento" id="<?php echo $fila["nombreDepartamento"] ?>" value="<?php echo $fila["IDdepartamento"] ?>" <?php echo ($fila["nombreDepartamento"] == "Electricidad") ? 'checked' : "" ?>>
                                    <label class="form-check-label" for="<?php echo $fila["nombreDepartamento"] ?>">
                                        <?php echo $fila["nombreDepartamento"] ?>
                                    </label>

                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha de ingreso:</label>
                            <input type="date" class="form-control" id="fecha" name="fechaIngreso" value="27/08/2025" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="salario" class="form-label">Salario base:</label>
                            <input type="number" class="form-control" id="salario" name="salarioBase" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono de contacto:</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="correoElectronico" class="form-label">Correo Electronico:</label>
                    <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Selecciona una imagen:</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept=".jpg, .jpeg, .png" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol:</label>
                            <select class="form-select" id=rol" name="rol" required>
                                <?php while ($filaRoles = $roles->fetch_assoc()): ?>
                                    <option value="<?php echo $filaRoles["id_rol"] ?>"><?php echo $filaRoles["nombre_rol"] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    </script>
    <script src="https://kit.fontawesome.com/4c0cbe7815.js" crossorigin="anonymous"></script>

</body>
<!--end::Body-->

</html>