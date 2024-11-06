<?php
require 'connectionPDO.php';
$min = $_GET['min'];
$stmt = $link->prepare('SELECT * FROM products WHERE price > :min');
$stmt->bindParam(":min", $min, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<table>
    <thead>
      <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th colspan="2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($result as $product) {
        echo "<tr>";
        printf('<td>%d</td>', $product->id);
        printf('<td>%s</td>', $product->name);
        printf('<td>%.2f</td>', $product->price);
        printf('<td><a href="delete.php?id=%d">eliminar</a></td>', $product->id);
        printf('<td><a href="edit.php?id=%d">editar</a></td>', $product->id);
        echo "</tr>";
      }


        
      ?>
    </tbody>
  </table>
</body>
</html>