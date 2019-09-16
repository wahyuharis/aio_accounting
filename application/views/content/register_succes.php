<?php
$ci = &get_instance();
$ci->load->model('Application_model');
$app_model = new Application_model();
$app = $app_model->get_all_data();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $app['application_name'] ?> - Register</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/plugins/iCheck/square/blue.css">

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style>
            .container-cb {
                display: block;
                position: relative;
                padding-left: 35px;
                margin-bottom: 25px;
                cursor: pointer;
                font-size: 22px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container-cb input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }

            /* Create a custom checkbox */
            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 25px;
                width: 25px;
                /*background-color: #eee;*/
                border:1px solid #aaa;
            }

            /* On mouse-over, add a grey background color */
            .container-cb:hover input ~ .checkmark {
                /*background-color: #ccc;*/
            }

            /* When the checkbox is checked, add a blue background */
            .container-cb input:checked ~ .checkmark {
                /*background-color: #2196F3;*/
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
                content: "";
                position: absolute;
                display: none;
            }

            /* Show the checkmark when checked */
            .container-cb input:checked ~ .checkmark:after {
                display: block;
            }

            /* Style the checkmark/indicator */
            .container-cb .checkmark:after {
                left: 7px;
                top: 0px;
                width: 8px;
                height: 17px;
                border: solid #5d5d5d;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
        </style>
    </head>
    <body class="hold-transition register-page">


        <div class="register-box">
            <div class="register-logo">
                <p>Register <a href="#"><b>Succes</b></a></p>
            </div>

            <div class="register-box-body">
                
                <p class="login-box-msg">Registrasi telah berhasil, silakan cek email anda untuk melakukan konfirmasi</p>
                <p class="login-box-msg">
                    <a class="btn btn-primary" href="#">Kirim Ulang Email</a>
                    <a class="btn btn-primary"  href="<?=base_url()?>auth/login">Login</a>
                </p>
                <p class="login-box-msg">Jika dalam 10 menit anda belum menerima email, silakan klik tombol kirim email diatas ini</p>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->


        <!-- jQuery 3 -->
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url() ?>AdminLTE-2.4.2/plugins/iCheck/icheck.min.js"></script>


    </body>
</html>
