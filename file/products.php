<?php
  if ( 
      !(
        empty($_POST['product']) || 
        empty($_POST['price']) || 
        empty($_POST['stock'])
      ) 
    ) {
      $file = fopen('productos.csv', 'a');
      $data = $_POST['product'] . ";" . str_replace('.', ',', $_POST['price']) . ";" . $_POST["stock"] . PHP_EOL;
      fwrite($file, $data);
      fclose($file);
  } 



  $file = fopen('productos.csv', 'r');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Productos</h1>
  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
<?php
  // while($row = fscanf($file, "%s %D %i\n")) {
  //   list($product, $price, $amount) = $row;
  //   printf(
  //     "<tr>" . 
  //       "<td>%s</td>" .
  //       "<td>%.2f</td>" .
  //       "<td>%d</td>" .
  //     "</tr>"
  //   , $product, $price, $amount);
  // }

  while ($row = fgets($file)) {
    list($product, $price, $amount) = explode(';', $row);
    printf(
      "<tr>" . 
        "<td>%s</td>" .
        "<td>%.2f</td>" .
        "<td>%d</td>" .
      "</tr>"
    , $product, str_replace(',', '.',$price), $amount);  
  }
?>
  </tbody>
  </table>
  <form action="" method="post">
    <p>
      <label for="">Producto: </label>
      <input type="text" name="product">
    </p>
    <p>
      <label for="">Precio: </label>
      <input type="number" name="price" step="0.01">
    </p>
    <p>
      <label for="">Stock</label>
      <input type="number" name="stock" step="1">
    </p>
    <p>
      <button type="submit">Guardar</button>
    </p>
  </form>
</body>
</html>
<?php
fclose($file);
?>