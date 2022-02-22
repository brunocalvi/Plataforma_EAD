<?php
include('lib/conexao.php');
include('lib/protect.php');
protect(1);

$sql_usuarios = "SELECT * FROM usuarios";
$query_usuarios = $mysqli->query($sql_usuarios) or die($mysqli->error);

$num_usuarios = $query_usuarios->num_rows;
  
?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">

                <div class="d-inline">
                    <h4>Gerenciamento dos Usuarios</h4>
                    <span>Administração dos usuarios cadastrados no sistema!</span>
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
                    <li class="breadcrumb-item">Gerenciar Usuarios</li>
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
                    <h5>Usuarios</h5>
                    <span>Lista de todos os usuarios que utilizam a plataforma da Harvard Business School</span>
                    <a href="index.php?p=cadastrar_usuario">
                    <button class="btn btn-out-dashed btn-success btn-squard" style="float: right;">Cadastrar Novo Usuario</button>
                    </a>
                    
                </div>
                <div class="card-block table-border-style">
                   <div class="table-responsive">
                       <table class="table">
                            <thead>
                               <tr>
                                   <th>ID</th>
                                   <th>Nome</th>
                                   <th>E-mail</th>
                                   <th>Creditos</th>
                                   <th>Data de Cadastro</th>
                                   <th>Gerenciar</th>
                               </tr>
                           </thead>
                           <tbody>
                               
                        <?php
                            if($num_usuarios == 0) { ?>
        
                                <tr>
                                    <td colspan="5">Não há Registro de Usuarios !</td>
                                </tr>
                               
                        <?php
                            } else {
                               
                                while($usuario = $query_usuarios->fetch_assoc()) {

                                    $data_cadastro = $usuario['data_cadastro'];
                        ?>
                               
                            <tr>
                                <td scope="row"><?php echo $usuario['id']; ?></td>
                                <td><?php echo $usuario['nome']; ?></td>
                                <td><?php echo $usuario['email']; ?></td>
                                <td>R$ <?php echo number_format($usuario['creditos'], 2, ',', '.') ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($data_cadastro)); ?></td>
                                <td>
                                    <a href="index.php?p=editar_usuario&id=<?php echo $usuario['id'];?>">Editar</a> | 
                                    <a href="index.php?p=deletar_usuario&id=<?php echo $usuario['id'];?>">Deletar</a>
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