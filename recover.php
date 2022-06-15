<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar contraseña</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="app/css/style.css">
</head>
<body>
  <?php require 'partials/header.php' ?>
  <h1>Recuperar contraseña</h1>
  <p>Ingrese ya sea correo o username</p>
  <form action="login.php" method="post">
    <input type="text" name="email" placeholder="Ingresa tu email">
    <input type="text" name="username" placeholder="Ingrese username">
    <input type="submit" value="Recuperar">
  </form>
  <a href="/adminusers">Volver a Inicio</a>
</body>
</html>