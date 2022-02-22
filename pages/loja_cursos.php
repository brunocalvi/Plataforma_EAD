<?php
include('lib/protect.php');
protect(0);

if (!isset($_SESSION)) 
    session_start();

$erro = false;
if(isset($_POST['adquirir'])) {

    $id_usuario = $_SESSION['usuario'];

    $sql_query_creditos = $mysqli->query("SELECT creditos FROM usuarios WHERE id = '$id_usuario'") or die($mysqli->error);
    $usuario = $sql_query_creditos->fetch_assoc();

    $creditos_usuario = $usuario['creditos'];

    $id_curso = intval($_POST['adquirir']);

    $sql_query_cursos = $mysqli->query("SELECT preco FROM cursos WHERE id = '$id_curso'") or die($mysqli->error);
    $curso = $sql_query_cursos->fetch_assoc();

    $preco_curso = $curso['preco'];

    if($preco_curso > $creditos_usuario) {
        $erro = "Você não possui creditos para adquirir este curso !";
    
    } else {
        $mysqli->query("INSERT INTO relatorio (id_usuario, id_curso, valor, data_compra)
                        VALUES ('$id_usuario', '$id_curso', '$preco_curso', NOW())") or die($mysqli->error);

        $valor_final = $creditos_usuario - $preco_curso;

        $mysqli->query("UPDATE usuarios 
                        SET creditos = '$valor_final' 
                        WHERE id = '$id_usuario'") or die($mysqli->error);

        die("<script>location.href='index.php?p=meus_cursos'</script>");
    }

}

$id_usuario = $_SESSION['usuario'];

$cursos_query = $mysqli->query("SELECT * FROM cursos WHERE id NOT IN (SELECT id_curso FROM relatorio WHERE id_usuario = '$id_usuario')") or die($mysqli->error);

?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Loja de Cursos</h4>
                    <span> Adquira nossos cursos utilizando os créditos</span>
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
                    <li class="breadcrumb-item">Loja de Cursos</li>
                </ul>
            </div>
            </div>
        </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <?php if($erro !== false) { ?>
            <div class="alert alert-danger" role="alert">
            <?php echo "$erro";?>
            </div>
            <?php } ?>
        </div>

        <?php while ($curso = $cursos_query->fetch_assoc()) { ?>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo $curso['titulo']; ?></h5>
                    
                </div>
                <div class="card-block">
                    <img src="<?php echo $curso['imagem']; ?>" class="img-fluid" alt="img curso">
                <hr/>
                    <p>
                    <?php echo $curso['descricao_curta']; ?>
                    </p>
                    <form action="" method="POST">
                        <button type="submit" name="adquirir" value="<?php echo $curso['id']; ?>" class="btn form-control btn-out-dashed btn-success btn-squard">
                            Adquirir Por R$ <?php echo number_format($curso['preco'], 2, ',' ,'.'); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php } ?>

    </div>
</div>