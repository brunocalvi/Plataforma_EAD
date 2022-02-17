<?php
include('lib/conexao.php');
include('lib/protect.php');
protect(1);

$sql_relatorio = "SELECT rel.id, user.nome, rel.data_compra, rel.valor 
                    FROM relatorio rel, cursos cur, usuarios user
                    WHERE user.id = rel.id_usuario 
                    AND cur.id = id_curso 
                ";

$query_relatorio = $mysqli->query($sql_relatorio) or die($mysqli->error);

$num_relatorio = $query_relatorio->num_rows;
  
?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Relatorio</h4>
                    <span>Visualizando as informaçoes do usuario no sistema!</span>
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
                    <li class="breadcrumb-item">Relatorio</li>
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
                    <h5>Relatorio</h5>
                    <span>Examine o relatorio de compras do usuario</span>
                </div>
                <div class="card-block table-border-style">
                   <div class="table-responsive">
                       <table class="table">
                            <thead>
                               <tr>
                                   <th>ID</th>
                                   <th>Usuario</th>
                                   <th>Curso</th>
                                   <th>Data da compra</th>
                                   <th>Valor</th>
                               </tr>
                           </thead>
                           <tbody>
                               
                        <?php
                            if($num_relatorio == 0) { ?>
        
                                <tr>
                                    <td colspan="5">Não há nenhum registro do Usuario !</td>
                                </tr>
                               
                        <?php
                            } else {
                               
                                while($relatorio = $query_relatorio->fetch_assoc()) {
                        ?>
                               
                            <tr>
                                <td scope="row"><?php echo $relatorio['id']; ?></td>
                                <td><?php echo $relatorio['nome']; ?></td>
                                <td><?php echo $relatorio['titulo']; ?></td>
                                <td><?php echo $relatorio['data_compra'] = gmDate("d/m/Y H:i"); ?></td>
                                <td>R$ <?php echo number_format($relatorio['valor'], 2, ',', '.') ?></td>    
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