<?php 

  session_start();

  if(isset($_SESSION['cedula_user'])){
    header('Location: /adminusers');
  }

  require 'database.php';
  if(!empty($_POST['email']) && !empty($_POST['password'])){
    $records = $connection->prepare('SELECT cedula, email, password FROM users WHERE email=:email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if(is_countable($results) > 0 && password_verify($_POST['password'], $results['password'])){
      $_SESSION['cedula_user'] = $results['cedula'];
      header('Location: /adminusers/sendemail.php');
    } else {
      $message = 'Lo sentimos, credenciales inválidas';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="app/css/style.css">
</head>
<body>
  <?php require 'partials/header.php' ?>
  <h1>Login</h1>
  <span>o <a href="signup.php">Registrarse</a></span>

  <?php if(!empty($message)): ?>
    <p><?= $message ?></p>
  <?php endif; ?>

  <form action="login.php" method="post">
    <input type="text" name="email" placeholder="Ingresa tu email">
    <input type="password" name="password" placeholder="Ingresa tu contraseña">
    <input type="submit" value="Ingresar">
  </form>
  <span>Olvido su contraseña? <a href="recover.php">Recuperar</a></span>
</body>
</html>