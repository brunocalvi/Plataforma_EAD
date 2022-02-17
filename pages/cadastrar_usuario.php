<?php 
include('lib/conexao.php');
/*include('lib/enviaArquivo.php');*/
include('lib/protect.php');
protect(1);

if(isset($_POST['enviar'])) {

    $nome = $mysqli->escape_string($_POST['nome']);
    $email = $mysqli->escape_string($_POST['email']);
    $creditos = $mysqli->escape_string($_POST['creditos']);
    $senha_desc = $mysqli->escape_string($_POST['senha']);
    $confirma_senha = $mysqli->escape_string($_POST['confirmaSenha']);
    $admin = $mysqli->escape_string($_POST['admin']);
    
    $erro = array();

    if (empty($nome)) {
        $erro[] = "Preencha o Nome!";
    }

    if (empty($email)) {
        $erro[] = "Preencha o e-mail!";
    }

    if (empty($creditos)) {
        $creditos = 0;
    }

    if(strlen($senha_desc) < 6 && strlen($senha_desc) > 16 && strlen($senha_desc) == 0 ) {
        $erro[] = "A senha deve conter de 6 a 16 caracteres!";
      }

    if($senha_desc != $confirma_senha) {
        $erro[] = "Senha de confirmação não esta valida! ";
    }

    if ($admin != 1 ) {
        $admin = 0;
    }

    /*if(!isset($_FILES) || !isset($_FILES['imagem']) || $_FILES['imagem']['size'] == 0) {
        $erro[] = "insira uma imagem para o curso!";
    }*/

    if (count($erro) == 0) {

      //$deu_certo = enviarArquivo($_FILES['imagem']['error'], $_FILES['imagem']['size'], $_FILES['imagem']['name'], $_FILES['imagem']['tmp_name']);
      //if ($deu_certo !== false) {

            $senha = password_hash($senha_desc, PASSWORD_DEFAULT);
            
            $sql_code = "INSERT INTO usuarios (nome, email, senha, data_cadastro, creditos, admin)
                        VALUES('$nome', '$email', '$senha', NOW(), '$creditos', '$admin')";

            $inserido = $mysqli->query($sql_code);

            if(!$inserido) {
                $erro[] = "Falha ao inserir no banco " . $mysql->error;
            } else {
                die("<script>location.href='index.php?p=gerenciar_usuarios'</script>");
            }

      //} else {
            //$erro[] = "Falha ao enviar a imagem";
      //} 
    }
}

?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Cadastrar Usuario</h4>
                    <span> Preencha as informaçôes sobre o usuario e enseguida salve!</span>
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
                        <a href="index.php?p=gerenciar_usuarios">
                            Gerenciar Usuarios
                        </a>
                    </li>
                    <li class="breadcrumb-item">Cadastrar Usuario</li>
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Nome:</label><br>
                                <input type="text" class="form-control" name="nome" placeholder="Insira o Nome">
                            </div>
                        </div>
                        
                         <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">E-mail:</label><br>
                                <input type="text" class="form-control" name="email" placeholder="email@email.com">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Creditos:</label><br>
                                <input type="text" class="form-control" name="creditos" placeholder="Insira os creditos">
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Senha:</label><br>
                                <input type="password" class="form-control" name="senha" placeholder="Insira uma senha">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Confirma Senha:</label><br>
                                <input type="password" class="form-control" name="confirmaSenha" placeholder="Insira a senha novamente">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Usuario Administrador:</label><br>
                                <input type="radio" name="admin" value="1"/> Sim
                                <input type="radio" name="admin" value="0" style="margin-left: 15px;"/> Não
                            </div>
                        </div>
                        
                        
                        <!--<div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Imagem:</label><br>
                                <input type="file" class="form-control" name="imagem" placeholder="Insira o titulo">
                            </div>
                        </div>-->
                        
                        <div class="col-lg-12">
                            <button type="submit" name="enviar" value="1" class="btn btn-success btn-round" style="float: right;"><i class="ti-save"></i>Salvar</button>
                            
                            <a href="index.php?p=gerenciar_usuarios">
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