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
       ECHO $registrado = $row["existe"];
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
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="checkout_details_area mt-50 clearfix">

                            <div class="cart-title">
                               
                                <?php
                                    if ($registrado <> 0){
                                    ?>
                                     <h2><?php echo $nueva_nombre; ?> ya tienes una cuenta. </h2>
                                <?php
                                    }else{
                                    ?>
                                     <h2>Datos del cliente</h2>
                                <?php
                                    }                                    
                                    ?>
                            </div>                           
                           

                            <form class="cart clearfix" method="post" action="checkout.php">
                                <div class="row">
                                  
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula" value="" required>
                                    </div>
                                   
                                    <div class="col-md-6 mb-3">
                                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" value="" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="" placeholder="Apellidos" required>
                                    </div>
                                   
                                    
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="telefono" name="telefono" min="0" placeholder="# Telefono (506) " value="">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="custom-control custom-checkbox d-block mb-2">
                                            <input type="checkbox" class="custom-control-input" id="nueva_cuenta" name="nueva_cuenta" checked>
                                            <label class="custom-control-label" for="nueva_cuenta"><i class="fa fa-user-plus" aria-hidden="true"></i>  Crear un cuenta</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-block">
                                            <input type="checkbox" class="custom-control-input" id="factura" name="factura">
                                            <label class="custom-control-label" for="factura"> <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Deseo factura electronica</label>
                                        </div>
                                    </div>
                                  
                                                                    
                                    <div class="col-12 mb-3">
                                        <textarea class="form-control w-100" id="direccion" name="direccion" cols="30" rows="10" placeholder="Direccion de entrega"></textarea>
                                    </div>

                                    <div class="col-12 mb-3">                                        
                                        <input type="submit" value="Registrar cliente" class="btn amado-btn w-100">
                                    </div>

                                   
                                </div>
                            </form>
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
                                <form action="facturacion.php" method="post">
                                    <ul class="summary-table">
                                        <li><span>subtotal:</span> <span>$<?php echo $total; ?></span></li>
                                        <li><span>delivery:</span> <span>Free</span></li>
                                        <li><span>total:</span> <span>$<?php echo $total; ?></span></li>
                                    </ul>
                                        <fieldset class="summary-table">

                                            <div>
                                                <span><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span> 
                                                <input type="radio" id="tarjeta" name="pago" value="tarjeta" checked/>
                                                <label for="Visa">Tarjeta</label>
                                            </div>

                                            <div>
                                                <span><i class="fa fa-money" aria-hidden="true"></i></span>
                                                <input type="radio" id="efectivo" name="pago" value="efectivo" />
                                                <label for="Stripe">Efectivo</label>
                                            </div>
                                        </fieldset>
                                    <?php 
                            

                                    if ($registrado <> 0){
                                    ?>
                                    <ul class="summary-table">  
                                        <li><span>Cedula:</span> <span># <?php echo $nueva_cedula; ?></span></li>
                                        <li><span>Correo:</span> <span><?php echo $nueva_correo; ?></span></li>
                                        <li><span>Direccion de entrega:</span> <span><?php echo $nueva_direccion; ?></span></li>
                                    </ul>
                                    <div class="cart-btn mt-100">
                                        <input type="submit" value="Pagar" class="btn amado-btn w-100">
                                        
                                    </div>
                                    <?php
                                    }else{
                                    ?>
                                    <div class="cart-btn mt-100">
                                        <a href="checkout.php" class="btn disabled amado-btn w-100" ><i class="fa fa-credit-card" aria-hidden="true"></i> Pagar</a>
                                    </div>
                                    <?php
                                    }                            
                                    ?>
                                </form>
                               
                            </div>
                                <div class="cart-btn mt-100">
                                    <a href="index.php" class="btn amado-btn w-100"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>  Seguir comprando</a>
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