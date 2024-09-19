<!DOCTYPE html>
<html>

<head>
    <title>SISTEMA VENTAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <!-- Logo -->
                    <div class="logo">
                        <h1><a href="index.html">SISTEMA VENTAS</a></h1>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Search</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="navbar navbar-inverse" role="banner">
                        <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b
                                            class="caret"></b></a>
                                    <ul class="dropdown-menu animated fadeInUp">
                                        <li><a href="profile.html">Profile</a></li>
                                        <li><a href="login.html">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-md-2">
                <!--Inicio de Menu-->
                <div class="sidebar content-box" style="display: block;">
                    <ul class="nav">
                        <!-- Main menu -->
                        <li class="current"><a href="./"><i class="glyphicon glyphicon-home"></i> INICIO</a></li>

                        <!-- <li><a href="calendar.html"><i class="glyphicon glyphicon-calendar"></i> Calendar</a></li> -->
                        <!-- <li><a href="stats.html"><i class="glyphicon glyphicon-stats"></i> Statistics (Charts)</a></li>
                    <li><a href="tables.html"><i class="glyphicon glyphicon-list"></i> Tables</a></li>
                    <li><a href="buttons.html"><i class="glyphicon glyphicon-record"></i> Buttons</a></li>
                    <li><a href="editors.html"><i class="glyphicon glyphicon-pencil"></i> Editors</a></li>-->

                        <!-- VENTAS -->
                        <li class="submenu">
                            <a href="#">
                                <i class="glyphicon glyphicon-list"></i> Producto
                                <span class="caret pull-right"></span>
                            </a>
                            <!-- Sub menu -->
                            <ul>
                                <li><a href="./?c=Producto&m=nuevo">Nuevo Producto</a></li>
                                <li><a href="./?c=Producto&m=listar">Listar Productos</a></li>
                            </ul>
                        </li>
                        <!-- compras -->
                        <li class="submenu">
                            <a href="#">
                                <i class="glyphicon glyphicon-shopping-cart"></i> Compras
                                <span class="caret pull-right"></span>
                            </a>
                            <!-- Sub menu -->
                            <ul>
                                <li><a href="./?c=Compra&m=nuevo">Nuevo Compra</a></li>
                                <li><a href="./?c=Compra&m=listar">Listar Compra</a></li>
                            </ul>
                        </li>


                        <!-- usuarios -->
                        <li class="submenu">
                            <a href="#">
                                <i class="glyphicon glyphicon-user"></i> Usuarios
                                <span class="caret pull-right"></span>
                            </a>
                            <!-- Sub menu -->
                            <ul>
                                <li><a href="./?c=Usuario&m=nuevo">Nuevo usuarios</a></li>
                                <li><a href="./?c=Usuario&m=listar">Listar usuarios</a></li>
                            </ul>
                        </li>

                        <!-- reportes -->
                        <li class="submenu">
                            <a href="#">
                                <i class="glyphicon glyphicon-file"></i> Reportes
                                <span class="caret pull-right"></span>
                            </a>
                            <!-- Sub menu -->
                            <ul>
                                <li><a href="./?c=Reporte&m=prueba">Reporte de prueba</a></li>
                                <li><a href="./?c=Reporte&m=producto">Reporte Productos</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>

            </div>
            <!--Fin de Menu-->
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="content-box-header">
              <div class="panel-title">Producto</div>
            </div> -->
                        <div class="content-box-large box-with-header">
                            <!--Inicio del Contenido-->

                            <?php
              require_once $vista;
              ?>

                        </div>
                        <!--Fin de Contenido-->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="copy text-center">
                Copyright 2014 <a href="#">Website</a>
            </div>
        </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>