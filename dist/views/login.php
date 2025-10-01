<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>AdminLTE 4 | Login Page</title>

  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

  <!--end::Accessibility Meta Tags-->

  <!--begin::Accessibility Features-->
  <!-- Skip links will be dynamically added by accessibility.js -->
  <link rel="preload" href="../css/adminlte.css" as="style" />
  <link rel="shortcut icon" href="../assets/img/serviplus.avif" type="image/x-icon">
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

  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--  JS externo -->
  <script src="../public/js/login.js"></script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="login-page bg-body-secondary">
  <div class="login-box">
    <div class="login-logo">
      <a href="./login.php" class="fw-bold text-uppercase"><b>Servi</b>Plus</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Ingrese sus datos para iniciar sesion</p>

        <form action="" method="post" id="frmLogin">
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
            <div class="form-floating">
              <input type="number" class="form-control" id="numDocumento" name="numDocumento" placeholder="1113867890">
              <label for="numDocumento">No. de Identificacion</label>
            </div>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
            <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
              <label for="password">Password</label>
            </div>
          </div>
          <button type="" class="btn btn-primary w-100 mt-3 fs-5 btn-login">Ingresar <i class="fa-solid fa-right-to-bracket"></i></button>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

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
  <!--end::OverlayScrollbars Configure-->
  <!--end::Script-->
</body>
<!--end::Body-->

</html>