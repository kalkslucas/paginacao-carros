<?php
require_once 'conexao.php';
$sqlQtdVeiculos = "SELECT COUNT(*) AS QTDVEICULOS FROM modelos";
$sqlQtdVeiculosExec = $conectar->prepare($sqlQtdVeiculos);
$sqlQtdVeiculosExec->execute();
$linhaQtdVeiculos = $sqlQtdVeiculosExec->fetch(PDO::FETCH_ASSOC);
$qtdVeiculos = $linhaQtdVeiculos['QTDVEICULOS'];

$page = $_GET['page'] ? intval($_GET['page']) : 1;
$limit = 50;
$offset = ($page - 1) * $limit;

$page_number = ceil($qtdVeiculos/$limit);
$page_interval = 2;

$sql = "SELECT marcas.nome as marca, modelos.nome as modelo
FROM modelos 
INNER JOIN marcas 
ON modelos.idmarca = marcas.id 
ORDER BY marca asc
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
    
    <p>Página: <?=$page?> | Número de páginas: <?=$page_number?></p>

    <p>
      <a href="?page=1"> << </a>
    <?php
      $first_page = max($page - $page_interval, 1);
      $last_page = min($page_number, $page + $page_interval);
      for ($i = $first_page; $i <= $last_page; $i++) {
        if($i === $page) { ?>
        [<?=$i?>]
    <?php } else { ?>
        <a href="?page=<?=$i?>">[<?=$i?>]</a>
    <?php } } ?>
      <a href="?page=<?=$page_number?>"> >> </a>
    </p>
  </div>
 
</body>
</html>