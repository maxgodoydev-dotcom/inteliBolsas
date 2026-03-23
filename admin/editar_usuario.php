<?php
session_start();
include '../publico/conexao.php';
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 'admin') {
    header("Location: ../publico/login.php");
    exit;
}

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $alunos = $conn->query("SELECT * FROM alunos WHERE id=$id")->fetch_assoc();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $area_interesse = $_POST['area_interesse'];
    
    $conn->query("UPDATE alunos SET nome='$nome', email='$email', telefone='$telefone', area_interesse='$area_interesse' WHERE id=$id");
    header("Location: area_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Aluno - InteliBolsas</title>
  <link rel="stylesheet" href="../publico/css/css_global.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-5">
  <h2>Editar Aluno</h2>

  <form method="post" class="mt-3">
    <div class="mb-3">
      <label for="nome" class="form-label">Nome</label>
      <input type="text" id="nome" class="form-control" name="nome" value="<?= htmlspecialchars($alunos['nome']) ?>">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" class="form-control" name="email" value="<?= htmlspecialchars($alunos['email']) ?>">
    </div>

    <div class="mb-3">
      <label for="telefone" class="form-label">Telefone</label>
      <input type="text" id="telefone" class="form-control" name="telefone" value="<?= htmlspecialchars($alunos['telefone']) ?>">
    </div>

    <div class="mb-3">
      <label for="area_interesse" class="form-label">Área de Interesse</label>
      <input type="text" id="area_interesse" class="form-control" name="area_interesse" value="<?= htmlspecialchars($alunos['area_interesse']) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="area_admin.php" class="btn btn-secondary">Cancelar</a>
  </form>

</body>
</html>
