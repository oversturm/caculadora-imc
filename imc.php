<?php

if (isset($_POST['peso']) && isset($_POST['altura']) && is_numeric($_POST['peso']) && is_numeric($_POST['altura']) ){

$peso = $_POST['peso'];
$altura = $_POST['altura'];

$imc = $peso / ($altura*$altura);

$imc = round($imc,1);//para redondear los decimales poner candidad que quieres que se vean

$resultado = "";
$color ="";

if ($imc<18.5){

    $resultado = "Peso inferior al normal";
    $color = "orange";
}

if ($imc >=18.5 && $imc < 24.9) {
    $resultado = "Normal";
    $color = "green";
}

if ($imc >= 24.9 && $imc < 29.9)  {
    $resultado = "Peso superior al normal";
    $color = "yellow";
}

if ($imc >30) {
    $resultado = "Obesidad";
    $color = "orange";
}


}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calculadora IMC</title>
</head>
<body>
    <h2>Calcula tu IMC</h2>
    <h3>No es belleza, es salud!</h3>
    <br><br>
    <form class="" action="imc.php" method="POST">
        Peso (kg) <br><input type="number" step=".01" name="peso" value="" placeholder="Tu peso en kg" require><br><br>
        Altura (m) <br><input type="number" step=".01" name="altura" value="" placeholder="Tu altura en metros" require><br><br>
        <input type="submit" name="" value="Calcular">
    </form>
    <br>
       

     <?php if (isset($imc)) {?>
        <?php echo "Tu IMC es de ".$imc; ?>
            <br>
        <div style="color:<?php echo $color; ?>"> Resultado: <?php echo $resultado;  ?></div>
    <?php } ?>

</body>
</html>
<!DOCTYPE html>