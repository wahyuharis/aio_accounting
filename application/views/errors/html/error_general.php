<?php
$ci = &get_instance();

$ci->load->model('auth/auth_model');
$auth = new Auth_model();
$user_data = $auth->get_userdata();

$ci->load->model('_etc/menu_model');
$menu = new Menu_model();

$ci->load->library('_etc/Application_model');
$app = new Application_model();


$app_name = $app->get_all_data()['application_name'];
$company_name = $app->get_all_data()['company_name'];
if (!isset($page_title)) {
    $page_title = "Error";
}
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
    <body class="hold-transition lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
            <h1>Oops, <?php echo $heading; ?></h1>
            <h4><?php echo $message; ?></h4>
            <?php
            $url= base_url();
            if(isset($_SESSION['url_controller'])){
                $url=$_SESSION['url_controller'];
                
            }
            ?>
            <a href="<?=base_url()?>" class="btn btn-primary"><i class="fa fa-home"></i> Dashboar Home</a>
            <a href="<?=base_url($url)?>" class="btn btn-primary"><i class="fa fa-chevron-left"></i> Kembali</a>
        </div>
        <!-- /.center -->
    </body>
</html>

