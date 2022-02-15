<?php
include('lib/conexao.php');

$sql_cursos = "SELECT * FROM cursos";
$query_cursos = $mysqli->query($sql_cursos) or die($mysqli->error);

$num_cursos = $query_cursos->num_rows;
    
    
?>
<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Gerenciamento dos Cursos</h4>
                    <span>Administração dos cursos cadastrados no sistema!</span>
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
                    <li class="breadcrumb-item">Gerenciar Cursos</li>
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
                    <h5>Cursos</h5>
                    <span>Todos os cursos disponibilizados pela Harvard Business School</span>
                    <a href="index.php?p=cadastrar_curso">
                    <button class="btn btn-out-dashed btn-success btn-squard" style="float: right;">Cadastrar Novo Curso</button>
                    </a>
                    
                </div>
                <div class="card-block table-border-style">
                   <div class="table-responsive">
                       <table class="table">
                            <thead>
                               <tr>
                                   <th>#</th>
                                   <th>Imagem</th>
                                   <th>Titulo</th>
                                   <th>Preço</th>
                                   <th>Gerenciar</th>
                               </tr>
                           </thead>
                           <tbody>
                               
                        <?php
                            if($num_cursos == 0) { ?>
        
                                <tr>
                                    <td colspan="5">Não há Registro de Cursos !</td>
                                </tr>
                               
                        <?php
                            } else {
                               
                                while($curso = $query_cursos->fetch_assoc()) {

                        ?>
                               
                            <tr>
                                <td scope="row"><?php echo $curso['id']; ?></td>
                                <td><img src="<?php echo $curso['imagem']; ?>" height="50px" alt="logo curso"></td>
                                <td><?php echo $curso['titulo']; ?></td>
                                <td>R$ <?php echo number_format($curso['preco'], 2, ',', '.') ?></td>
                                <td>
                                    <a href="index.php?p=editar_curso&id=<?php echo $curso['id'];?>">Editar</a> | 
                                    <a href="index.php?p=deletar_curso&id=<?php echo $curso['id'];?>">Deletar</a>
                                </td>
                            </tr>
                               
                        <?php
                                }
                            }
                        ?>    
                               
                           </tbody> 
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>