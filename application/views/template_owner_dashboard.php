<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?=base_url()?>AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=base_url()?>AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?=base_url()?>AdminLTE-2.4.2/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=base_url()?>AdminLTE-2.4.2/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?=base_url()?>AdminLTE-2.4.2/dist/css/skins/_all-skins.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    <body class="hold-transition skin-blue layout-top-nav">
        <div class="wrapper">

            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="<?=base_url()?>AdminLTE-2.4.2/index2.html" class="navbar-brand"><b>Admin</b>LTE</a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                                <li><a href="#">Link</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                                </div>
                            </form>
                        </div>
                        <!-- /.navbar-collapse -->
                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">

                                <li class="dropdown user user-menu">
                                    <!-- Menu Toggle Button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <!-- The user image in the navbar-->
                                        <img src="<?=base_url()?>AdminLTE-2.4.2/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                        <span class="hidden-xs">Alexander Pierce</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- The user image in the menu -->
                                        <li class="user-header">
                                            <img src="<?=base_url()?>AdminLTE-2.4.2/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                            <p>
                                                Alexander Pierce - Web Developer
                                                <small>Member since Nov. 2012</small>
                                            </p>
                                        </li>
                                        <!-- Menu Body -->
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-custom-menu -->
                    </div>
                    <!-- /.container-fluid -->
                </nav>
            </header>
            <!-- Full Width Column -->
            <div class="content-wrapper">
                <div class="container">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1>
                            Top Navigation
                            <small>Example 2.0</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">Layout</a></li>
                            <li class="active">Top Navigation</li>
                        </ol>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <div class="callout callout-info">
                            <h4>Tip!</h4>

                            <p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used with a
                                sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and use regular
                                links instead.</p>
                        </div>
                        <div class="callout callout-danger">
                            <h4>Warning!</h4>

                            <p>The construction of this layout differs from the normal one. In other words, the HTML markup of the navbar
                                and the content will slightly differ than that of the normal layout.</p>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Blank Box</h3>
                            </div>
                            <div class="box-body">
                                The great content goes here
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="container">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 2.4.0
                    </div>
                    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
                    reserved.
                </div>
                <!-- /.container -->
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="<?=base_url()?>AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?=base_url()?>AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="<?=base_url()?>AdminLTE-2.4.2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?=base_url()?>AdminLTE-2.4.2/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url()?>AdminLTE-2.4.2/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?=base_url()?>AdminLTE-2.4.2/dist/js/demo.js"></script>
    </body>
</html>
