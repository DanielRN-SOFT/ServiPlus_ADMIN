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
$rol = $usuarios->getRol();
$nombreRol = $usuarios->getNombreRol();

$mysql = new MySQL();
$mysql->conectar();

$empleados = $mysql->efectuarConsulta("SELECT IDempleado, nombre, numDocumento, roles.nombre_rol, cargos.nombreCargo, departamentos.nombreDepartamento, fechaIngreso, salarioBase, estado, correoElectronico, telefono, imagen FROM empleados JOIN cargos ON cargos.IDcargo = empleados.cargo_id JOIN departamentos ON departamentos.IDdepartamento = empleados.departamento_id JOIN roles ON rol_id = id_rol");

$cargos = $mysql->efectuarConsulta("SELECT * FROM cargos");
$departamentos = $mysql->efectuarConsulta("SELECT * FROM departamentos");
$roles = $mysql->efectuarConsulta("SELECT * FROM roles");




?>

<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ServiPlus | Ver empleados</title>
  <link rel="preload" href="./css/adminlte.css" as="style" />
  <link rel="shortcut icon" href="./assets/img/serviplus.avif" type="image/x-icon">
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

  <link rel="stylesheet" href="./assets/css/styles.css">

  <!-- Datatables -->

  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/columncontrol/1.1.0/css/columnControl.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.1.1/css/colReorder.dataTables.css" />

  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.6/css/responsive.dataTables.css" />
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary text-principal">
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
            <a href="./index.php" class="nav-link">Home</a>
          </li>

        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="./controllers/logout.php" class="btn nav-link btn-eliminar bg-danger rounded-5 text-light">
              <p> <i class="fa-solid fa-right-from-bracket"></i> Log out</p>
            </a>
          </li>

        </ul>
        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-sena texto-principal shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.php" class="brand-link">
          <!--begin::Brand Image-->
          <img
            src="./assets/img/serviplus.avif"
            alt="AdminLTE Logo"
            class="brand-image opacity-75 shadow rounded-4" />
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">ServiPlus</span>
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
            <li class="nav-item menu-open fw-bold">
              <a href="#" class="nav-link active">
                <i class="bi bi-person"></i>
                <p class="">
                  Informacion
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./index.php" class="nav-link active">
                    <i class="fa-regular fa-eye"></i>
                    <p>Empleados</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="./views/departamentos.php" class="nav-link">
                    <i class="fa-regular fa-eye"></i>
                    <p>Departamentos</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="./views/cargos.php" class="nav-link">
                    <i class="fa-regular fa-eye"></i>
                    <p>Cargos</p>
                  </a>
                </li>

              </ul>
            </li>
            <?php if ($rol == 1) { ?>
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
                      <i class="fa-solid fa-building-user"></i>
                      <p>PDF por departamento</p>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="nav-header">GRAFICOS</li>
              <li class="nav-item">
                <a href="./views/graficoBarras.php" class="nav-link">
                  <i class="fa-solid fa-signal"></i>
                  <p class="">Empleados</p>
                </a>
              </li>
            <?php } ?>
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
              <h3 class="mb-0 fw-bold texto-principal">Empleados</h3>
              <h4 class="mt-2">Bienvenido: <span class="fw-bold text-primary"><?php echo $nombre ?> </span> </h4>
            </div>

          </div>
          <?php if ($rol == 1) { ?>
            <div class="row my-2">
              <div class="col-sm-12">
                <button class="btn btn-success btn-confirmar w-100 fs-5" id="abrirCrearFrm">Crear empleado</button>
              </div>
            </div>
          <?php } ?>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">
                  <h5 class="card-title fw-bold fs-5 texto-principal">Lista de empleados</h5>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                      <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                      <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                    <div class="btn-group">

                    </div>

                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="col-md-12" id="contenedorTabla">
                      <div>
                        <table class="table texto-principal table-striped table-bordered display" id="tblInformacion">
                          <thead class="text-center">
                            <tr class="bg bg-dark">
                              <th scope="col" class="text-dark">Imagen</th>
                              <th scope="col" class="text-dark">Nombre</th>
                              <th scope="col" class="text-dark">No. Documento</th>
                              <th scope="col" class="text-dark">Departamento</th>
                              <th scope="col" class="text-dark">Cargo</th>
                              <?php if ($rol == 1) { ?>
                                <th scope="col" class="text-dark">Rol</th>
                              <?php } ?>
                              <th scope="col" class="text-dark"> Ingreso</th>
                              <th scope="col" class="text-dark">Salario</th>
                              <th scope="col" class="text-dark">Estado</th>
                              <th scope="col" class="text-dark">Telefono</th>
                              <th scope="col" class="text-dark">E-mail</th>
                              <?php if ($rol == 1) { ?>
                                <th scope="col" class="text-dark">Acciones</th>
                              <?php } ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php while ($fila = $empleados->fetch_assoc()): ?>
                              <tr class="texto-principal">
                                <td class="text-center">
                                  <img src=" <?php echo $fila["imagen"] ?>" class="img-fluid" width="50" alt="">
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
                                <?php if ($rol == 1) { ?>
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
                                <?php
                                if ($rol == 1) { ?>
                                  <td>
                                    <button class="btn btn-primary mx-1 btn-editar btn-informacion" data-id="<?php echo $fila["IDempleado"] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <?php
                                    if ($fila["estado"] == "Activo") { ?>
                                      <button class="btn btn-danger btn-eliminar btn-eliminarEmp" data-nombre="<?php echo $fila['nombre']; ?>" data-num="<?php echo $fila["numDocumento"] ?>"
                                        data-id="<?php echo $fila['IDempleado']; ?>">
                                        <i class="fa-solid fa-trash"></i>
                                      </button>
                                    <?php } else { ?>
                                      <button class="btn btn-confirmar btn-success btn-reintegrar" data-nombre="<?php echo $fila['nombre']; ?>" data-id="<?php echo $fila["IDempleado"] ?>" data-num="<?php echo $fila['numDocumento']; ?>"><i class="fa-solid fa-check"></i></button>
                                    <?php } ?>
                                  </td>
                                <?php } ?>
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
        <a href="#" class="text-decoration-none">Serviplus.com</a>.
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
  <!-- DataTables -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/columncontrol/1.1.0/js/dataTables.columnControl.js"></script>
  <script src="https://cdn.datatables.net/columncontrol/1.1.0/js/columnControl.dataTables.js"></script>

  <script src="https://cdn.datatables.net/colreorder/2.1.1/js/dataTables.colReorder.js"></script>
  <script src="https://cdn.datatables.net/colreorder/2.1.1/js/colReorder.dataTables.js"></script>

  <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.6/js/dataTables.responsive.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.6/js/responsive.dataTables.js"></script>

  <script src="./public/js/datatable.js"></script>

  <!-- Fin DataTables -->

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--  JS externo -->
  <script src="./public/js/gestionarEmpleados.js"></script>
  <!--end::Script-->
</body>
<!--end::Body-->

</html>