<?php
$this->load->model('auth/auth_model');
$auth = new Auth_model();
$user_data = $auth->get_userdata();

$this->load->model('_etc/menu_model');
$menu = new Menu_model();

$this->load->library('_etc/Application_model');
$app = new Application_model();


$app_name = $app->get_all_data()['application_name'];
$company_name = $app->get_all_data()['company_name'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= $page_title ?> - <?= $app_name ?></title>

        <!-- Bootstrap -->
        <link href="<?= base_url() ?>/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?= base_url() ?>/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?= base_url() ?>/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?= base_url() ?>/gentelella/build/css/custom.min.css" rel="stylesheet">
        <?php if (isset($css_files)) { ?>
            <?php foreach ($css_files as $css) { ?>
                <link href="<?= $css ?>" rel="stylesheet">
            <?php } ?>
        <?php } ?>



        <!-- jQuery -->
        <script src="<?= base_url() ?>/gentelella/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?= base_url() ?>/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <?php if (isset($js_files)) { ?>
            <?php foreach ($js_files as $js) { ?>
                <script src="<?= $js ?>"></script>
            <?php } ?>
        <?php } ?>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?= base_url() ?>" class="site_title" style="font-size: 120%"> <img src="<?= base_url() ?>/uploads/logo.png" style="height: 50px;width: 50px;"> <span><?= $app_name ?></span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="<?= base_url() ?>/uploads/user.png" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2><?= ucwords($user_data['username']) ?></h2>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>General</h3>
                                <ul class="nav side-menu">
                                    <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i> Home </a>
                                    </li>
                                    <?php $menu1 = $menu->get_menu(0, ''); ?>
                                    <?php foreach ($menu1 as $row) { ?>
                                        <?php
                                        $url = '#';
                                        $chevron = '<span class="fa fa-chevron-down"></span>';
                                        if (!empty(trim($row['url_controller']))) {
                                            $chevron = '';
                                            $url = base_url() . $row['url_controller'];
                                        }
                                        ?>
                                        <li><a href="<?= $url ?>"><i class="<?= $row['logo'] ?>"></i> <?= $row['nama'] ?> <?= $chevron ?></a>
                                            <ul class="nav child_menu">
                                                <?php
                                                $menu2 = $menu->get_menu(1, $row['id_menu']);
                                                ?>
                                                <?php foreach ($menu2 as $row2) { ?>
                                                    <?php
                                                    $is_active = "";
                                                    if (strtolower($row2['url_controller']) == strtolower($url_controller)) {
                                                        $is_active = ' class="current-page" ';
                                                    }

                                                    $url = '#';
                                                    $chevron = '<span class="fa fa-chevron-down"></span>';
                                                    if (!empty(trim($row2['url_controller']))) {
                                                        $chevron = '';
                                                        $url = base_url() . $row2['url_controller'];
                                                    }
                                                    ?>
                                                    <li <?= $is_active ?> >
                                                        <a href="<?= $url ?>">
                                                            <?= $chevron ?>
                                                            <?= $row2['nama'] ?> 
                                                        </a>

                                                        <ul class="nav child_menu">
                                                            <?php
                                                            $menu3 = $menu->get_menu(2, $row2['id_menu']);
                                                            ?>
                                                            <?php foreach ($menu3 as $row3) { ?>
                                                                <?php
                                                                $is_active = "";
                                                                if (strtolower($row3['url_controller']) == strtolower($url_controller)) {
                                                                    $is_active = ' class="current-page" ';
                                                                }
                                                                ?>
                                                                <li <?= $is_active ?> >
                                                                    <a href="<?= base_url() . $row3['url_controller'] ?>">
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
                                </ul>


                            </div>
                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="<?= base_url() ?>/uploads/user.png" alt=""><?= ucwords($user_data['username']) ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="javascript:;"> Profile</a></li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="badge bg-red pull-right">50%</span>
                                                <span>Settings</span>
                                            </a>
                                        </li>
                                        <li><a href="javascript:;">Help</a></li>
                                        <li><a href="<?= base_url() ?>auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3><?= $content_title ?></h3>
                            </div>

                            <div class="title_right">

                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php if (!empty($this->session->flashdata('general_error'))) { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?= $this->session->flashdata('general_error') ?>
                                    </div>
                                <?php } ?>
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        <?= $app_name ?>  - <?= $company_name ?>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>
        <script src="<?= base_url() ?>/gentelella/template.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>/gentelella/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?= base_url() ?>/gentelella/vendors/nprogress/nprogress.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="<?= base_url() ?>/gentelella/build/js/custom.min.js"></script>
    </body>
</html>
