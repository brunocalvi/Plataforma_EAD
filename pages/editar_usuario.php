<?php 
include('lib/conexao.php');
/*include('lib/enviaArquivo.php');*/
include('lib/protect.php');
protect(1);

$id = intval($_GET['id']);

if(isset($_POST['enviar'])) {

    $nome = $mysqli->escape_string($_POST['nome']);
    $email = $mysqli->escape_string($_POST['email']);
    $creditos = $mysqli->escape_string($_POST['creditos']);
    $senha = $mysqli->escape_string($_POST['senha']);
    $senha_desc = $mysqli->escape_string($_POST['senha']);
    $confirma_senha = $_POST['confirmaSenha'];
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

if($senha_desc != $confirma_senha) {
    $erro[] = "Insira uma senha valida! ";
}

if ($admin != 1 ) {
    $admin = 0;
}

if (count($erro) == 0) {

    $sql_code = "UPDATE usuarios SET
                    nome = '$nome',
                    email = '$email',
                    creditos = '$creditos',
                    admin = '$admin'
                WHERE id = '$id'";

    if (!empty($senha_desc)) {

        $senha = password_hash($senha_desc, PASSWORD_DEFAULT);

        $sql_code = "UPDATE usuarios SET
                nome = '$nome',
                email = '$email',
                senha = '$senha',
                creditos = '$creditos',
                admin = '$admin'
            WHERE id = '$id'";
    }

    $mysqli->query($sql_code) or die($mysqli->error);
    die("<script>location.href='index.php?p=gerenciar_usuarios'</script>");
    
  }
}

$sql_code = "SELECT * FROM usuarios WHERE id = '$id'";
$query_usuarios = $mysqli->query($sql_code) or die($mysqli->error);

$usuario = $query_usuarios->fetch_assoc();

?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Editar Usuario</h4>
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
                        <a href="index.php?p=gerenciar_usuarios">
                            Gerenciar usuarios
                        </a>
                    </li>
                    <li class="breadcrumb-item">Editar Usuario</li>
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
                    <h5>Informaçoes do Usuario</h5>
                </div>
                <div class="card-block">
                    
                    <form action='' method="post" enctype="multipart/form-data">
                
                    <div class="row">  
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="">Nome:</label><br>
                                <input type="text" class="form-control" name="nome" value="<?php echo $usuario['nome']; ?>">
                            </div>
                        </div>
                                                                                                                          
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Data de Cadastro:</label><br>
                                <input type="text" class="form-control" name="" value="<?php echo $usuario['data_cadastro'] = gmDate("d/m/Y"); ?>" disabled="">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="">E-mail:</label><br>
                                <input type="email" class="form-control" name="email" value="<?php echo $usuario['email']; ?>">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Creditos:</label><br>
                                <input type="text" class="form-control" name="creditos" value="<?php echo $usuario['creditos']; ?>">
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
                                <input type="radio" name="admin" value="1" <?php if($usuario['admin'] == 1) echo 'checked'; ?>/> Sim
                                <input type="radio" name="admin" value="0" <?php if($usuario['admin'] == 0) echo 'checked'; ?> style="margin-left: 15px;"/> Não
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" name="enviar" value="1" class="btn btn-success btn-round" style="float: right;"><i class="ti-save"></i>Salvar</button>
                            
                            <a href="index.php?p=gerenciar_usuarios"><button type="button" class="btn btn-danger btn-round" style="float: right;margin-right: 10px;"><i class="ti-arrow-left"></i>Voltar</button></a>
                        </div>
                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>