<?php
session_start();
// if (!isset($_SESSION["user_session"]) && $_SESSION['user_session']['rol_id'] === 1) {
if (isset($_SESSION['user_session'])) {
  $userData = $_SESSION['user_session'];
  // echo $userData['user'];
  // die();
  $modulo = $_REQUEST['modulo'] ?? '';
?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asotaeco | Dashboard</title>
    <?php require_once('../html/header.php'); ?>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Preloader -->
      <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" img src="../../public/dist/img/aso.png" height="200" width="200">
      </div> -->

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->

          <a class="nav-link" href="index.php?modulo=editarUsuario&id=<?php echo $userData['user_id']; ?>">
            <i class="far fa-user"></i>
            <?php echo $userData['nombre']; ?>
          </a>
          <a class="nav-link text-danger" href="../../config/Logout.php" title="Cerrar Sesión">
            <i class="fas fa-door-closed    "></i>
          </a>

        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
          <img src="../../public/dist/img/aso.png" alt="Asotaeco" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Asotaeco</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user index (optional) -->
          <div class="user-index mt-3 pb-3 mb-3 d-flex">
            <div class="info">
              <a href="#" class="d-block"><?php echo $userData['nombre']; ?></a>
            </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
                  <p>
                    Ecommerce
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="index.php?modulo=estadisticas" class="nav-link <?php echo ($modulo == "estadisticas" || $modulo == "") ? " active " : " "; ?>">
                      <i class="far fa-chart-bar nav-icon"></i>
                      <p>Estadísticas</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="index.php?modulo=usuarios" class="nav-link <?php echo ($modulo == "usuarios" || $modulo == "crearUsuario" || $modulo == "editarUsuario") ? " active " : " "; ?> ">
                      <i class="far fa-user nav-icon"></i>
                      <p>Usuarios</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="index.php?modulo=productos" class="nav-link <?php echo ($modulo == "productos" || $modulo == "editarp") ? " active " : " "; ?>  ">
                      <i class="fa fa-shopping-bag nav-icon" aria-hidden="true"></i>
                      <p>Productos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=alertas" class="nav-link <?php echo ($modulo == "alertas") ? " active " : " "; ?>  ">
                      <i class="fa fa-bell-o nav-icon" aria-hidden="true"></i>
                      <p>Alertas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=publicidad" class="nav-link <?php echo ($modulo == "publicidad") ? " active " : " "; ?> ">
                      <i class="fa fa-bullhorn nav-icon"></i>
                      <p>Publicidad</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="index.php?modulo=proveedores" class="nav-link <?php echo ($modulo == "proveedores") ? " active " : " "; ?> ">
                      <i class="fa fa-truck nav-icon"></i>
                      <p>Proveedores</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="index.php?modulo=ventas" class="nav-link <?php echo ($modulo == "ventas") ? " active " : " "; ?> ">
                      <i class="fa fa-table nav-icon"></i>
                      <p>Ventas</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="index.php?modulo=reportes" class="nav-link <?php echo ($modulo == "reportes") ? " active " : " "; ?> ">
                      <i class="fa fa-table nav-icon"></i>
                      <p>Reporte</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=reportes" class="nav-link <?php echo ($modulo == "reportes") ? " active " : " "; ?> ">
                      <i class="fa fa-table nav-icon"></i>
                      <p>Mercansia</p>
                    </a>
                  </li>


                </ul>
          </nav>

          <!-- /.sidebar-menu -->
        </div>

        <!-- /.sidebar -->
      </aside>
      <?php
      if (isset($_REQUEST['mensaje'])) {
      ?>
        <div class="alert alert-primary alert-dismissible fade show float-right" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <?php echo $_REQUEST['mensaje'] ?>
        </div>
      <?php
      }
      if ($modulo == "estadisticas" || $modulo == "") {
        include_once "../estadisticas/index.php";
      }
      if ($modulo == "usuarios") {
        include_once "../usuarios/index.php";
      }
      if ($modulo == "productos") {
        include_once "../productos/index.php";
      }
      if ($modulo == "alertas") {
        include_once "../alertas/index.php";
      }
      if ($modulo == "reportes") {
        include_once "../reportes/index.php";
      }
      if ($modulo == "ventas") {
        include_once "../ventas/index.php";
      }
      if ($modulo == "crearUsuario") {
        include_once "../crearUsuario/index.php";
      }
      if ($modulo == "editarUsuario") {
        include_once "../editarUsuario/index.php";
      }
      if ($modulo == "productos") {
        include_once "../productos/index.php";
      }
      if ($modulo == "editarp") {
        include_once "../editarp/index.php";
      }
      if ($modulo == "publicidad") {
        include_once "../publicidad/index.php";
      }
      if ($modulo == "proveedores") {
        include_once "../proveedores/index.php";
      }
      ?>



    </div>
    <?php require_once('../html/MainJS.php') ?>

  </body>

  </html>
<?php
} else {
  header("Location: ../../index.php");
  exit();
}
?>