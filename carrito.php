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
    session_start() ;
    //requerimos el archivo conexion
    require_once 'class/database.php';
    //instanciamos la clase conexion
    $_conexion = new conexion;
    //creamos la consulta SELECT
    $id_sesionWeb = session_id();
    //$id_sesionWeb = $_POST["id_sesionWeb"];

       
         $descartar = isset($_GET['descartar']);

        if ($descartar == 1 and isset($_GET['codigo'])) {
            $codigo = $_GET['codigo'];
             $query_borrar = "DELETE FROM `carrito` WHERE sesion_web = '$id_sesionWeb' and cod_producto = '$codigo' ";
            $datosBorrar = $_conexion->nonQueryId($query_borrar);
        }
        
        if($descartar == 0 and isset($_POST['quantity']) and isset($_POST['codigo']) ) {
            // valida si el producto ya esta en el carrito y lo actualiza, sino lo inserta
            if (isset($_POST['quantity'])){
                $cantidad = $_POST['quantity'];
            }

            if (isset($_POST['codigo'])){
                $codigo = $_POST['codigo'];
            }
            
            $queryItem= "SELECT count(*) as 'existe' FROM `carrito` where sesion_web = '$id_sesionWeb' and cod_tienda = '111111' and cod_producto = '$codigo'";
            $ConsultaItem = $_conexion->obtenerDatos($queryItem);
            foreach ($ConsultaItem as $row)
            {
               $existe = $row["existe"];
            }
        
            if ($existe == 1){
                $query_update = "UPDATE `carrito` SET `cantidad` = '$cantidad ' WHERE `sesion_web` = '$id_sesionWeb' AND `cod_tienda` = '111111' AND `cod_producto` = '$codigo'";
                $datosActualiza = $_conexion->nonQueryId($query_update);
            }else{
                
               $query_insert = "INSERT INTO `carrito`(`sesion_web`, `cod_tienda`, `cod_producto`, `cantidad`, `fecha_compra`) VALUES ('$id_sesionWeb','111111','$codigo','$cantidad',NOW());";
                $datosInsertar = $_conexion->nonQueryId($query_insert);

                //print_r($datosInsertar);
            }

        }
        

     //print_r( $datosInsertar );
    
    //imprimimos el resultado
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
                <a href="index.php"><img src="img/core-img/logo-peq_pixel.png" alt=""></a>
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
                <a href="index.php"><img src="img/core-img/logo-peq_pixel.png" alt=""></a>
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

        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                <?php 
                $query= "SELECT C.cod_producto,Cat.precio, Cat.descripcion, Cat.imagen, C.cantidad FROM `carrito` C 
                inner join catalogo Cat ON Cat.codigo = C.cod_producto
                where C.sesion_web = '$id_sesionWeb'";

                $datosRecibidos = $_conexion->obtenerDatos($query);
                ?>

           
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="cart-title mt-50">
                            <h2>Carrito de compras</h2>
                        </div>

                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Descripción</th>
                                        <th>Precio unitario</th>
                                        <th>Cantidad</th>
                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($datosRecibidos as $row)
                                        {
                                    
                                                // echo $row["cod_producto"]." ".$row["descripcion"].PHP_EOL;
                                                $codigo = $row["cod_producto"];
                                                $cantidad = $row["cantidad"];
                                                $precio = $row["precio"];
                                                $descripcion = $row["descripcion"];
                                                $imagen = $row["imagen"];

                                            ?>
                                            <tr>
                                                <td class="cart_product_img">
                                                    <a href="descripcion.php?item=<?php echo $codigo; ?>"><img src="img/bg-img/<?php echo $imagen; ?>" alt="Product"></a>
                                                </td>
                                                <td class="cart_product_desc">
                                                    <h5><?php echo $descripcion; ?></h5>
                                                </td>
                                                <td class="price">
                                                    <span>$<?php echo $precio; ?></span>
                                                </td>
                                                <td class="qty">
                                                    <span class="qty-text" ><?php echo $cantidad; ?> </span>
                                                    <span class="qty-text" ><a href="carrito.php?descartar=1&codigo=<?php echo $codigo; ?>"><i class="fa fa-trash-o fa-lg"></i> Descartar</a></a></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="cart-summary">
                                <?php 
                                    $queryTotal= "SELECT sum(Cat.precio * C.cantidad ) as total
                                                        FROM `carrito` C 
                                                                    inner join catalogo Cat ON Cat.codigo = C.cod_producto
                                                                    where C.sesion_web = '$id_sesionWeb';";

                                    $sumatoriaCarrito = $_conexion->obtenerDatos($queryTotal);

                                    foreach ($sumatoriaCarrito as $row)
                                    {
                                        $total = $row["total"];
                                    }
                                ?>
                                <h5>Total de la compra</h5>
                                <ul class="summary-table">
                                    <li><span>subtotal:</span> <span>$<?php echo $total; ?></span></li>
                                    <li><span>delivery:</span> <span>Free</span></li>
                                    <li><span>total:</span> <span>$<?php echo $total; ?></span></li>
                                </ul>
                       

                                <div class="cart-btn mt-100">
                                    <a href="checkout.php" class="btn amado-btn w-100"><i class="fa fa-credit-card" aria-hidden="true"></i> Pagar</a>
                                </div>
                           
                 
                            <div class="cart-btn mt-100">
                                        <a href="index.php" class="btn amado-btn w-100"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>  Seguir comprando</a>
                            </div>
                        </div>                        
                    </div>                
                </div>
                    
            </div>
        </div>
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