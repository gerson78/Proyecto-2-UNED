<?php  session_start() ; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Saikou Games</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/logo-peq_pixel.png">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
<?php

//requerimos el archivo conexion
require_once 'class/database.php';
//instanciamos la clase conexion
$_conexion = new conexion;
//creamos la consulta SELECT
 $query= "SELECT * FROM catalogo order by precio desc";
//enviamos la consulta para ser ejecutada
 $datosRecibidos = $_conexion->obtenerDatos($query);
//imprimimos el resultado
$id_sesionWeb = session_id();
// print_r($datosRecibidos);
?> 
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Type your keyword...">
                            <button type="submit"><img src="img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="index.php"><img src="img/core-img/logo-mediano_pixel.png" alt=""></a>
            </div>
            <!-- Navbar Toggler -->
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        <header class="header-area clearfix">
            <!-- Close Icon -->
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <!-- Logo -->
            <div class="logo">
            <a href="index.php"><img src="img/core-img/logo-mediano_pixel.png" alt=""></a>
            </div>
             <!-- MENU  -->
             <?php include('menu.php');?>
            <!-- Button Group -->
            <div class="amado-btn-group mt-30 mb-100">
                <?php 
                    $queryArticulos= "SELECT sum(cantidad) as total_articulos
                    FROM `carrito` C where C.sesion_web = '$id_sesionWeb';";

                    $ArticulosCarrito = $_conexion->obtenerDatos($queryArticulos);

                    foreach ($ArticulosCarrito as $row)
                            {
                                $total_articulos = $row["total_articulos"];
                            }
                ?>
                <a href="carrito.php?descartar=0" class="btn amado-btn mb-15"><img src="img/core-img/cart.png" alt="Mi Carrito"> Carrito <span>(<?php echo $total_articulos; ?>)</span></a>

                <a href="carrito.php?descartar=0" class="btn amado-btn active"><img src="img/core-img/cart.png" alt="Carrito"> Carrito <span>(<?php echo $total_articulos; ?>)</span></a>
            </div>  

            <!-- Social Button -->
            <div class="social-info d-flex justify-content-between">
                <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </div>
        </header>
        <!-- Header Area End -->

        <!-- Product Catagories Area Start -->
        <div class="products-catagories-area clearfix">
            <div class="amado-pro-catagory clearfix">

                <?php 
                foreach ($datosRecibidos as $row)
                    {
                
                    // echo $row["codigo"]." ".$row["descripcion"].PHP_EOL;
                    $codigo = $row["codigo"];
                    $descripcion = $row["descripcion"];
                    $precio = $row["precio"];
                    $ced_proveedor = $row["ced_proveedor"];
                    $imagen = $row["imagen"];

                    ?>
                        <!-- Single Catagory -->
                    <div class="single-products-catagory clearfix">
                        <a href="descripcion.php?item=<?php echo $codigo; ?>">
                            <img src="img/bg-img/<?php echo $imagen; ?>" alt="">
                            <!-- Hover Content -->
                            <div class="hover-content">
                                <div class="line"></div>
                                <p>From $<?php echo $precio; ?></p>
                                <h4><?php echo $descripcion; ?></h4>
                            </div>
                        </a>
                    </div>
                    <?php
                    }
                ?>            
            </div>
        </div>
        <!-- Product Catagories Area End -->
    </div>
    <!-- ##### Main Content Wrapper End ##### -->



    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row align-items-center">
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-4">
                    <div class="single_widget_area">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="index.php"><img src="img/core-img/logo-mediano_pixel.png" alt=""></a>
                        </div>
                        <!-- Copywrite Text -->
                        <p class="copywrite"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> Gerson Guillen Solano <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://www.uned.ac.cr/centros/desamparados" target="_blank">UNED</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->/ Proyecto #2 <a href="https://www.uned.ac.cr/centros/desamparados" target="_blank">Administración de Sitios Web</a>
                        </p>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-8">
                    <div class="single_widget_area">
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <nav class="navbar navbar-expand-lg justify-content-end">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                                <div class="collapse navbar-collapse" id="footerNavContent">
                                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item active">
                                            <a class="nav-link" href="index.php">Catalogo</a>
                                        </li>
                                     
                                        <li class="nav-item">
                                            <a class="nav-link" href="carrito.php"> <img src="img/core-img/cart.png" alt="Mi Carrito">  (<?php echo $total_articulos; ?>)</a>
                                        </li>
                                 
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>