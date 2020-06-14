<?php

$mysqli = mysqli_connect ("localhost","root","","imc");

if ($mysqli == false) { //verificamos que estamos conectados a la BBDD y sino no cargara la web
  echo "Hubo un problema al conectarse a Maria DB";

  die ();//esto matara el proceso
}

//Consulta para traer los promedios peso maximo y la cuenta

$consulta = "SELECT AVG(`datos_imc`) AS 'imc_promedio', AVG(`datos_peso`) AS 'peso_promedio', 
AVG(`datos_altura`) AS 'altura_promedio',  MAX(`datos_peso`) AS 'peso_maximo',
COUNT(*) AS 'cantidad'FROM `datos` WHERE 1";

$resultado = $mysqli->query($consulta);
$fila = $resultado->fetch_assoc();//que los resultados los convierta en un arry asociativo


$imc_promedio =  $fila ['imc_promedio'];
$peso_promedio = $fila ['peso_promedio'];
$altura_promedio = $fila ['altura_promedio'];
$peso_maximo = $fila ['peso_maximo'];
$cantidad = $fila ['cantidad'];

$imc_promedio = round($imc_promedio,2);
$peso_promedio = round($peso_promedio,2);
$altura_promedio = round($altura_promedio,2);


//Metiendo todas las filas dentro de una array 
$resultado = $mysqli->query("SELECT * FROM `datos` WHERE 1");
$tabla = $resultado->fetch_all(MYSQLI_ASSOC);



if (isset($_POST['peso']) && isset($_POST['altura']) && is_numeric($_POST['peso']) && is_numeric($_POST['altura']) ){

$peso = $_POST['peso'];
$altura = $_POST['altura'];

$imc = $peso / ($altura*$altura);

$imc = round($imc,1);//para redondear los decimales poner candidad que quieres que se vean


$resultado = "";
$color ="";

if ($imc<18.5){

    $resultado = "Peso inferior al normal";
    $color = "#5ac9f4";
    $imagen_normal = "imagenes/normal_inferior.svg";
  }
  
  if ($imc >=18.5 && $imc < 24.9) {
    $resultado = "Normal";
    $color = "#9eb33a";
    $imagen_normal = "imagenes/normal.svg";
    
  }
  
  if ($imc >= 25 && $imc < 29.9)  {
    $resultado = "Peso superior al normal";
    $color = "#fac90d";
    $imagen_normal = "imagenes/normal_mas.svg";
  }
  
  if ($imc >=30  && $imc <34.9) {
    
    $resultado = "Obesidad";
    $color = "#ec1f26";  
    $imagen_normal = "imagenes/normal_superior.svg";
    
  }
  
  if ($imc >30) {
    $resultado = "Extremadamente Obeso";
    $color = "#f38a2f";
    $imagen_normal = "imagenes/normal_obeso.svg";
}



$mysqli->query("INSERT INTO `datos` (`datos_altura`, `datos_peso`, `datos_imc`) VALUES ('".$altura."', '".$peso."', '".$imc."');");

}

?>



<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Mi Calculadora IMC</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/scrolling-nav.css" rel="stylesheet" />
  </head>

  <body id="page-top">
    <!-- Navigation -->
    <nav
      class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"
      id="mainNav"
    >
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"
          >Calculadora IMC
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarResponsive"
          aria-controls="navbarResponsive"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">Calculadora</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Estadísticas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contacto</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="bg-primary text-white">
      <div class="container text-center">
        <h1>Binvendios a mi Calculadora IMC</h1>
        <p class="lead">
          No es belleza es Salud!
        </p>
      </div>
    </header>

    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="card mb-4">
              <img class="card-img-top" src="imagenes/salud.jpg" alt="Card image cap">
              <div class="card-body">
                <h2 class="card-title">Calcula tu IMC</h2>
                <p class="card-text">No es belleza es Salud!</p>
                <div class = "row">

                  <div class="col-lg-6">

                    <form class="" action="index.php#about" method="POST">
                      Peso (kg) <br><input type="number" step=".01" name="peso" value="" placeholder="Tu peso en kg" require><br><br>
                      Altura (m) <br><input type="number" step=".01" name="altura" value="" placeholder="Tu altura en metros" require><br><br>
                      <input class="btn btn-primary" type="submit" name="" value="Calcular">
                    </form>


                  </div>

                  <div class = "col-lg-6">
                        
                  
                       <?php if (isset($imc)) {?>
                       <?php echo "Tu IMC es de ".$imc; ?>
                            <br>
                        <div style="color:<?php echo $color; ?>"> Resultado: <?php echo $resultado;  ?><br> 
                        <img src="<?php echo $imagen_normal; ?>" alt=""style="width: 120px; padding-top: 15px;"> </div>
                        <?php } ?>

                  </div>
                </div>
                    
              </div>
              <div class="card-footer text-muted">
                Consulta  más información en 
                <a href="#">Clínica Salud</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="services" class="bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Estadísticas</h2>
            <div style="color:grey;margin-top:15px;">
              <span>IMC PROMEDIO: <?php echo $imc_promedio; ?></span><br>
              <span>Peso Promedio: <?php echo $peso_promedio; ?></span><br>
              <span>Altura Promedio: <?php echo $altura_promedio; ?> </span><br>
              <span>Peso máximo: <?php echo $peso_maximo; ?></span><br>
              <span>Cantidad personas: <?php echo $cantidad;?></span><br>  
            </div>        
          </div>
        </div>
      </div>
    </section>


    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Datos</h2>
            
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#Id</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Altura</th>
                  <th scope="col">Peso</th>
                  <th scope="col">IMC</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($tabla as $fila){ ?>
                <tr>
                  <th scope="row"><?php echo $fila['datos_id']?></th>
                  <td><?php echo $fila['datos_fecha']?></td>
                  <td><?php echo $fila['datos_altura']?></td>
                  <td><?php echo $fila['datos_peso']?></td>
                  <?php if($fila['datos_imc']>25){ ?> <!-- Codigo para poner en rojo mayores de 25 -->
                  <td style="color:red;"><?php echo $fila['datos_imc'];?></td>
                  <?php } else{?>
                  <td><?php echo $fila['datos_imc']; ?> </td>
                  <?php }?>
                </tr>
                <?php }?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">
          Copyright &copy; Your Website 2019
        </p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom JavaScript for this theme -->
    <script src="js/scrolling-nav.js"></script>
  </body>
</html>
