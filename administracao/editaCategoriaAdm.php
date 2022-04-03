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
           if(document.fmCategorias.txtCategoria.value == ""){
               alert("Por favor,preencha o nome da categoria.");
               document.fmCategorias.txtCategoria.focus();
               return false;
           }
        }

    </script>
    <title>Categorias-Administração</title>
</head>
<body>

    <!--Menu superior-->
        
    <?php
      include_once "menuSuperior.html";
   ?>

    <!--Fim Menu superior-->

    <!--Começo principal-->
    
    <main class="container">
       <h1 class="text-center">CATEGORIAS-Administração</h1><br>
       <div class="row">
           <div class="col-md-3 col-sm-3">
               <?php include_once "menuAdm.html" ?>
        </div>
      
        <div class="col-md-9 col-sm-9">
        <?php
                if(isset($_GET['excluirCategoria'])){
                    $codigoCategoria = $_GET['excluirCategoria'];
                    $sql = "CALL sp_deleta_categoria('$codigoCategoria', @saida, @rotulo);";
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
                            <a href='categoriasAdm.php' class="alert-link "target='_self'>Voltar</a>
                        </div>
                       <?php
                    }else{
                       echo "Erro ao executar a query";
                   }
                }elseif(isset($_GET['editaCategoria'])){
                    $_SESSION['codigoCategoria'] = $_GET['editaCategoria'];
                    $nomeCategoria = $_GET['nomeCategoria'];
                    ?>

                    
                             <h2 class="text-center">Alteração de Categorias</h2>
                             <form name="fmCategorias" method="get" action="editaCategoriaAdm.php" onsubmit="return validaCampos()">
                                 <label>Nome da Categoria</label><br>
                                 <input type="text" name="txtCategoria" value="<?php echo $nomeCategoria; ?>" class="form-control" maxlength="50"><br>
                                 <button type="submit" class="btn btn-primary w-100" name="btnSubmitCategoria">Alterar Categoria</button>
                             </form>
                             <br>
                      <?php
                }elseif(isset($_GET['btnSubmitCategoria'])){{
                    $nomeCategoria = $_GET['txtCategoria'];
                    $codigoCategoria = $_SESSION['codigoCategoria'];
                    unset($_SESSION['codigoCategoria']);
                    $sql = "CALL sp_edita_categoria($codigoCategoria,'$nomeCategoria', @saida, @rotulo);";
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
                            
                            <a href='categoriasAdm.php' class="alert-link "target='_self'>Voltar</a>

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