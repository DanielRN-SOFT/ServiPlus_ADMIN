<?php
require_once '../model/usuarios.php';

session_start();

if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
  header("Location: ./login.php");
  exit();
}
$usuarios = new Usuarios();
$usuarios = $_SESSION["usuario"];
$rol = $usuarios->getRol();

?>

<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>AdminLTE | Grafico de barras</title>

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
  <!-- apexcharts -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
    integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
    crossorigin="anonymous" />
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
                  Informacion
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
                  <a href="./cargos.php" class="nav-link">
                    <i class="fa-regular fa-eye"></i>
                    <p>Cargos</p>
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
              <a href="./graficoBarras.php" class="nav-link active">
                <i class="fa-solid fa-signal"></i>
                <p>Empleados</p>
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
              <h3 class="mb-0">Graficos de barras</h3>
            </div>

          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row mt-3">
            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Cantidad de empleados por departamento</h3>

                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">


                    <canvas id="graficoDepartamentos" width="350" height="200"></canvas>


                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <div id="visitors-chart"></div>
                  </div>
                </div>
              </div>
              <!-- /.card -->


              <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Cantidad de personas por cargo</h3>

                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <canvas id="graficoCargos" width="350" height="200"></canvas>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <div id="sales-chart"></div>
                  </div>


                </div>
              </div>
              <!-- /.card -->


            </div>
            <!-- /.col-md-6 -->
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
        <a href="#" class="text-decoration-none">ServiPlus.com</a>.
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

  <script src="https://kit.fontawesome.com/4c0cbe7815.js" crossorigin="anonymous"></script>
  <script src="../public/js/graficoDepartamento.js"></script>
  <script src="../public/js/graficoCargo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!--end::OverlayScrollbars Configure-->
</body>
<!--end::Body-->

</html>