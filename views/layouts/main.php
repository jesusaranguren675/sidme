<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100" id="page-top">
<?php $this->beginBody() ?>

<?php

//Si el usuario es invitado se mostrara el contenido siguiente
///////////////////////////////////////////////////////////////
if (Yii::$app->user->isGuest)
{
    echo $content;
}
else //Si no es invitado se mostrara el contenido siguiente
{


?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar MENU LATERAL -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= Url::toRoute('site/dashboard'); ?>">
                <div class="sidebar-brand-icon">
                    <img style="width: 6rem; height:3rem;" src="<?=  Url::to('@web/img/logo.png') ?>">
                </div>
                <div class="sidebar-brand-text mx-3"> <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <!--
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>
            -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                PRINCIPAL
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <!--
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-heartbeat"></i>
                    <span>Medicamentos</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestionar:</h6>-->
                        <!--
                        <a class="collapse-item" href="<?= Url::toRoute('site/buttons'); ?>">Buttons</a>
                        <a class="collapse-item" href="<?= Url::toRoute('site/about'); ?>">About</a>
                        <a class="collapse-item" href="<?= Url::toRoute('site/cards'); ?>">Cards</a>
                        -->
                        <!--
                        <a class="collapse-item" href="<?= Url::toRoute('medialmaxpre/index'); ?>">Almacen</a>
                        <a class="collapse-item" href="<?= Url::toRoute('medialmaxpre/index'); ?>">Farmacia</a>
                    </div>
                </div>
            </li>-->

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMedicamentos"
                    aria-expanded="true" aria-controls="collapseMedicamentos">
                    <i class="fas fa-capsules"></i>
                    <span>Medicamentos</span>
                </a>
                <div id="collapseMedicamentos" class="collapse" aria-labelledby="headingFarmacia" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= Url::toRoute('entradasmedicamentos/index'); ?>"><i class="fas fa-capsules"></i> Recepción</a>
                        <a class="collapse-item" href="<?= Url::toRoute('medicamentos/index'); ?>"><i class="fas fa-capsules"></i> Medicamentos</a>
                        <a class="collapse-item" href="<?= Url::toRoute('tipomedicamento/index'); ?>"><i class="fas fa-prescription-bottle"></i> Presentaciones</a>
                    </div>
                    
                </div>
            </li>

            <!--
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::toRoute('entradasmedicamentos/index'); ?>">
                    <i class="fas fa-capsules"></i>
                    <span>Recepción de Medicamentos</span>
                </a>
            </li>
            -->

            <!--
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::toRoute('medicamentos/index'); ?>">
                    <i class="fas fa-capsules"></i>
                    <span>Medicamentos</span>
                </a>
            </li>
            -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDistribucion"
                    aria-expanded="true" aria-controls="collapseDistribucion">
                    <i class="fas fa-capsules"></i>
                    <span>Distribución</span>
                </a>
                <div id="collapseDistribucion" class="collapse" aria-labelledby="headingFarmacia" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= Url::toRoute('almacengeneral/index'); ?>"><i class="fas fa-warehouse"></i> Inventario</a>
                        <a class="collapse-item" href="<?= Url::toRoute('pedidos/index'); ?>"><i class="fas fa-file-signature"></i> Pedidos</a>
                        <a class="collapse-item" href="<?= Url::toRoute('distribucion/index'); ?>"><i class="fas fa-truck-loading"></i> Distribución</a>
                    </div>
                    
                </div>
            </li>

            <!--
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::toRoute('almacengeneral/index'); ?>">
                    <i class="fas fa-warehouse"></i>
                    <span>Inventario</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= Url::toRoute('pedidos/index'); ?>">
                    <i class="fas fa-file-signature"></i>
                    <span>Pedidos</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= Url::toRoute('distribucion/index'); ?>">
                    <i class="fas fa-truck-loading"></i>
                    <span>Distribución</span>
                </a>
            </li>
                        -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                CONFIGURACIÓN
            </div>

            <li class="nav-item">
                <a class="nav-link" href="<?= Url::toRoute('sede/index'); ?>">
                    <i class="fas fa-university"></i>
                    <span>Sedes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRolesypermisos"
                    aria-expanded="true" aria-controls="collapseRolesypermisos">
                    <i class="fas fa-user-lock"></i>
                    <span>Usuarios y Roles</span>
                </a>
                <div id="collapseRolesypermisos" class="collapse" aria-labelledby="headingFarmacia" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= Url::toRoute('user/index'); ?>"><i class="fas fa-users"></i> Usuarios</a>
                        <a class="collapse-item" href="<?= Url::toRoute('roles/index'); ?>"><i class="fas fa-user-lock"></i> Roles</a>
                        <a class="collapse-item" href="<?= Url::toRoute('asignacionroles/index'); ?>"><i class="fas fa-people-arrows"></i> Asignaciones</a>
                    </div>
                    
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <!--
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFarmacia"
                    aria-expanded="true" aria-controls="collapseFarmacia">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    <span>Farmacia</span>
                </a>
                <div id="collapseFarmacia" class="collapse" aria-labelledby="headingFarmacia" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= Url::toRoute('medialmaxpre/index'); ?>">Asignación</a>
                    </div>
                </div>
            </li>
-->

            <!-- Divider -->
            <!--<hr class="sidebar-divider">-->

            <!-- Heading -->
            <!--
            <div class="sidebar-heading">
                Addons
            </div>
            -->




            <!-- Divider -->
            <br>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar MENU LATERAL-->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <!--
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                Counter - Alerts
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            Dropdown - Alerts
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>
                        -->

                        <!-- Nav Item - Messages -->
                        <!--
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                Counter - Messages
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            Dropdown - Messages
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>-->

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php
                                    if(isset(Yii::$app->user->identity->username))
                                    {
                                        echo Yii::$app->user->identity->username;
                                    }
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <!--CERRAR SESIÓN -->
                                    <!-- ------------ -->
                                    <?=
                                    $menuItems[] = ''
                                    . Html::beginForm(['/site/logout'], 'post')
                                    . Html::submitButton(
                                        '<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Cerrar sesión',
                                        ['class' => 'btn btn-sm']
                                    )
                                    . Html::endForm()
                                    . '';
                                    ?>
                                    <!--CERRAR SESIÓN -->
                                    <!-- ------------ -->
                                </a>

                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- CONTENIDO DEL FRAMEWORK-->
                <div class="container-fluid">
                    <?= $content ?>
                </div>
                <!-- /.container-fluid -->
                <!-- FIN CONTENIDO DEL FRAMEWORK -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>


<?php 
}

//Cierre de condición
/* ------------------ */
$this->endBody() 

?>
</body>
</html>
<?php $this->endPage() ?>
