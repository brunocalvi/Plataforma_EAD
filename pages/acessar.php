<?php
$id = $_GET['id'];

if (!isset($_SESSION)) 
    session_start();

$id_usuario = $_SESSION['usuario'];

$sql_code = "SELECT * FROM cursos WHERE id = '$id' AND id IN (SELECT id_curso FROM relatorio WHERE id_usuario = '$id_usuario') ";
$query_curso = $mysqli->query($sql_code) or die
($mysqli->error);

$curso = $query_curso->fetch_assoc();


?>
<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-6">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4><?php echo $curso['titulo']; ?></h4>
                    <span><?php echo $curso['descricao_curta']; ?></span>
                </div>
           </div>
        </div>
        
        <div class="col-lg-6">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="index.php?p=meus_cursos">Meus Cursos</a></li>
                    <li class="breadcrumb-item"><a href="#!">Visualizar Curso</a></li>
                </ul>
            </div>
            </div>
        </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php $curso['titulo']; ?></h5>
                    <span><b>Comece a assistir as aulas:</b></span>
                </div>
                <div class="card-block">
                    <p>
                        <?php echo $curso['conteudo']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>