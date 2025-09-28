<?php
require_once '../model/MYSQL.php';
require_once '../model/usuarios.php';

session_start();
if ($_SESSION["acceso"] == false && $_SESSION["acceso"] == null) {
  header("Location: ./login.php");
}

$usuarios = new Usuarios();
$usuarios = $_SESSION["usuario"];
$rol = $usuarios->getRol();

$mysql = new MySQL();
$mysql->conectar();
$cargos = $mysql->efectuarConsulta("SELECT * FROM cargos");
$mysql->desconectar();
?>


<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ServiPlus | Ver Cargos</title>

  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

  <link rel="preload" href="../css/adminlte.css" as="style" />
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

  <link rel="stylesheet" href="../assets/css/styles.css">

  <!-- Datatables -->

  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/columncontrol/1.1.0/css/columnControl.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.1.1/css/colReorder.dataTables.css" />

  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.6/css/responsive.dataTables.css" />

  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../assets/css/styles.css">

  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/columncontrol/1.1.0/css/columnControl.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.1.1/css/colReorder.dataTables.css" />

  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.6/css/responsive.dataTables.css" />

</head>
<!--end::Head-->
<!--begin::Body-->

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
            <a href="../index.php" class="nav-link">Home</a>
          </li>

        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="../controllers/logout.php" class="btn nav-link bg-danger rounded-5 text-light">
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
    <aside class="app-sidebar bg-sena shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="../index.php" class="brand-link">
          <!--begin::Brand Image-->
          <img
            src="../assets/img/AdminLTELogo.png"
            alt="AdminLTE Logo"
            class="brand-image opacity-75 shadow" />
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
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="bi bi-person"></i>
                <p>
                  Información
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php if ($rol == 1) { ?>

                <?php } ?>
                <li class="nav-item">
                  <a href="../index.php" class="nav-link">
                    <i class="fa-regular fa-eye"></i>
                    <p>Empleados</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="./departamentos.php" class="nav-link">
                    <i class="fa-regular fa-eye"></i>
                    <p>Departamentos</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="./cargos.php" class="nav-link active">
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
                    <a href="./generar_pdf.php" class="nav-link">
                      <i class="fa-solid fa-globe"></i>
                      <p>PDF General</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./ListadoDepartamentosPDF.php" class="nav-link">
                      <i class="fa-solid fa-building-user"></i>
                      <p>PDF por departamento</p>
                    </a>
                  </li>
                </ul>
              </li>




              <li class="nav-header">GRAFICOS</li>
              <li class="nav-item">
                <a href="./graficoBarras.php" class="nav-link">
                  <i class="fa-solid fa-signal"></i>
                  <p>Empleados</p>
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
              <h3 class="mb-0 fw-bold">Cargos</h3>
            </div>

          </div>

          <?php if ($rol == 1) { ?>

            <div class="row my-2">
              <div class="col-sm-12">
                <button id="crearCargo" class="btn btn-primary">Crear cargo</button>
              </div>
            </div>


          <?php } ?>

          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content Header-->
      <!--begin::App Content-->
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-12">
              <!-- Default box -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Lista de departamentos</h3>

                  <div class="card-tools">
                    <button
                      type="button"
                      class="btn btn-tool"
                      data-lte-toggle="card-collapse"
                      title="Collapse">
                      <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                      <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-striped table-bordered display" id="tblEmpleados">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <?php if ($rol == 1) { ?>
                          <th>Acciones</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($fila = $cargos->fetch_assoc()): ?>
                        <tr>

                          <td> <?php echo $fila["nombreCargo"] ?> </td>
                          <td> <?php echo $fila["estadoCargo"] ?> </td>
                          <?php if ($rol == 1) { ?>
                            <td>
                              <button class="btn btn-outline-warning mx-1 btn-editar" data-id="<?php echo $fila["IDcargo"] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                              <?php
                              if ($fila["estadoCargo"] == "Activo") { ?>

                                <button class="btn btn-outline-danger btn-eliminar" data-nombre="<?php echo $fila['nombreCargo']; ?>"
                                  data-id="<?php echo $fila['IDcargo']; ?>">
                                  <i class="fa-solid fa-trash"></i>
                                </button>
                              <?php } else { ?>
                                <button class="btn btn-outline-success btn-reintegrar" data-nombre="<?php echo $fila['nombreCargo']; ?>" data-id="<?php echo $fila["IDcargo"] ?>"><i class="fa-solid fa-check"></i></button>

                              <?php } ?>



                            </td>
                          <?php } ?>
                        </tr>
                      <?php endwhile   ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->

                <!-- /.card -->
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
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
  <script src="../js/adminlte.js"></script>
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
  <!--end::Script-->

  <script src="https://kit.fontawesome.com/4c0cbe7815.js" crossorigin="anonymous"></script>

  <!-- DataTables -->
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

  <script src="../public/js/datatable.js"></script>
  <!-- FinDataTables -->
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Script interno -->
  <script src="../public/js/gestionarCargos.js"></script>
</body>
<!--end::Body-->

</html>