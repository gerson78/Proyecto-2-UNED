<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>PixelBazaar</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/logo-peq_pixel.png">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <?php
    session_start() ;
    //requerimos el archivo conexion
    require_once 'class/database.php';
    //instanciamos la clase conexion
    $_conexion = new conexion;
    //creamos la consulta SELECT
    $item = $_GET["item"];

    $id_sesionWeb = session_id();

    $query= "SELECT * FROM catalogo where codigo = $item";
    //enviamos la consulta para ser ejecutada
    $datosRecibidos = $_conexion->obtenerDatos($query);
    //imprimimos el resultado
    // print_r($datosRecibidos);
    // 
    $queryStock= "SELECT `cod_tienda`, `cod_producto`, `cantidad`, `fecha_registro` FROM `inventario` WHERE cod_producto = '$item';";
    //enviamos la consulta para ser ejecutada
    $datosStock = $_conexion->obtenerDatos($queryStock);

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
                <a href="index.php"><img src="img/core-img/logo-peq.png" alt=""></a>
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
                <a href="carrito.php" class="btn amado-btn mb-15"><img src="img/core-img/cart.png" alt=""> Carrito <span>(<?php echo $total_articulos; ?>)</span></a>

                <a href="index.php" class="btn amado-btn active">SALE</a>
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

        <!-- Product Details Area Start -->
        <div class="single-product-area section-padding-100 clearfix">
            <div class="container-fluid">

        <?php 
            foreach ($datosRecibidos as $row)
            {
            
                // echo $row["codigo"]." ".$row["descripcion"].PHP_EOL;
                $codigo = $row["codigo"];
                $descripcion = $row["descripcion"];
                $precio = $row["precio"];
                $ced_proveedor = $row["ced_proveedor"];
                $imagen = $row["imagen"];
                $imagen2 = $row["imagen2"];
                $imagen3 = $row["imagen3"];
                $resumen = $row["resumen"];
                $estrellas = $row["estrellas"];
        ?>
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="index.php">Furniture</a></li>
                                <li class="breadcrumb-item"><a href="#"><?php echo $descripcion; ?></a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(img/product-img/<?php echo $imagen; ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="1" style="background-image: url(img/product-img/<?php echo $imagen2; ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="2" style="background-image: url(img/product-img/<?php echo $imagen3; ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="3" style="background-image: url(img/product-img/<?php echo $imagen; ?>);">
                                    </li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="img/product-img/<?php echo $imagen; ?>">
                                            <img class="d-block w-100" src="img/product-img/<?php echo $imagen; ?>" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/<?php echo $imagen2; ?>">
                                            <img class="d-block w-100" src="img/product-img/<?php echo $imagen2; ?>"  alt="Second slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/<?php echo $imagen3; ?>">
                                            <img class="d-block w-100" src="img/product-img/<?php echo $imagen3; ?>" alt="Third slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/<?php echo $imagen; ?>">
                                            <img class="d-block w-100" src="img/product-img/<?php echo $imagen; ?>" alt="Fourth slide">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                            <?php 
                                foreach ($datosStock as $row)
                                {
                                
                                    $stock = $row["cantidad"];
                                }
                            ?>
                        <div class="single_product_desc">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <p class="product-price">$<?php echo $precio; ?></p>
                                <a href="product-details.html">
                                    <h6><?php echo $descripcion; ?></h6>
                                </a>
                                <!-- Ratings & Review -->
                                <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                    <div class="ratings">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                          
                                </div>
                                <!-- Avaiable -->

                                <p class="avaibility"><i class="fa fa-circle"></i> In Stock <?php echo $stock; ?></p>
                            </div>

                            <div class="short_overview my-5">
                                <p><?php echo $resumen; ?></p>
                            </div>

                            <!-- Add to Cart Form -->
                            <form class="cart clearfix" method="post" action="carrito.php">
                                <div class="cart-btn d-flex mb-50">
                                    <p>Cant</p>
                                    <div class="quantity">
                                    
                                        <INPUT TYPE="label" hidden NAME="id_sesionWeb" value="<?php echo $id_sesionWeb; ?>">
                                        <INPUT TYPE="label" hidden NAME="codigo" value="<?php echo $codigo; ?>">
                                        <INPUT TYPE="label" hidden NAME="descripcion" value="<?php echo $descripcion; ?>">
                                       
                                        <INPUT TYPE="label" hidden NAME="descartar" value="0">

                                       <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="<?php echo $stock; ?>" name="quantity" value="1">
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span> 
                                   </div>
                                </div>
                                <button type="submit" name="addtocart" value="5" class="btn amado-btn">Comprar</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Details Area End -->
        <?php
            }
        ?>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Newsletter Area Start ##### -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <!-- Newsletter Text -->
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe for a <span>25% Discount</span></h2>
                        <p>Nulla ac convallis lorem, eget euismod nisl. Donec in libero sit amet mi vulputate consectetur. Donec auctor interdum purus, ac finibus massa bibendum nec.</p>
                    </div>
                </div>
                <!-- Newsletter Form -->
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="newsletter-form mb-100">
                        <form action="#" method="post">
                            <input type="email" name="email" class="nl-email" placeholder="Your E-mail">
                            <input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Newsletter Area End ##### -->

     <!-- ##### Footer Area Start ##### -->
     <footer class="footer_area clearfix">
        <div class="container">
            <div class="row align-items-center">
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-4">
                    <div class="single_widget_area">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="index.php"><img src="img/core-img/logo-peq.png" alt=""></a>
                        </div>
                        <!-- Copywrite Text -->
                        <p class="copywrite"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> Gerson Guillen Solano <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://www.uned.ac.cr/centros/desamparados" target="_blank">UNED</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->/ Proyecto #1 <a href="https://www.uned.ac.cr/centros/desamparados" target="_blank">Administración de Sitios Web</a>
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