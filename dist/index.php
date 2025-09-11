<?php
require_once 'model/MYSQL.php';
require_once 'model/usuarios.php';
session_start();

if ($_SESSION['acceso'] == NULL || $_SESSION["acceso"] == false) {
  header("Location: ./views/login.php");
  exit();
}

$usuarios = new usuarios();
$usuarios = $_SESSION['usuario'];
$nombre = $usuarios->getNombre();
$rol = $usuarios->getCargo();
$nombreRol = $usuarios->getNombreRol();

$mysql = new MySQL();
$mysql->conectar();

$empleados = $mysql->efectuarConsulta("SELECT IDempleado, nombre, numDocumento, roles.nombre_rol, cargos.nombreCargo, departamentos.nombreDepartamento, fechaIngreso, salarioBase, estado, correoElectronico, telefono, imagen FROM empleados JOIN cargos ON cargos.IDcargo = empleados.cargo_id JOIN departamentos ON departamentos.IDdepartamento = empleados.departamento_id JOIN roles ON rol_id = id_rol");



if (isset($_GET['IDempleado'])) {
  $id = intval($_GET['IDempleado']);
  $empleados = $mysql->efectuarConsulta("SELECT * FROM empleados WHERE IDempleado = '$id'");
  $cargos = $mysql->efectuarConsulta("SELECT * FROM cargos");
  $departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos");
  $roles = $mysql->efectuarConsulta("SELECT * FROM roles");
?>
  <div class="modal show" id="exampleModal" tabindex="-1" style="display:block; background:rgba(0,0,0,0.5);">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title fw-bold">Editar empleado</h5>
          <a href="index.php" class="btn-close"></a>
        </div>
        <div class="modal-body">
          <form action="./controllers/editarEmpleado.php" method="post" enctype="multipart/form-data" class="px-3">
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
                <input type="text" class="form-control" id="oldPassword" name="oldPassword" value="">
              </div>
              <div class="col-md-6">
                <label for="newPassword" class="form-label">Contraseña nueva:</label>
                <input type="text" class="form-control" id="oldPassword" name="newPassword" value="">
              </div>
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold fs-5">Enviar</button>
            <div class="text-center mt-3">
              <a href="../index.php" class="text-center">Volver al listado de empleados</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>




<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>AdminLTE | Ver empleados</title>

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
  <link rel="stylesheet" href="./css/adminlte.css" />
  <!--end::Required Plugin(AdminLTE)-->

  <!-- apexcharts -->

  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/columncontrol/1.1.0/css/columnControl.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.1.1/css/colReorder.dataTables.css" />

  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.6/css/responsive.dataTables.css" />

</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a href="#" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a href="#" class="nav-link">Contact</a>
          </li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <!--begin::Navbar Search-->
          <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
              <i class="bi bi-search"></i>
            </a>
          </li>
          <!--end::Navbar Search-->

          <!--begin::Messages Dropdown Menu-->
          <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
              <i class="bi bi-chat-text"></i>
              <span class="navbar-badge badge text-bg-danger">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img
                      src="./assets/img/user1-128x128.jpg"
                      alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      Brad Diesel
                      <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                    </h3>
                    <p class="fs-7">Call me whenever you can...</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img
                      src="./assets/img/user8-128x128.jpg"
                      alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      John Pierce
                      <span class="float-end fs-7 text-secondary">
                        <i class="bi bi-star-fill"></i>
                      </span>
                    </h3>
                    <p class="fs-7">I got your message bro</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img
                      src="./assets/img/user3-128x128.jpg"
                      alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      Nora Silvester
                      <span class="float-end fs-7 text-warning">
                        <i class="bi bi-star-fill"></i>
                      </span>
                    </h3>
                    <p class="fs-7">The subject goes here</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
          </li>
          <!--end::Messages Dropdown Menu-->

          <!--begin::Notifications Dropdown Menu-->
          <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
              <i class="bi bi-bell-fill"></i>
              <span class="navbar-badge badge text-bg-warning">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <span class="dropdown-item dropdown-header">15 Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-envelope me-2"></i> 4 new messages
                <span class="float-end text-secondary fs-7">3 mins</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-people-fill me-2"></i> 8 friend requests
                <span class="float-end text-secondary fs-7">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                <span class="float-end text-secondary fs-7">2 days</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
            </div>
          </li>
          <!--end::Notifications Dropdown Menu-->

          <!--begin::Fullscreen Toggle-->
          <li class="nav-item">
            <a class="nav-link" href="#" data-lte-toggle="fullscreen">
              <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
              <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
            </a>
          </li>
          <!--end::Fullscreen Toggle-->


        </ul>
        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
          <!--begin::Brand Image-->
          <img
            src="./assets/img/AdminLTELogo.png"
            alt="AdminLTE Logo"
            class="brand-image opacity-75 shadow" />
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">AdminLTE 4</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="navigation"
            aria-label="Main navigation"
            data-accordion="false"
            id="navigation">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="bi bi-person"></i>
                <p>
                  Empleados
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./views/crearEmpleado.php" class="nav-link">
                    <i class="fa-solid fa-circle-plus"></i>
                    <p>Crear empleado</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.php" class="nav-link active">
                    <i class="fa-regular fa-eye"></i>
                    <p>Ver empleados</p>
                  </a>
                </li>

              </ul>
            </li>
            <li class="nav-header">REPORTES</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-solid fa-file-pdf"></i>
                <p>
                  PDFs
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./views/generar_pdf.php" class="nav-link">
                    <i class="fa-solid fa-globe"></i>
                    <p>PDF General</p>
                  </a>
                </li>
                <li class="nav-item">

                  <a href="./views/ListadoDepartamentosPDF.php" class="nav-link">
                    <i class="fa-solid fa-briefcase"></i>
                    <p>PDF por departamento</p>
                  </a>
                </li>

              </ul>
            </li>




            <li class="nav-header">GRAFICOS</li>
            <li class="nav-item">
              <a href="./views/graficoBarras.php" class="nav-link">
                <i class="fa-solid fa-signal"></i>
                <p>Grafico de barras</p>
              </a>
            </li>
          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0 fw-bold">Empleados</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Listado de empleados</li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
          <!-- Info boxes -->

          <!-- /.row -->

          <!--begin::Row-->
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">
                  <h5 class="card-title fw-bold">Lista de empleados</h5>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                      <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                      <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                    <div class="btn-group">
                      <button
                        type="button"
                        class="btn btn-tool dropdown-toggle"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-wrench"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" role="menu">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item"> Something else here </a>
                        <a class="dropdown-divider"></a>
                        <a href="#" class="dropdown-item">Separated link</a>
                      </div>
                    </div>
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered display" id="tblEmpleados">
                          <thead class="text-center">
                            <tr class="bg bg-dark">

                              <th scope="col" class="text-dark">Imagen</th>
                              <th scope="col" class="text-dark">Nombre</th>
                              <th scope="col" class="text-dark">No. Documento</th>
                              <th scope="col" class="text-dark">Departamento</th>

                              <th scope="col" class="text-dark">Cargo</th>
                              <?php if ($rol == 1) { ?>
                                <th scope="col" class="text-dark">Acciones</th>
                                <th scope="col" class="text-dark">Rol</th>
                              <?php } ?>

                              <th scope="col" class="text-dark"> Ingreso</th>
                              <th scope="col" class="text-dark">Salario</th>
                              <th scope="col" class="text-dark">Estado</th>
                              <th scope="col" class="text-dark">Telefono</th>
                              <th scope="col" class="text-dark">E-mail</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php while ($fila = $empleados->fetch_assoc()): ?>
                              <tr>

                                <td class="text-center">
                                  <img src=" <?php echo $fila["imagen"] ?>" width="50" alt="">
                                </td>
                                <td>
                                  <?php echo $fila["nombre"] ?>
                                </td>
                                <td>
                                  <?php echo $fila["numDocumento"] ?>
                                </td>
                                <td>
                                  <?php echo $fila["nombreDepartamento"] ?>
                                </td>

                                <td>
                                  <?php echo $fila["nombreCargo"] ?>
                                </td>
                                <?php
                                if ($rol == 1) { ?>
                                  <td>
                                    <div class="d-flex">
                                      <!-- Button trigger modal -->

                                      <a href="./index.php?IDempleado=<?php echo $fila["IDempleado"]; ?>"><button class="btn btn-outline-warning mx-2"><i class="fa-solid fa-pen-to-square"></i></button></a>

                                      <!-- Modal -->
                                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>


                                      <?php
                                      if ($fila["estado"] == "Activo") { ?>

                                        <a href="./controllers/eliminarEmpleado.php?IDempleado=<?php echo $fila["IDempleado"]; ?>" onclick="return confirm('¿Desea eliminar esta persona?')"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button></a>
                                      <?php } else { ?>
                                        <a href="./controllers/eliminarEmpleado.php?IDempleado=<?php echo $fila["IDempleado"]; ?>" onclick="return confirm('¿Desea reintegrar esta persona?')"><button class="btn btn-outline-success"><i class="fa-solid fa-check"></i></button></a>

                                      <?php } ?>
                                    </div>


                                  </td>

                                  <td>
                                    <?php echo $fila["nombre_rol"] ?>
                                  </td>
                                <?php } ?>

                                <td>
                                  <?php echo $fila["fechaIngreso"] ?>
                                </td>
                                <td>
                                  <?php echo $fila["salarioBase"] ?>
                                </td>
                                <td>
                                  <?php echo $fila["estado"] ?>
                                </td>
                                <td>
                                  <?php echo $fila["telefono"] ?>
                                </td>
                                <td>
                                  <?php echo $fila["correoElectronico"] ?>
                                </td>

                              </tr>




                            <?php endwhile; ?>
                          </tbody>

                        </table>
                      </div>
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                  </div>
                  <!--end::Row-->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!--end::Row-->

          <!--begin::Row-->

          <!--end::App Content-->
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer">
      <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline">Anything you want</div>
      <!--end::To the end-->
      <!--begin::Copyright-->
      <strong>
        Copyright &copy; 2014-2025&nbsp;
        <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
      </strong>
      All rights reserved.
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="./js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

      // Disable OverlayScrollbars on mobile devices to prevent touch interference
      const isMobile = window.innerWidth <= 992;

      if (
        sidebarWrapper &&
        OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
        !isMobile
      ) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->

  <!-- OPTIONAL SCRIPTS -->


  </script>
  <script src="https://kit.fontawesome.com/4c0cbe7815.js" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/columncontrol/1.1.0/js/dataTables.columnControl.js"></script>
  <script src="https://cdn.datatables.net/columncontrol/1.1.0/js/columnControl.dataTables.js"></script>

  <script src="https://cdn.datatables.net/colreorder/2.1.1/js/dataTables.colReorder.js"></script>
  <script src="https://cdn.datatables.net/colreorder/2.1.1/js/colReorder.dataTables.js"></script>

  <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.6/js/dataTables.responsive.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.6/js/responsive.dataTables.js"></script>

  <script src="./public/js/datatable.js"></script>
  <!--end::Script-->
</body>
<!--end::Body-->

</html>