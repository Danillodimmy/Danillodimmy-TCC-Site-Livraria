<!DOCTYPE html>
<html lang="pt-br">
<head>
   <?php
      include_once "header.html";
      include_once "../conexao.php";
      include "../mais/funcoes.php";
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
       <h1 class="text-center">Categorias-Administração</h1><br>
       <div class="row">
           <div class="col-md-3 col-sm-3">
               <?php include_once "menuAdm.html" ?>
        </div>
      
        <div class="col-md-9 col-sm-9">
        <?php
                if(isset($_GET['btnSubmitCategoria'])){
                   $nomeCategoria = $_GET['txtCategoria'];
                   $link = $nomeCategoria;
                   $sql = "CALL sp_cadastra_categoria('$nomeCategoria', '$link', @saida, @rotulo);";
                   executaQuery($sql, "categoriasAdm.php");
            
                }else{

                    
            ?>
                <h2 class="text-center">Cadastro de Categorias</h2>
               <form name="fmCategorias" method="get" action="categoriasAdm.php" onsubmit="return validaCampos()">
                   <label>Nome da Categoria</label><br>
                   <input type="text" name="txtCategoria" class="form-control" maxlength="50"><br>
                   <button type="submit" class="btn btn-primary w-100" name="btnSubmitCategoria">Cadastrar</button>
               </form>
               <br>
               <hr>

               <h2 class="text-center">Categorias Cadastradas:</h2>
               <div class="row">
                   <hr>
               <?php
                $sql = 'SELECT * FROM vw_retorna_categorias'; 
                if($res=mysqli_query($con, $sql)){
                    $nomeCategoria = array();
                    $linkCategoria = array();
                    $codigoCategoria = array();
                    $i = 0;
                    while($reg=mysqli_fetch_assoc($res)){
                        $nomeCategoria[$i] = $reg['Nome_Categoria'];
                        $linkCategoria[$i] = $reg['link_Categoria'];
                        $codigoCategoria[$i] = $reg['id_categoria'];

                        
                ?>
                    
                   <div class="col-md-3 intensCadastrados text-center">
                       <h5><?php echo $nomeCategoria[$i]; ?></h5>
                       <div class="btn-group" role="group" arial-label="Basic sample">
                       <a href="editaCategoriaAdm.php?editaCategoria=<?php echo $codigoCategoria[$i] ?>&nomeCategoria=<?php echo $nomeCategoria[$i]; ?>" class="btn btn-primary">Editar</a>
                       <a href="editaCategoriaAdm.php?excluirCategoria=<?php echo $codigoCategoria[$i];?>" class="btn btn-secondary" onClick="return confirm('Tem certeza que deseja excluir essa categoria?')">Excluir</a>
                    </div>
                   </div>
               
              

               <?php
               $i++;
                
                    }
                }
                
                
               ?>
              
                
               <?php
                
                }
            
               ?>
        </div>
    <!--Fim principal-->
    
    <!--Fechando conexão com o banco de dados-->
    <?php if(isset($con)){mysqli_close($con); }  ?>
   
</body>
</html>