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

        <?php if ($this->session->flashdata('login_error')) { ?>
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?= $this->session->flashdata('login_error') ?>
            </div>
        <?php } ?>

<!--        <pre>
        <?= print_r($app) ?>
</pre>-->
        <style>
            .fixed-alert{
                position: fixed;
                z-index: 9999;
                width: 300px;
                bottom: 10px;
                right: 10px;
            }
        </style>
        <div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;" >
            <strong>Alert !</strong>
            <p id="alert-error-html"></p>
        </div>

        <div class="register-box">
            <div class="register-logo">
                <p>Register</p> 
                <p><a href="<?php echo base_url() ?>auth/register"><b><?= $app['application_name'] ?></b></a></p>
            </div>

            <div class="register-box-body">
                <p class="login-box-msg">Register a new membership</p>

                <form id="form-1" action="#" method="post">
                    <div class="form-group has-feedback">
                        <label for="fullname">Full name</label>
                        <input name="fullname" id="fullname" type="text" autocomplete="off"  class="form-control" placeholder="Full name">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="email">Email</label>
                        <input name="email"  type="email" id="email" autocomplete="off"  class="form-control" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="username">Username</label>
                        <input name="username" id="username" type="text" autocomplete="off"  class="form-control" placeholder="Username">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="password">Password</label>
                        <input  name="password" id="password"  type="password" autocomplete="off"  class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="password">Retype Password</label>
                        <input id="password"  name="password2" type="password"   autocomplete="off"  class="form-control" placeholder="Retype password">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="col-xs-2">
                                <label class="container-cb">
                                    <input id="term" type="checkbox">  
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-10">
                                <label for="term">I agree to the <a href="#" >term</a></label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" id="register" class="btn btn-primary btn-block btn-flat">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--                <div class="social-auth-links text-center">
                                    <p>- OR -</p>
                                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                                        Facebook</a>
                                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
                                        Google+</a>
                                </div>-->

                <a href="<?=base_url().'auth/login'?>" class="text-center">I already have a membership</a>
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
        <script>
            $(function () {
//                $('input').iCheck({
//                    checkboxClass: 'icheckbox_square-blue',
//                    radioClass: 'iradio_square-blue',
//                    increaseArea: '20%' // optional
//                });
            });
        </script>

        <script>
            $(document).ready(function () {
                $('#alert-error').click(function () {
                    $(this).hide();
                });


                $('#form-1').submit(function (e) {
                    e.preventDefault();

                    $('#register').prop('disabled', true);

                    $.ajax({
                        url: '<?= base_url() . 'auth/register_submit/' . 'submit' ?>', // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (data)   // A function to be called if request succeeds
                        {
                            if (!data.status) {
                                $('#alert-error').show();
                                $('#alert-error-html').html(data.message);
                                setTimeout(function () {
                                    $('#alert-error').fadeOut('slow');
                                }, 5000);
                            } else {
//                                 console.log(data);
                                window.location = '<?=base_url()?>auth/register_succes?email='+ encodeURI( data.data.email );
                            }
                            $('#register').prop('disabled', false);

                        },
                        error: function (err) {
                            alert('Kesalahan Terjadi Coba cek koneksi');
                            console.log(JSON.stringify(err));
                            $('#register').prop('disabled', false);
                        }
                    });

                });



            });


        </script>

    </body>
</html>
