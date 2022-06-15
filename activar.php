<?php
require 'database.php';

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verificar datos
    $email = $_GET['email']; // Asignar el correo electrónico a una variable
    $hash = $_GET['hash']; // Asignar el hash a una variable
                
    $search = "SELECT email, hash, activo FROM users WHERE email='".$email."' AND hash='".$hash."' AND activo='0'"; 
    $match = mysqli_num_rows($search,);
                
    if($match > 0){
        // Hay una coincidencia, activar la cuenta
        mysqli_query("UPDATE cliente SET activo='1' WHERE email_clie='".$email."' AND hash_='".$hash."' AND activo='0'") or die(mysqli_error());
        echo '<div class="statusmsg">Tu cuenta ha sido activada, ya puedes iniciar sesión.</div>';
    }else{
        // No hay coincidencias
        echo '<div class="statusmsg">La URL es inválida  o ya has activado tu cuenta.</div>';
    }
}else{
    // Intento nó válido (ya sea porque se ingresa sin tener el hash o porque la cuenta ya ha sido registrada)
    echo '<div class="statusmsg">Intento inválido, por favor revisa el mensaje que enviamos correo electrónico</div>';
}
?>