<?php
@$link = new mysqli("localhost", "shopuser", "1234", "shop");
//@$link = new mysqli("localhost", "root", "users");
$error = $link->connect_errno;

if($error != null) {
  echo "<p>Error $error conectando a la base de datos: $link->connect_error</p>";
  die('error nuestro');
}


