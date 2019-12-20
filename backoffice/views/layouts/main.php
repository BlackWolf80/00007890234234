<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$page = Yii::$app->params['page'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body  class="hold-transition sidebar-mini layout-navbar-fixed">
<?php $this->beginBody() ?>


<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <?=\app\components\ParkingActivationWidget::widget(['type'=>1])?>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <?=Html::a(' <img src="/logo.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">ParkinSquatter</span>','/',['class'=>'brand-link'])?>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <?=Html::img('/dist/img/user2-160x160.jpg',['class'=>'img-circle elevation-2','alt'=>'User Image'])?>
                </div>
                <div class="info">
                    <a href="#" class="d-block">Admin</a>
                </div>
            </div>

            <!-- Sidebar Menu -->

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <?=Html::a('<i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>','/',['class'=> $page=='1'? 'nav-link active':'nav-link'])?>
                    </li>
                    <li class="nav-item has-treeview">
                        <?=Html::a('<i class="nav-icon fas fa-parking"></i><p>Парковки<i class="fas fa-angle-left right"></i></p>','#',['class'=>'nav-link'])?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <?=Html::a('<i class="far fa-circle nav-icon"></i><p>Список</p>','/parkings',['class'=>'nav-link'])?>
                            </li>
                            <li class="nav-item">
                                <?=Html::a('<i class="far fa-circle nav-icon"></i><p>Заявки на активацию</p>','/parkings/activations',['class'=>'nav-link'])?>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview <?=substr($page, 0, 1)=='9'? 'menu-open':''?>">
                        <?=Html::a('<i class="nav-icon fas fa-file"></i><p>Отчеты<i class="fas fa-angle-left right"></i></p>','#',[
                                'class'=> substr($page, 0, 1)=='9'? 'nav-link active':'nav-link'
                        ])?>
                        <ul class="nav nav-treeview" <?=substr($page, 0, 1)=='9'? 'style="display: block;"':'display: none;'?>>
                            <li class="nav-item">
                                <?=Html::a('<i class="far fa-circle nav-icon"></i><p>Продажи</p>','/payments',[
                                    'class'=> $page=='91'? 'nav-link active':'nav-link'
                                ])?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <?= Alert::widget() ?>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
<!--                            <li class="breadcrumb-item"><a href="#">Home</a></li>-->
<!--                            <li class="breadcrumb-item active">Dashboard v2</li>-->
                            <?= Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]) ?>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

            <?= $content ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php $this->endBody() ?>
<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="/dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="/plugins/raphael/raphael.min.js"></script>
<script src="/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="/plugins/jquery-mapael/maps/world_countries.min.js"></script>
<!-- ChartJS -->
<script src="/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="/dist/js/pages/dashboard2.js"></script>

<!-- DataTables -->
<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="/js/app.js"></script>


</body>
</html>
<?php $this->endPage() ?>
