<?php 

include('lib/conexao.php');

$id = intval($_GET['id']);

$mysql_query =  $mysqli->query("SELECT imagem FROM cursos WHERE id = '$id'") or die($mysqli->error);
$curso = $mysql_query->fetch_assoc();

if(unlink($curso['imagem'])) {
    $mysqli->query("DELETE FROM cursos WHERE id = '$id'") or die($mysqli->error);
};

die("<sript>location.href='index.php?p=gerenciar_cursos';</script>");
?>