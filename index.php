<!DOCTYPE html>
<html lang="en">

<!-- Maqueta general de HTML -->

<head>
<!-- Meta data de las cabecera del esquema HTML -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Se inserta el mimificado de jquery para uso de bootstrap -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <!-- Compilacion de Css de bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Es el tema de estilos css mimificados para bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- CDN de JavaScript como dependencia de BootStrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <title>Taller 1 OOlaya</title>
</head>


<!-- Cuerpo de la maqueta de HTML -->
<body>

  <?php
  //======================================================================
  // PROCESAR FORMULARIO 
  //======================================================================
  // Comprobamos si nos llega los datos por POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //-----------------------------------------------------
    // Funciones Para Validar
    //-----------------------------------------------------

    /**
     * Método que valida si un texto no esta vacío
     * @param {string} - Texto a validar
     * @return {boolean}
     */
    function validar_requerido($texto = ''): bool
    {
      return !(trim($texto) == '');
    }

    /**
     * Método que valida si es un número entero 
     * @param {string} - Número a validar
     * @return {bool}
     */
    function validar_entero($numero = ''): bool
    {
      return filter_var($numero, FILTER_VALIDATE_INT);
    }

    /**
     * Método que valida si el texto tiene un formato válido de E-Mail
     * @param {string} - Email
     * @return {bool}
     */
    function validar_email($texto = ''): bool
    {
      return filter_var($texto, FILTER_VALIDATE_EMAIL);
    }

    //-----------------------------------------------------
    // Variables
    //-----------------------------------------------------
    $errores = [];
    $usuairos = [];
    /**El metodo isset determina si una variable está definida y es nula */
    $nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : null;
    $edad = isset($_REQUEST['edad']) ? $_REQUEST['edad'] : null;
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;

    //-----------------------------------------------------
    // Validaciones
    //-----------------------------------------------------
    // Nombre
    if (!validar_requerido($nombre)) {
      $errores[] = 'El campo Nombre es obligatorio.';
    }
    // Edad
    if (!validar_entero($edad)) {
      $errores[] = 'El campo de Edad debe ser un número.';
    }
    // Email
    if (!validar_email($email)) {
      $errores[] = 'El campo de Email tiene un formato no válido.';
    }

    // Validamos si todo esta okay entonces acumulamos en el array
    if (validar_email($email) && validar_entero($edad) && validar_requerido($nombre)) {
      $tem = [];
      $tem[] = ['nombre' => $nombre, 'edad' => $edad, 'email' => $email];
      /**Inserta uno o más elementos al final de un array */
      array_push($usuairos, $tem);
    }
  }
  ?>

  <!-- Haciendo uso de etiquetas de bootstrap conformamos un contenedor para adicionar padding  -->
  <div class="container-fluid">
    <h1>Agregar usuarios.</h1>
    <!-- Construimos un tag foms el cual tiene un metodo post  -->
    <form method="post">
      <!-- Definimos los campos que sean necesarios para nuestro formulario, no olvidando poner la propiedad name en el tag para poder obtener el valor -->
      <div class="form-group">
        <label for="exampleInputEmail1">Nombre y Apellido</label>
        <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="emailHelp" placeholder="Ingrese Nombres y Apellidos ">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email: </label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Edad: </label>
        <input type="number" name="edad" class="form-control" id="edad" placeholder="Edad">
      </div>
      <!-- Declaramos el boton de enviar formulario -->
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>


  <!-- Hacemos uso de la estructura de bucle foreach para recorrer los errores de validación de los campos  -->
  <div class="container-fluid">
    <!-- Mostramos errores por HTML -->
    <?php if (isset($errores)) : ?>
      <ul class="list-group">
        <!-- agregamos un tag li para ir mostrando segun el recorrido el error que se genero  -->
        <?php
        foreach ($errores as $error) {
          echo '<li class="list-group-item"><div class="alert alert-danger" role="alert">'
            . $error .
            '</div></li>';
        }
        ?>
      </ul>
    <?php endif; ?>
  </div>


  <!-- Nuevamente hacemos uso de la clase container para separar y formatear el resultado ingresado en el formulario  -->
  <!-- La función json_encode Retorna la representación JSON del valor dado -->
  <!-- la palabra reservada echo — Muestra una o más cadenas -->
  <div class="container-fluid">
    <!-- Mostramos errores por HTML -->
    <?php if (isset($usuairos)) : ?>
    <h3>Usuarios agregados</h3>
      <ul class="list-group">
        <?php
        foreach ($usuairos as $user) {
          echo '<li class="list-group-item"><div class="alert alert-primary" role="alert">'
            . json_encode($user) .
            '</div></li>';
        }
        ?>
      </ul>
    <?php endif; ?>
  </div>
  <div class="panel-footer text-center">
   <div>
   Oscar Alexnader Olaya
   <br>
   Computación en el Servidor Web (ISW) - PER1822 2021-2022
   </div>
</div>
</body>

</html>