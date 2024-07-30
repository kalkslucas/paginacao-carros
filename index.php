<?php
require_once 'conexao.php';

$page = 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT marcas.nome as marca, modelos.nome as modelo
FROM modelos 
INNER JOIN marcas 
ON modelos.idmarca = marcas.id 
LIMIT :limite OFFSET :offset";
$pesquisar = $conectar->prepare($sql);
$pesquisar->bindParam(":limite", $limit, PDO::PARAM_INT);
$pesquisar->bindParam(":offset", $offset, PDO::PARAM_INT);
$pesquisar->execute();
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Busca</title>

  <style>
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Lista de Veículos</h1>
    <table border="1" style="margin: 15px; width: 400px;">
      <tr>
        <th>Marca</th>
        <th>Modelo</th>
      </tr>

      <?php while($linha = $pesquisar->fetch(PDO::FETCH_ASSOC)) { ?>
      <tr>
        <td><?= $linha['marca'] ?></td>
        <td><?= $linha['modelo'] ?></td>
      </tr>  
      <?php } ?>
    </table>
  </div>
 
</body>
</html>