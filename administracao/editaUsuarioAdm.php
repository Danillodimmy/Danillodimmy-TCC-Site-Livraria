<!DOCTYPE html>
<?php
    if(!isset($_SESSION)){
        session_start();
    }
?>
<html lang="pt-br">
<head>
   <?php
      include_once "header.html";
      include_once "../conexao.php";
   ?>
    <script type="text/javascript">
        function validaCampos(){
           if(document.fmUsuarios.txtUsuario.value == ""){
               alert("Por favor,preencha o nome da usuario.");
               document.fmUsuarios.txtUsuario.focus();
               return false;
           }
        }

    </script>
    <title>Usuarios-Administração</title>
</head>
<body>

    <!--Menu superior-->
        
    <?php
      include_once "menuSuperior.html";
   ?>

    <!--Fim Menu superior-->

    <!--Começo principal-->
    
    <main class="container">
       <h1 class="text-center">Usuarios-Administração</h1><br>
       <div class="row">
           <div class="col-md-3 col-sm-3">
               <?php include_once "menuAdm.html" ?>
        </div>
      
        <div class="col-md-9 col-sm-9">
        <?php
                if(isset($_GET['excluirUsuario'])){
                    $codigoUsuario = $_GET['excluirUsuario'];
                    $sql = "CALL sp_deleta_usuarios('$codigoUsuario', @saida, @rotulo);";
                    if($res=mysqli_query($con, $sql)){
                       $reg=mysqli_fetch_assoc($res);
                       $saida = $reg['saida'];
                       $rotulo = $reg['saida_rotulo'];
                       switch($rotulo){
                           case 'Tudo certo!';
                            $alert = 'alert-primary';
                           break;

                           case 'Ops!';
                           $alert = 'alert-warning';
                          break;

                          case 'ERRO!';
                          $alert = 'alert-danger';
                          break;
                       }
                       ?>

                        
                        <div class="<?php echo $alert; ?>" role="alert">
                            <h3><?php echo $rotulo; ?></h3>
                            <?php echo $saida; ?>
                            <br>
                            <a href='usuariosAdm.php' class="alert-link" target='_self'>Voltar</a>
                        </div>
                       <?php
                    }else{
                       echo "Erro ao executar a query";
                   }
    
                }if(isset($_GET['editaUsuario'])){
                    $_SESSION['codigoUsuario'] = $_GET['editaUsuario'];
                    $nomeUsuario = $_GET['nomeUsuario'];
                    ?>

                    
                             <h2 class="text-center">Alteração de usuarios</h2>
                             <form name="fmUsuarios" method="get" action="editaUsuarioAdm.php" onsubmit="return validaCampos()">
                                 <label>Nome da usuarios</label><br>
                                 <input type="text" name="txtUsuario" value="<?php echo $nomeUsuario; ?>" class="form-control" maxlength="50"><br>
                                 <button type="submit" class="btn btn-primary w-100" name="btnSubmitUsuario">Alterar usuario</button>
                             </form>
                             <br>
                      
                      <?php
                }elseif(isset($_GET['btnSubmitUsuario'])){{
                    $nomeUsuario = $_GET['txtUsuario'];
                    $codigoUsuario = $_SESSION['codigoUsuario'];
                    unset($_SESSION['codigoUsuario']);
                    $sql = "CALL sp_edita_usuario($codigoUsuario,'$nomeUsuario', @saida, @rotulo);";
                   if($res=mysqli_query($con, $sql)){
                       $reg=mysqli_fetch_assoc($res);
                       $saida = $reg['saida'];
                       $rotulo = $reg['saida_rotulo'];
                       switch($rotulo){
                           case 'Tudo certo!';
                            $alert = 'alert-primary';
                           break;

                           case 'Ops!';
                           $alert = 'alert-warning';
                          break;

                          case 'ERRO!';
                          $alert = 'alert-danger';
                          break;
                       }
                       ?>
                        
                        <div class="<?php echo $alert; ?>" role="alert">
                            <h3><?php echo $rotulo; ?></h3>
                            <?php echo $saida; ?><br>
                            
                            <a href='usuariosAdm.php' class="alert-link "target='_self'>Voltar</a>

                        </div>
                       <?php
                       
                    }else{
                        echo "Erro ao executar a query";
                    }
                }
            }
            
            ?>
        </div>
        </div>
    <!--Fim principal-->
    
    <!--Fechando conexão com o banco de dados-->
    <?php if(isset($con)){mysqli_close($con); }  ?>
   
</body>
</html>