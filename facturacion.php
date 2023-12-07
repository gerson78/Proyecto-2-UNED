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

    $id_sesionWeb = session_id();

    //echo $_POST['cedula'];
    $crear_cuenta = isset($_POST['nueva_cuenta']);

    if ($crear_cuenta == 1){

        $ced_cliente = $_POST['cedula'];
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $nueva_cuenta = isset($_POST['nueva_cuenta']);
        $factura = isset($_POST['factura']);

                                // SELECT `cedula`, `correo`, `nombre`, `apellidos`, `telefono`, `direccion`, `factura_e`, `fecha_registro` FROM `clientes` WHERE 1

        $queryCliente= "SELECT count(*) as 'existe' FROM `clientes` where cedula = '$ced_cliente' and correo = '$correo'";
        $ConsultaCliente= $_conexion->obtenerDatos($queryCliente);
        foreach ($ConsultaCliente as $row)
            {
            $existe = $row["existe"];
            }
                            
        if ($existe == 1){
            $query_update = "UPDATE `clientes` SET `nombre` = '$nombre ', `apellidos` = '$apellidos ', `telefono` = '$telefono ', `direccion` = '$direccion ', `factura_e` = '$factura '
                            WHERE `correo` = '$correo' AND `cedula` = '$ced_cliente', sesion_web  '$id_sesionWeb'";
            $datosActualiza = $_conexion->nonQueryId($query_update);
        }else{
            // 
            $query_insert = "INSERT INTO `clientes`(`cedula`, `correo`, `nombre`, `apellidos`, `telefono`, `direccion`, `factura_e`, `fecha_registro`, sesion_web  ) 
                                  VALUES ('$ced_cliente','$correo','$nombre','$apellidos','$telefono','$direccion','$factura',now(),'$id_sesionWeb')";
            $datosInsertar = $_conexion->nonQueryId($query_insert);
                    
                                    //print_r($datosInsertar);
            }

    }
    
    $queryClienteRegistrado= "SELECT count(*) as 'existe' FROM `clientes` where sesion_web = '$id_sesionWeb'";
    $ConsultaClienteRegistrado= $_conexion->obtenerDatos($queryClienteRegistrado);
    foreach ($ConsultaClienteRegistrado as $row)
        {
       $registrado = $row["existe"];
        }
    
        
    if ($registrado <> 0){
    
    $queryDatosClienteNuevo= "SELECT `cedula`, `correo`, `nombre`, `apellidos`, `telefono`, `direccion`, `factura_e`, `fecha_registro` FROM `clientes`
                                 where sesion_web = '$id_sesionWeb'";
    $ConsultaDatosClienteNuevo= $_conexion->obtenerDatos($queryDatosClienteNuevo);
    foreach ($ConsultaDatosClienteNuevo as $row)
        {
        $nueva_cedula = $row["cedula"];
        $nueva_correo = $row["correo"];
        $nueva_nombre = $row["nombre"];
        $nueva_apellidos = $row["apellidos"];
        $nueva_telefono = $row["telefono"];
        $nueva_direccion = $row["direccion"];
        $nueva_factura_e = $row["factura_e"];
        }

    }

    $queryTotal= "SELECT sum(Cat.precio * C.cantidad ) as total
                            FROM `carrito` C 
                            inner join catalogo Cat ON Cat.codigo = C.cod_producto
                            where C.sesion_web = '$id_sesionWeb';";

    $sumatoriaCarrito = $_conexion->obtenerDatos($queryTotal);

            foreach ($sumatoriaCarrito as $row)
            {
                $total = $row["total"];
            }
        


    $pago_confirmado = isset($_POST['pagar']);
     

    if ($pago_confirmado == 1){

        $query_insert_fact = "INSERT INTO `facturas`(`cod_tienda`, `num_factura`, `ced_cliente`, `monto`, sesion_web) VALUES ('111111',0,'$nueva_cedula','$total','$id_sesionWeb')";
        $datosInsertarFactura = $_conexion->nonQueryId($query_insert_fact);

              
        $query_actualiza_inventario = "call `REBAJAR_INVENTARIO`('$id_sesionWeb','$nueva_cedula','111111')";
        $datosActualizaInventario = $_conexion->nonQueryId($query_actualiza_inventario);

    }
        
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
                <a href="carrito.php?descartar=0" class="btn amado-btn mb-15"><img src="img/core-img/cart.png" alt="Mi Carrito"> Carrito <span>(<?php echo $total_articulos; ?>)</span></a>

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

        
        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">                
                <form action="facturacion.php" method="post">                    
                            <div class="cart-summary">
                                <div class="col-10 col-lg-12">                            
                                    <h5>Dato de la tarjeta</h5>
                                    <br>
                                    <span><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span> 
                                    <div>
                                        <input type="text" id="#tarjeta" name="#tarjeta" class="form-control" min="0" placeholder="####-####-####-####" value="" required/>                                        
                                    </div>
                                    <span><i class="fa fa-user" aria-hidden="true"></i></span> 
                                    <div>
                                        <input type="text" id="#nombre" name="#nombre" class="form-control" min="0" placeholder="Nombre tarjeta" value="<?PHP echo strtoupper($nueva_nombre)." ".strtoupper($nueva_apellidos); ?>" required/>                                        
                                    </div>
                                    <span><i class="fa fa-calendar" aria-hidden="true"></i></span> 
                                    <div>
                                        <input type="date" id="#fecha" name="#fecha" class="form-control" value="" required/>                                        
                                    </div>
                                    <span><i class="fa fa-code" aria-hidden="true"></i></span> 
                                    <div>
                                        <input type="number" id="#cvv" name="#cvv" class="form-control" min="001"  placeholder="CVV"  value="" required/>                                        
                                    </div>
                                    <br>
                                </div>
                                <div class="col-10 col-lg-12">
                                    <h5>Total de la compra</h5>
                                
                                    <ul class="summary-table">
                                        <li><span>subtotal:</span> <span>$<?php echo $total; ?></span></li>
                                        <li><span>delivery:</span> <span>Free</span></li>
                                        <li><span>total:</span> <span>$<?php echo $total; ?></span></li>
                                    </ul>
                                       
                                    <?php                             

                                    if ($registrado <> 0){
                                        ?>
                                        
                                        <div class="col-12 mb-3">                                        
                                            <input type="submit" value="pagar" name="pagar" class="btn amado-btn w-100">
                                        </div>
                                        <?php
                                        }else{
                                        ?>
                                        <div class="cart-btn mt-100">
                                            <input type="submit" value="pagar" name="pagar" class="btn disabled amado-btn w-100">
                                        </div>
                                        <?php
                                        }                            
                                        ?>                       
                               
                                </div>                           
                            </div>                  
                </form>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Newsletter Area Start ##### -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <!-- Newsletter Text -->
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Suscríbase a nuestra <span>Revista mensual</span></h2>
                        <p>Reciba mensualmente un avance de nuestros proximos productos</p>
                    </div>
                </div>
                <!-- Newsletter Form -->
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="newsletter-form mb-100">
                        <form action="#" method="post">
                            <input type="email" name="email" class="nl-email" placeholder="Su correo aquí..">
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