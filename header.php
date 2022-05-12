<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventario V.0.1</title>

    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!--- TOGGLE--->
    <link href="./css/bootstrap4-toggle.min.css" rel="stylesheet">
    <!--Togle de carpeta--->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap4-toggle.css">
    <link rel="stylesheet" href="doc/stylesheet.css">
</head>

<body id="page-top">
    <?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Validar que tiene acceso a la pagina

if ( empty( $_SESSION['id']) ) {
  header("location: login.php");
  exit();
}
?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Inventario <sup>V.0.1</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Tablas
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
            <?php if ($_SESSION['admin']) { ?>
                        
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-thin fa-user"></i>
                    <span>Usuarios</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="usuarios.php">Gestion de usuarios</a>
                        <h6 class="collapse-header">Permisos</h6>
                        <a class="collapse-item" href="permisos.php">Asignar o Restringir</a>
                        
                    </div>
                </div>
            </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmpresas" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-thin fa-user"></i>
                    <span>Empresas</span>
                </a>
                <div id="collapseEmpresas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="index.php">Gestion de empresas</a>
                        <a class="collapse-item" href="patrimonio.php">Patrimonio</a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArticulos" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-thin fa-user"></i>
                    <span>Articulos</span>
                </a>
                <div id="collapseArticulos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <?php if ($_SESSION['admin']) { ?>
                        <a class="collapse-item" href="articulos.php">Gestion de articulos</a>
                        <a class="collapse-item" href="categoria.php">Categorias</a>
                        <h6 class="collapse-header">Atributos</h6>
                        <a class="collapse-item" href="caracteristicas.php">Caracteristicas</a>
                        <a class="collapse-item" href="atributos.php">Asignacion</a>
                        <h6 class="collapse-header">Reportes</h6>
                        <?php } ?>
                        <a class="collapse-item" href="enarriendo.php">En arriendo</a>
                        <a class="collapse-item" href="disponibles.php">Disponibles</a>
                        <a class="collapse-item" href="caract.php">Caracteristicas</a>
                        <a class="collapse-item" href="valorartic.php">Valores</a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="trabajador.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Trabajadores</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContratos" aria-expanded="true" aria-controls="collapseContratos">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Contratos</span>
                </a>
                <div id="collapseContratos" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="contratos.php">Gestion de contratos</a>
                      <h6 class="collapse-header">Reportes</h6>
                        <a class="collapse-item" href="repContrato.php">Reporte de Contratos</a>

                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                EN DESARROLLO
            </div>

            

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Notificaciones</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Mensajería</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>Inventario</strong> es una pagina desarrollada por la empresa Kamaleon</p>
                <a class="btn btn-success btn-sm" href="https://kamaleon.cl/" target="_blank" rel="noopener noreferrer">Contactanos</a>
            </div>

        </ul>
        <!-- End of Sidebar -->