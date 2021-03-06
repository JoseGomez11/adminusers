<?php
  require 'database.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer-master/src/Exception.php';
  require 'PHPMailer-master/src/PHPMailer.php';
  require 'PHPMailer-master/src/SMTP.php';

  $message = '';

  if(
    !empty($_POST['cedula']) &&
    !empty($_POST['nombres']) &&
    !empty($_POST['apellidos']) &&
    !empty($_POST['username']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password']) &&
    !empty($_POST['tipo']) &&
    !empty($_POST['programa'])
  ){
    $sql = "INSERT INTO users (
      cedula,
      nombres,
      apellidos,
      username,
      email,
      password,
      tipo,
      programa,
      hash,
      activo
    ) VALUES (
      :cedula,
      :nombres,
      :apellidos,
      :username,
      :email,
      :password,
      :tipo,
      :programa,
      :hash,
      0
    )";
    $stmt = $connection->prepare($sql);
    
    $stmt->bindParam(':cedula', $_POST['cedula']);
    $stmt->bindParam(':nombres', $_POST['nombres']);
    $stmt->bindParam(':apellidos', $_POST['apellidos']);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':tipo', $_POST['tipo']);
    $stmt->bindParam(':programa', $_POST['programa']);
    $hash = hash_hmac('sha256', $_POST['cedula'], $_POST['password']);
    $stmt->bindParam(':hash', $hash);

    if($stmt->execute()){
      $message = "Revisa la bandeja de correo para activar tu cuenta";
      $mail = new PHPMailer(true);

      try {
          //Server settings
          $mail->SMTPDebug = 0;                    //Enable verbose debug output
          $mail->isSMTP();                                            //Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          $mail->Username   = 'osoriopolo8@gmail.com';                     //SMTP username
          $mail->Password   = 'bftnjilnhcueiixb';                       //SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

          //Recipients
          $mail->setFrom('osoriopolo8@gmail.com', 'Adminusers');
          $mail->addAddress($_POST['email']);     //Add a recipient
          
          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Adminusers - Activaci??n de cuentas';
          $mail->Body    = 'Para activar su cuenta haga clic en <a href="http://localhost/adminusers/activar.php?email='.$_POST['email'].'&hash='.$hash.'">Activar</a>';
          //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();
          echo 'Message has been sent';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    } else {
      $message = "Ha ocurrido un error";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarse</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="app/css/style.css">
</head>
<body>

  <?php require 'partials/header.php' ?>

  <?php if(!empty($message)): ?>
    <p><?= $message ?></p>
  <?php endif ?>

  <h1>Registrarse</h1>
  <span>o <a href="login.php">Login</a></span>
  
  <form action="signup.php" method="post">
    <input type="text" name="cedula" placeholder="Ingresa tu c??dula">
    <input type="text" name="nombres" placeholder="Ingrese nombre">
    <input type="text" name="apellidos" placeholder="Ingrese apellidos">
    <input type="text" name="username" placeholder="Ingresa tu username">
    <input type="text" name="email" placeholder="Ingresa tu email">
    <input type="password" name="password" placeholder="Ingresa tu contrase??a">
    <input type="password" name="confirm_password" placeholder="Repite contrase??a">
    
    <div>
      <div class="opciones">
        <label>Tipo</label>
        <select name="tipo" id="tipo">
          <option value="profesor">Profesor</option>
          <option value="administrativo">Administrativo</option>
        </select>
      </div>
      
      <div class="opciones">
        <label>Programa</label>
        <select name="programa" id="programa">
          <option value="Medicina Veterinaria y Zootecnia">Medicina Veterinaria y Zootecnia</option>
          <option value="Acuicultura">Acuicultura</option>
          <option value="Ing. Agronomica">Ing. Agron??mica</option>
          <option value="Estadistica">Estad??stica</option>
          <option value="Matematicas">Matem??ticas</option>
          <option value="Geografia">Geograf??a</option>
          <option value="Fisica">F??sica</option>
          <option value="Quimica">Qu??mica</option>
          <option value="Biologia">Biolog??a</option>
          <option value="Bacteriologia">Bacteriolog??a</option>
          <option value="Enfermeria">Enfermer??a</option>
          <option value="Tecnologia en Regencia y Farmacia">Tecnolog??a en Regencia y Farmacia</option>
          <option value="Adm. Salud">Adm. Salud</option>
          <option value="Lic. Ciencias Sociales">Lic. Ciencias Sociales</option>
          <option value="Lic. Educacion Fisica">Lic. Educaci??n F??sica</option>
          <option value="Lic. Literatura y Lengua Castellana">Lic. Literatura y Lengua Castellana</option>
          <option value="Lic. Informatica">Lic. Inform??tica</option>
          <option value="Lic. Ingles">Lic. Ingles</option>
          <option value="Lic. Ciencias Naturales y Educacion Ambiental">Lic. Ciencias Naturales y Educaci??n Ambiental</option>
          <option value="Lic. Educacion Infantil">Lic. Educaci??n Infantil</option>
          <option value="Ing. Mecanica">Ing. Mec??nica</option>
          <option value="Ing. Ambiental">Ing. Ambiental</option>
          <option value="Ing. Industrial">Ing. Industrial</option>
          <option value="Ing. Alimentos">Ing. Alimentos</option>
          <option value="Ing. Sistemas">Ing. Sistemas</option>
          <option value="Derecho">Derecho</option>
          <option value="Adm. Finanzas y Negocios Internacionales">Adm. Finanzas y Negocios Internacionales</option>
        </select>
      </div>
    </div>
    
    <input type="submit" value="Registrarse"> 
  </form>
</body>
</html>