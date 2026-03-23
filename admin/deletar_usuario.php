<?php
session_start();
include '../publico/conexao.php';

if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 'admin') {
    header("Location: ../publico/login.php");
    exit;
}

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM alunos WHERE id=$id");
}

header("Location: area_admin.php");
exit;
?>
