<?php

function enviarArquivo($error, $size, $name, $tmp_name) {

  if($error)
    die("Falha ao enviar arquivo");

  if($size > 2897152) 
    die("Arquivo exedido o tamanho, Max 2MB");
      
  $pasta = "upload/";
  $nome_arquivo = $name;
  $novo_nome_arquivo = uniqid();
  $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

  if($extensao != "jpg" && $extensao != 'png' && $extensao != 'gif')
    die("Tipo de arquivo não aceito!");

  $path = $pasta . $novo_nome_arquivo . "." . $extensao;
  $deu_certo = move_uploaded_file($tmp_name, $path);

  if($deu_certo) {
      return $path;
  } else {
      false;
  }
};

?>