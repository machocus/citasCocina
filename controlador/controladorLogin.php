<?php
include("../modelo/modeloUsuarios.php");
    //variables de errores
    $errorPassword=false;
    $usuarioNoregistrado=false;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST['email'];
      $contraseña = $_POST['contraseña'];
      //ciframos la contraseña
      $cifrarPassword = hash("sha256", $contraseña);
      //si el usuario existe en bd obtiene los credenciales para comprobar password 
      if (encontrarUsuario($email)) {
        $credenciales = obtenerCredenciales($email); //devuelve array con los datos
        //si la contraseña es correcta crea la sesion y carga home
        if ($credenciales[2] == $cifrarPassword) {
          session_start();
          $_SESSION['idUsuario'] = $credenciales[0];
          $_SESSION['dni'] = $credenciales[1];
          $_SESSION['contraseña'] = $credenciales[2];
          $_SESSION['nombre'] = $credenciales[3];
          $_SESSION['baneado'] = $credenciales[4];
          $_SESSION['rol'] = $credenciales[5];
          $_SESSION['email'] = $credenciales[6];
          // header("Location:../index.html");
          echo "<script type=\"text/javascript\">window.location.href = \"../index.php\";</script>";
        } else {
          $errorPassword = true;
          header("Location:../vista/login.php?email=$email");
          // echo "<script type=\"text/javascript\">window.location.href = \"../vista/login.php\";</script>";
        }
      } else {
        $usuarioNoregistrado = true;
      }
    }
?>