<?php
  session_start();
  require 'database.php';

  if(isset($_SESSION['cedula_user'])){
    $records = $connection->prepare('SELECT cedula, email, password FROM users WHERE cedula = :cedula');
    $records->bindParam(':cedula', $_SESSION['cedula_user']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;
    if(count($results) > 0){
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de usuarios</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="app/css/style.css">
  </head>

  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($user)): ?>
      <br>Bienvenido <?= $user['email'] ?>
      <br>Has iniciado sesion!
      <a href="logout.php">Salir</a>
    <?php else: ?>
    <h1>Por favor ingrese o registrese</h1>
    <div class="opciones">
      <a href="login.php">Login</a>
    </div>
    <div class="opciones">
      <a href="signup.php">Registrarse</a>
    </div>
    <?php endif; ?>
    
  </body>

</html>