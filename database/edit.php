<?php require_once 'connection.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Crear producto</h1>
  <?php
  if(!empty($_GET['id'])){ 
    $sql = 'SELECT * FROM products WHERE id = ' . $_GET['id'];
    $results = $link->query($sql);
    $product = $results->fetch_object();
    
    if ($product) {
  ?>
  <form action="update.php?id=<?=$_GET['id']?>" method="post">
    <p>
      <input type="text" name="name" id="" value="<?=$product->name ?>" maxlength="30" > 
    </p>
    <p>
      <input type="number" name="price" id="" step="0.01" value="<?=$product->price?>">
    </p>        
    <p>
      <button type="submit">Modificar</button>
    </p>
  </form>
  <?php
    }
  }
  ?>
  <p>
    <a href="read.php">Volver a la tabla</a>
  </p>
</body>
</html>