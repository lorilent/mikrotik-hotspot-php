<?php

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

session_start();

include "config.php";
include "vendor/autoload.php";

$msg = "";

if(isset($_SESSION['otp'])){
  echo "<script>document.getElementById('registrazione').style.display = 'none';</script><script>document.getElementById('reparto-otp').style.display = 'block';</script>";
}

if(isset($_POST['submit'])){
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

    $nome = $con->real_escape_string($_POST['nome']);
    $cognome = $con->real_escape_string($_POST['cognome']);
    $email = $con->real_escape_string($_POST['email']);
    $telefono = $con->real_escape_string($_POST['telefono']);

    $query = mysqli_query($con, "SELECT * FROM tbl_users WHERE email='$email' AND telefono='$telefono'");

    if($nome == "" || $cognome == "" || $email == "" || $telefono == ""){

      $msg = "Completa tutti i campi!";

    }else{
    if($query->num_rows === 1){
        $msg = "Account già registrato";
    }else{
        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789';
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);

        $_SESSION['email'] = $email;

        $otp = '0123456789';
        $otp = str_shuffle($otp);
        $otp = substr($otp, 0, 6);

        mysqli_query($con, "INSERT INTO tbl_users(nome,cognome,email,telefono,token,otp,stato) VALUES('$nome','$cognome','$email','$telefono','$token','$otp','0')");

        // Create config object with parameters
        $config =
        (new Config())
            ->set('host', $ROSHost)
            ->set('port', $ROSPort)
            ->set('pass', $ROSPassword)
            ->set('user', $ROSUsername);

        // Initiate client with config object
        $client = new Client($config);

        // Build query
        $query =
        (new Query('/tool/sms/send'))
            ->equal('phone-number', $telefono)
            ->equal('message', $otp);

        // Add user
        $out = $client->query($query)->read();

        $_SESSION['otp'] = 0;

        $msg = "Ben fatto... Adesso dovresti ricevere un SMS da 6 numeri, inseriscilo! <script>document.getElementById('registrazione').style.display = 'none';</script><script>document.getElementById('reparto-otp').style.display = 'block';</script>";
    }
  }
}

if(isset($_POST['conferma-otp'])){

    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

    $otp = $_POST['otp'];
    $email = $_SESSION['email'];

    if($otp == ""){
        $msg = "Completa tutti i campi! <script>document.getElementById('registrazione').style.display = 'none';</script><script>document.getElementById('reparto-otp').style.display = 'block';</script>";
    }else{
        $sql = mysqli_query($con, "SELECT id FROM tbl_users WHERE otp='$otp' AND email='$email' AND stato='0'");
		if($sql->num_rows === 0){
            $msg = "OTP Errato! Riprova <script>document.getElementById('registrazione').style.display = 'none';</script><script>document.getElementById('reparto-otp').style.display = 'block';</script>";
        }else{
            $_SESSION['finito'] = 1;
            $_SESSION['email3'] = $email;
            mysqli_query($con, "UPDATE tbl_users SET stato='1' WHERE email='$email'");
            header('Location: credenziali.php');
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Prova gratuita | <?= $nomehotspot; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tema bootstrap 3 per Hotspot Mikrotik">
    <meta name="author" content="Lentino Loris (Informatica Today)">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

<style>
    .reparto-otp{display:none;}
</style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>

<div id="registrazione">
    <div class="container">

      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading text-center">Registrati per ottenere la prova gratuita di <?= $durata; ?></h2>
        <?= $msg; ?>
        <input type="text" class="input-block-level" name="nome" placeholder="Nome">
        <input type="text" class="input-block-level" name="cognome" placeholder="Cognome">
        <input type="email" class="input-block-level" name="email" placeholder="Indirizzo E-Mail">
        <input type="number" class="input-block-level" name="telefono" placeholder="Numero di telefono">
        <button class="btn btn-large btn-primary" name="submit" type="submit">Registrati</button>
      </form>

    </div> <!-- /container -->
    </div>

    <div id="reparto-otp" class="reparto-otp">
    <div class="container">

      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Inserisci L'OTP</h2>
        <?= $msg; ?>
        <input type="text" class="input-block-level" name="otp" placeholder="Codice Ricevuto">
        <button class="btn btn-large btn-primary" name="conferma-otp" type="submit">Conferma</button>
      </form>

    </div> <!-- /container -->
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>

  </body>
</html>
