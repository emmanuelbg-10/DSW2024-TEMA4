<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php include 'menu.php' ?>
  <?php
  $username = isset($_GET['username']) ? $_GET['username'] : "";
  
  ?>
  <h1>Carritos de compra de <?= $username ?></h1>
  <h2>Se añade a 'Sales' se elimina de "Cart" y decrementa el stock de "Products"</h2>
  <?php
  require 'connectionPDO.php';
  try {
    $link->beginTransaction();
    $stmtCart = $link->prepare("SELECT products.id, name, price, username, amount, stock from products INNER JOIN cart On products.id = cart.id WHERE username = :username");
  $stmtCart->bindParam(':username', $username);

  $stmtInsertSales = $link->prepare("INSERT INTO sales(id, username, amount, price, date) VALUES (:id, :username,:amount, :price, NOW())");
  $stmtInsertSales->bindParam(':id', $id, PDO::PARAM_INT);
  $stmtInsertSales->bindParam(':username', $username);
  $stmtInsertSales->bindParam(':amount', $amount);
  $stmtInsertSales->bindParam(':price', $price); 

  $stmtDeleteCart = $link->prepare("DELETE FROM cart WHERE id = :id AND username = :username");
  $stmtDeleteCart->bindParam(':id', $id, PDO::PARAM_INT);
  $stmtDeleteCart->bindParam(':username', $username);

  $stmtUpdateStock = $link->prepare("UPDATE products SET stock = :stock WHERE id = :id");
  $stmtUpdateStock->bindParam(':id', $id, PDO::PARAM_INT);
  $stmtUpdateStock->bindParam(':stock', $stock);

  //$stmtDeleteCart = $
  ?>
  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $stmtCart->execute();
      $total = 0;
      while ($row = $stmtCart->fetchObject()) {
        $subtotal = $row->price * $row->amount;
        $total += $subtotal;
        printf("<tr><td>%s</td><td>%.2f€</td><td>%d</td><td>%.2f€</td></tr>",
        $row->name, $row->price, $row->amount, $subtotal);
        $id = $row->id;
        $amount = $row->amount;
        $price = $row->price;
        $stock = $row->stock - $amount;
        if($stock < 0){
          throw new Exception('No hay stock');
        }
        $stmtInsertSales->execute();    
        $stmtDeleteCart->execute();
        $stmtUpdateStock->execute();  
      }
      $stmtDeleteCart = null;
      $stmtInsertSales = null;
      $stmtUpdateStock = null;
      $stmtCart = null;
      $link->commit();  
  } catch (Exception $e) {
    $link->rollBack();
    die('Error'. $e->getMessage());
  }
  
      
      
      $link = null;  
      ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3">Total</th>
        <td><?= sprintf("%.2f", $total) ?></td>
      </tr>
    </tfoot>
  </table>
</body>
</html>