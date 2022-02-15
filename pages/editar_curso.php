<?php 
include('lib/conexao.php');
include('lib/enviaArquivo.php');

$id = intval($_GET['id']);

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

    if (count($erro) == 0) {

        $imagemAlterada = false;
        if(isset($_FILES['imagem']) && isset($_FILES['imagem']['size']) && $_FILES['imagem']['size'] > 0) {
            $deu_certo = enviarArquivo( $_FILES['imagem']['error'],
                                        $_FILES['imagem']['size'],
                                        $_FILES['imagem']['name'],
                                        $_FILES['imagem']['tmp_name']
                                    );
            $imagemAlterada = true;
        } else {
            $deu_certo = true;
        }
        
        if ($deu_certo !== false) {

            if ($imagemAlterada) {
                $sql_code = "UPDATE cursos SET 
                                titulo = '$titulo',
                                descricao_curta = '$descricao_curta',
                                conteudo = '$conteudo',
                                preco = '$preco',
                                imagem = '$deu_certo'
                             WHERE id = '$id'";
            
            } else {
                $sql_code = "UPDATE cursos SET 
                                titulo = '$titulo',
                                descricao_curta = '$descricao_curta',
                                conteudo = '$conteudo',
                                preco = '$preco'
                             WHERE id = '$id'";
            }

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



$sql_code = "SELECT * FROM cursos WHERE id = '$id'";
$query_curso = $mysqli->query($sql_code) or die($mysqli->error);

$curso = $query_curso->fetch_assoc();

?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Editar Curso</h4>
                    <span>Insira as informaçoes que deseja editar e salve!</span>
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
                        <a href="index.php?p=gerenciar_cursos">
                            Gerenciar cursos
                        </a>
                    </li>
                    <li class="breadcrumb-item">Editar Curso</li>
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
                    <h5>Informaçoes do Curso</h5>
                </div>
                <div class="card-block">
                    
                    <form action='' method="post" enctype="multipart/form-data">
                
                    <div class="row">  
                    <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Banner Atual:</label><br>
                                <img src="<?php echo $curso['imagem']; ?>" height="150px" alt="logo curso">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Titulo:</label><br>
                                <input type="text" class="form-control" name="titulo" value="<?php echo $curso['titulo']; ?>">
                            </div>
                        </div>
                        
                         <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Preço:</label><br>
                                <input type="text" class="form-control" name="preco" value="<?php echo $curso['preco']; ?>">
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Descrição Curta do Curso:</label><br>
                                <input type="text" class="form-control" name="descricao_curta" value="<?php echo $curso['descricao_curta']; ?>">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Conteudo:</label><br>
                                <textarea class="form-control" rows="10" name="conteudo" ><?php echo $curso['conteudo']; ?>"</textarea>
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
                            
                            <a href="index.php?p=gerenciar_cursos"><button type="button" class="btn btn-danger btn-round" style="float: right;margin-right: 10px;"><i class="ti-arrow-left"></i>Voltar</button></a>
                        </div>
                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>