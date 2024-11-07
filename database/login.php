<?php

if(isset($_GET['username']) && isset($_GET['password'])) {
  $username = $_GET['username'];
  $password = $_GET['password'];

  echo "us: $username, pass: $password";

  require 'connection.php';

  $stmt = $link->stmt_init();
  $stmt->prepare("SELECT * FROM users WHERE username=? AND password=?");
  $stmt->bind_param("ss", $username, $password);

  $stmt->execute();
  $results = $stmt->get_result();

  if ($results->num_rows > 0) {
    echo "<h1>Bienvenido</h1>";
  } else {
    echo "<h2>Error en el usuario y/o contraseña</h2>";
  }
  $stmt->close();
  $link->close();

  //Version insegura
  // Se puede hacer inyeccion SQL poniendo en el input de username:
  // ' OR '1'='1
  //NO USAR. MEJOR CONSULTAS PREPARADAS
  // $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  // echo "<pre>$sql</pre>";
  // $results = $link->query($sql);
  // if ($results->num_rows > 0){
  //   echo "<h1>Bienvenido</h1>";
  // }else{
  //   echo "error en el usuario y/o contraseña";
  // }
  // $link->close();
}else{
  echo "No existen los parámetros";
}


?>