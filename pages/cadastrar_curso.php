<?php 
include('lib/conexao.php');
include('lib/enviaArquivo.php');
include('lib/protect.php');
protect(1);

if(isset($_POST['enviar'])) {

    $titulo = $mysqli->escape_string($_POST['titulo']);
    $descricao_curta = $mysqli->escape_string($_POST['descricao_curta']);
    $preco = $mysqli->escape_string($_POST['preco']);
    $conteudo = $mysqli->escape_string($_POST['conteudo']);
    
    $erro = array();

    if (empty($titulo)) {
        $erro[] = "Preencha o titulo!";
    }

    if (empty($descricao_curta)) {
        $erro[] = "Preencha a descrição curta!";
    }

    if (empty($preco)) {
        $erro[] = "Preencha a descrição o preço!";
    }

    if (empty($conteudo)) {
        $erro[] = "Preencha o conteudo!";
    }

    if(!isset($_FILES) || !isset($_FILES['imagem']) || $_FILES['imagem']['size'] == 0) {
        $erro[] = "insira uma imagem para o curso!";
    }

    if (count($erro) == 0) {

        $deu_certo = enviarArquivo($_FILES['imagem']['error'], $_FILES['imagem']['size'], $_FILES['imagem']['name'], $_FILES['imagem']['tmp_name']);
        if ($deu_certo !== false) {
            
            $sql_code = "INSERT INTO cursos (titulo, descricao_curta, conteudo, data_cadastro, preco, imagem)
                        VALUES('$titulo', '$descricao_curta', '$conteudo', NOW(), '$preco', '$deu_certo')";

            $inserido = $mysqli->query($sql_code);

            if(!$inserido) {
                $erro[] = "Falha ao inserir no banco " . $mysql->error;
            } else {
                die("<script>location.href='index.php?p=gerenciar_cursos'</script>");
            }

        } else {
            $erro[] = "Falha ao enviar a imagem";
        } 
    }
}

?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Cadastrar Curso</h4>
                    <span> Preencha as informaçôes sobre o curso e enseguida salve!</span>
                </div>
           </div>
        </div>
        
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="index.php?p=gerenciar_cursos.php">
                            Gerenciar cursos
                        </a>
                    </li>
                    <li class="breadcrumb-item">Cadastrar Curso</li>
                </ul>
            </div>
            </div>
        </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <?php if(isset($erro) && count($erro) > 0) { ?>
                <div class="alert alert-danger" role="alert">

                    <?php  
                    foreach ($erro as $e) {
                       echo "$e</br>"; 
                    } 
                    ?>

                </div>

            <?php } ?>

            <div class="card">
                <div class="card-header">
                    <h5>Formulário de Cadastro</h5>
                </div>
                <div class="card-block">
                    
                    <form action='' method="post" enctype="multipart/form-data">
                
                    <div class="row">  
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Titulo:</label><br>
                                <input type="text" class="form-control" name="titulo" placeholder="Insira o titulo">
                            </div>
                        </div>
                        
                         <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Preço:</label><br>
                                <input type="text" class="form-control" name="preco" placeholder="9.999,99">
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Descrição Curta do Curso:</label><br>
                                <input type="text" class="form-control" name="descricao_curta" placeholder="insira uma breve descrição do curso">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Conteudo:</label><br>
                                <textarea class="form-control" rows="10" name="conteudo" placeholder="insira o conteudo do curso aqui ..."></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Imagem:</label><br>
                                <input type="file" class="form-control" name="imagem" placeholder="Insira o titulo">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <button type="submit" name="enviar" value="1" class="btn btn-success btn-round" style="float: right;"><i class="ti-save"></i>Salvar</button>
                            
                            <a href="index.php?p=gerenciar_cursos">
                                <button type="button" class="btn btn-danger btn-round" style="float: right;margin-right: 10px;">
                                <i class="ti-arrow-left"></i>Voltar</button>
                            </a>
                        </div>
                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>