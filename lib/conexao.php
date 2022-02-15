<?php 
    $hostname = "localhost";
    $bancoDeDados = "escola_ead";
    $usuario = "root";
    $senha = "";

    $mysqli = new mysqli($hostname, $usuario, $senha, $bancoDeDados);
        if 
($mysqli->connect_errno) {
            echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            exit();
        }
?>