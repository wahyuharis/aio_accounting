<?php
$this->load->model('auth/auth_model');
$auth = new Auth_model();
$user_data = $auth->get_userdata();

$this->load->model('_etc/menu_model');
$menu = new Menu_model();

$this->load->library('_etc/Application_model');
$app = new Application_model();


$_SESSION['url_controller'] = $url_controller;

$app_name = $app->get_all_data()['application_name'];
$company_name = $app->get_all_data()['company_name'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $page_title ?> - <?= $app_name ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <?php if (isset($css_files)) { ?>
            <?php foreach ($css_files as $css) { ?>
                <link href="<?= $css ?>" rel="stylesheet">
            <?php } ?>
        <?php } ?>
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/css.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/plugins/pace/pace.min.css">
        <!--<link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">-->
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <!--<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">-->
        <style>
            body{
                font-family: 'Roboto', sans-serif;
                color: #5d5d5d
            }
        </style>

        <!-- jQuery 3 -->
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/PACE/pace.min.js"></script>

        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <?php if (isset($js_files)) { ?>
            <?php foreach ($js_files as $js) { ?>
                <script src="<?= $js ?>"></script>
            <?php } ?>
        <?php } ?>
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/dist/js/adminlte.js"></script>

        <script>
            $(document).ready(function () {
//                $.fn.select2.defaults.set("theme", "bootstrap");

            });
            $(document).ajaxStart(function () {
                Pace.restart();
            })
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?= base_url() ?>Home" class="logo">
                    Dashboard
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <li class="hidden dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Fitur Baru</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                    page and may cause design problems
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-red"></i> 5 new members joined
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-user text-red"></i> You changed your username
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- Tasks: style can be found in dropdown.less -->

                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url() ?>AdminLTE-2.4.2/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?= ucwords($user_data['username']) ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="hidden user-header">
                                        <img src="<?php echo base_url() ?>AdminLTE-2.4.2/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                        <p>
                                            <span>Welcome,</span>
                                        <h2><?= ucwords($user_data['username']) ?></h2>
                                        <small></small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url() ?>AdminLTE-2.4.2/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            <?= ucwords($user_data['username']) ?>
                                        </p>
                                    </li>
                                    <li class="user-body">
                                        <div class="row">

                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-primary btn-flat">Profile & Password</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?= base_url() ?>auth/logout" class="btn btn-primary btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url() ?>AdminLTE-2.4.2/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?= ucwords($user_data['username']) ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form id="search_form" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="side_filter" id="side_filter" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li>
                            <a href="<?= base_url() . 'home' ?>">
                                <i class="fa fa-home"></i> <span>Home</span>
                            </a>
                        </li>

                        <?php $menu1 = $menu->get_menu(0, ''); ?>
                        <?php foreach ($menu1 as $row) { ?>
                            <?php
                            $active = ' active ';
                            $active = '';
                            $treeview = '';
                            $chevron = '<span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>';

                            $menu2 = $menu->get_menu(1, $row['id_menu']);
                            $url = base_url() . $row['url_controller'];
                            if (empty(trim($row['url_controller']))) {
                                $url = '#';
                            }
                            if (count($menu2) > 0) {
                                $treeview = ' treeview ';
                            }
                            ?>

                            <li class="<?= $active ?> <?= $treeview ?>">
                                <a href="<?= $url ?>">
                                    <i class="<?= $row['logo'] ?>"></i> <span><?= $row['nama'] ?></span>
                                    <?php if (count($menu2) > 0) { ?>
                                        <?= $chevron ?>
                                    <?php } ?>
                                </a>
                                <ul class="treeview-menu" style="display:none;">
                                    <?php foreach ($menu2 as $row2) { ?>
                                        <?php
                                        $active3 = "";
                                        if (strtolower(trim($row2['url_controller'], "/")) == strtolower(trim($url_controller, "/"))) {
                                            $active3 = " active ";
                                        }
                                        ?>
                                        <?php $menu3 = $menu->get_menu(2, $row2['id_menu']) ?>
                                        <?php
                                        $url = base_url() . $row2['url_controller'];
                                        if (empty(trim($row2['url_controller']))) {
                                            $url = '#';
                                        }
                                        $treeview = '';
                                        if (count($menu3) > 0) {
                                            $treeview = ' treeview ';
                                        }
                                        ?>
                                        <li class="<?= $active3 ?> <?= $treeview ?>" >
                                            <a href="<?= $url ?>"><i class="<?= $row2['logo'] ?>"></i> 
                                                <?= $row2['nama'] ?>
                                                <?php if (count($menu3) > 0) { ?>
                                                    <?= $chevron ?>
                                                <?php } ?>
                                            </a>
                                            <ul class="treeview-menu" style="display:none;">
                                                <?php foreach ($menu3 as $row3) { ?>
                                                    <?php
                                                    $active3 = "";
                                                    if (strtolower(trim($row3['url_controller'], "/")) == strtolower(trim($url_controller, "/"))) {
                                                        $active3 = " active ";
                                                    }
                                                    $url = base_url() . $row3['url_controller'];
                                                    if (empty(trim($row3['url_controller']))) {
                                                        $url = '#';
                                                    }
                                                    ?>
                                                    <li class="<?= $active3 ?>">
                                                        <a href="<?= $url ?>"><i class="<?= $row3['logo'] ?>"></i> 
                                                            <?= $row3['nama'] ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <li style="height: 100px;display: block">

                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header hidden">
                    <h1>
                        Titel
                        <small>Subtitel</small>

                    </h1>
                    <ol class="breadcrumb hidden">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php if (!empty($this->session->flashdata('general_error'))) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $this->session->flashdata('general_error') ?>
                        </div>
                    <?php } ?>


                    <?php echo $content ?>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.0
                </div>
                <strong>Copyright &copy; 2014-2016 <a href=""><?= $app_name ?>  - <?= $company_name ?></a>.</strong> All rights
                reserved.
            </footer>

        </div>
        <!-- ./wrapper -->
        <script>
            $(document).ready(function () {
                $('form').attr('autocomplete', 'off');


                $("#side_filter").keyup(function () {
                    var filter = $(this).val(), count = 0;

                    $('.sidebar-menu').find('li').each(function () {
                        if (filter == "") {
                            $(this).css("visibility", "visible");
                            $(this).fadeIn();
                        } else if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                            $(this).css("visibility", "hidden");
                            $(this).fadeOut();
                        } else {
                            $(this).css("visibility", "visible");
                            $(this).fadeIn();
                        }
                    });
                });

                $("#search_form").on("submit", function (event) {
                    event.preventDefault();
                    //console.log( $( this ).serialize() );
                });

                var aktiv_ul = $('.sidebar-menu').find('.active').parents("ul.treeview-menu");
                var aktiv_li = $('.sidebar-menu').find('.active').parents("li.treeview");
                aktiv_li.addClass("menu-open");
                aktiv_ul.css("display", "block");

            });

//            console.log($(window).width());

            $('.slimScrollBar').ready(function () {
                if ($(window).width() < 750) {
                    setTimeout(function () {
                        $('.slimScrollBar').remove();
                        $('.sidebar').css('overflow-y', 'scroll');
                    }, 1000);
                }
            });


        </script>
    </body>
</html>

