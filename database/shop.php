<?php require 'connectionPDO.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop</title>
</head>
<body>
  <h1>Página de compra</h1>
  <form action="proccess_shop.php" method="post">
    <p>Selecciona un usuario: 
      <select name="username" id="">
        <?php
        $stmt = $link->prepare("SELECT username FROM users");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach($results as $user){
          printf("<option>%s</option>", $user->username);
        }
        $stmt = null;
        ?>
      </select>
    </p>
    <table>
      <thead>
        <tr>
          <th>
            Producto
          </th>
          <th>
            Precio
          </th>
          <th>
            Cantidad
          </th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $stmt = $link->prepare('SELECT * FROM products');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($results as $product) {
          printf('<tr><td>%s</td><td>%.2f€</td><td><input type="number" min="0" value="0" step="1" name="%d"></td></tr>',
          $product->name,
          $product->price,
          $product->id
        );
          
        }
        $stmt = null;
        ?>

      </tbody>
    </table>
    <input type="submit" value="enviar">
  </form>
  <?php
  $link =null;
  ?>
</body>
</html>