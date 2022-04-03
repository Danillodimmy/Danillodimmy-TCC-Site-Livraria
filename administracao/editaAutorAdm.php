<!DOCTYPE html>
<html lang="pt-br">
   <?php
   if(!isset($_SESSION['acesso'])){
      session_start();
   }
      if($_SESSION['acesso']==true) {

   ?>
<head>
   <?php
      include_once "header.html";
      include_once "../conexao.php";
      include_once "../mais/funcoes.php";
   ?>

    </script>
<title>Autores Administração-Livraria Okinawa</title>
</head>
<body class="adm">

    <!--Menu superior-->
        
    <?php
      include_once "menuSuperior.html";
   ?>
    <!--Fim Menu superior-->

 <!--Começo principal-->
    
 <main class="container">
       <h1 class="text-center">Autores-Administração</h1><br>
       <div class="row">
           <div class="col-md-3 col-sm-3">
               <?php include_once "menuAdm.html" ?>
        </div>
           <div class="col-md-9 col-sm-9">
               <?php
                if(isset($_GET['excluirAutor'])){

                    $codigoAutor = $_GET['excluirAutor'];
                    //excluir imagens dos autores
                    excluirImagens($codigoAutor, "autores");

                        $sql = "CALL sp_deleta_autores($codigoAutor, @saida, @saida_rotulo);";
                        executaQuery($sql, "autoresAdm.php");
               
                }elseif(isset($_GET['editaAutor'])){

                  /*Criação de arrays de sessão */
                  $_SESSION['caminho_imagem'] = array();
                  $_SESSION['codigo_imagem'] = array();

               /*Carregar as informações dos autores*/

               $codigoAutor = $_GET['editaAutor'];
               $_SESSION['codigo_autor'] = $codigoAutor;
               $imagensAutor = array();
               $imagensCodigo = array();

               $sql = "SELECT * FROM vw_retorna_autores WHERE id_autor = $codigoAutor";
               if($res = mysqli_query($con, $sql)){
                  $reg = mysqli_fetch_assoc($res);
                  $nomeAutor = $reg['nome_autor'];
                  $biografiaAutor = $reg['biografia_autor'];
               
            }else{
                  echo "Algo deu errado ao executar a query!";
               }
               $imagensAutor = array();
               $imagensCodigo = array();
               $i = 0;
               $sql = "SELECT * FROM imagens WHERE autores_codigo = $codigoAutor";
               if($res = mysqli_query($con, $sql)){
                  while($reg = mysqli_fetch_assoc($res)){
                     $imagensAutor[$i] = $reg['caminho'];
                     $imagensCodigo[$i] = $reg['id_imagens'];

                     $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                     $_SESSION['codigo_imagem'][$i] = $reg['id_imagens'];
   
                     $i++;
                  }
               }else{
                  echo "Algo deu errado ao executar a query!";
               }
               ?>

               <!--Exibir as informações dos autores no formulário-->
            <form name="fmAutores" method="post" action="editaAutorAdm.php"  enctype="multipart/form-data" onsubmit="return ValidaCampos()">

            <label>Nome:</label><br>
            <input type="text" name="txtNome" class="form control" maxlength="70" value="<?php echo $nomeAutor; ?>"><br>

            <label>Biografia do autor:</label><br>
            <textarea name="txtBiografia" cols="30" rows="10" max-length="500" placeholder="Pequena descrição do autor(a:)" class="form control"><?php echo $biografiaAutor;?></textarea>
            <br>
            <label>Imagens dos Autores:</label>
            <div class="row text-center">
               <div class="col-md-3"><strong>Imagem do autor/autora</strong></div>
               <div class="col-md-6"><strong>Carregar uma nova imagem</strong></div>
               <div class="col-md-3"><strong>Excluir imagem atual</strong></div>

               <?php
                  for ($i=0; $i < 3; $i++) {?>
                     <div class="col-md-3">
                     <?php
                     if(isset($imagensAutor[$i])){
                        ?>
                        <img src="../img/autores/<?php echo $imagensAutor[$i]; ?>" title="<?php echo $imagensAutor[$i]; ?>" style="max-width: 100px; padding: 5px;">
                        <?php
                     }else{
                        ?>
                        <img src="../img/autores/sem_imagem.png" title="sem_imagem.png" style="max-width: 100px; padding: 5px;">
                        <?php 

                     }?>
                     <br>
                  </div>
                  <div class="col-md-6">
                     <input type="file" name="<?php echo "fileImagemAutor".$i ?>" class="btn btn-success w-100" accept="IMAGE/png, IMAGE/jpeg">
                  </div>
                  <div class="col-md-3">
                     <input type="checkbox" name="<?php echo "chExcluir".$i ?>" class="w-100">
                  </div>
                  <?php
                  }
               ?>
   </div>
   <button type="submit" name="btnSubmitAutores" class="btn btn-primary w-100">Salvar alterações</button>
   <br><br>
   <div class="row">
      <div class="col-md-6">
      <a href="autoresAdm.php" class="btn btn-success  w-100">Voltar</a>
      </div>
      <div class="col-md-6">
      <a href="editaAutorAdm.php?excluirAutor=<?php echo $codigoAutor;?>" class="btn btn-danger w-100" onclick="return confirm('Tem certeza que deseja excluir este(a) Autor/Autora?')">Excluir</a>
      </div>
   </div>
</form>
<br>   
<?php
               
            }elseif(isset($_POST['btnSubmitAutores'])){
               /*
               $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
               $_SESSION['codigo_imagem'][$i] = $reg['id_imagens'];
               */
              $codigoAutor = $_SESSION['codigo_autor'];
              unset($_SESSION['codigo_autor']);

              $nomeImagem = array();
              $codigoImagem = array();

              for($i=0; $i < 3; $i++){

               $nomeImagem[$i] = $_FILES['fileImagemAutor'.$i]['name'];
               $codigoImagem[$i] = "";

               if($nomeImagem[$i] <> "" && isset($_FILES['fileImagemAutor'.$i]['name'])){
                  $nomeImagem[$i] = enviaImagem($_FILES['fileImagemAutor'.$i]['name'], "autores", $_FILES['fileImagemAutor'.$i]['tmp_name']);

               }elseif(isset($_SESSION['caminho_imagem'][$i])){
                  $nomeImagem[$i] = $_SESSION['caminho_imagem'][$i];                  
               }
               
               if(isset($_SESSION['codigo_imagem'][$i])){
                  $codigoImagem[$i] = $_SESSION['codigo_imagem'][$i];                  
               }
            
               if(isset($_SESSION['caminho_imagem'][$i]) && isset($nomeImagem[$i])){
                  if($_SESSION['caminho_imagem'][$i] <> $nomeImagem[$i] ){
                     excluiUmaImagem($codigoImagem[$i], "autores");
                  }
               }
               if(isset($_POST['chExcluir'.$i])){
                  excluiUmaImagem($codigoImagem[$i], "autores");
                  $nomeImagem[$i] = "";
               
               }

              }/*Fim do FOR */

              if(isset($_SESSION['caminho_imagem']) || $_SESSION['codigo_imagem'] ){
                 unset($_SESSION['caminho_imagem']);
                 unset($_SESSION['codigo_imagem']);
              }

              $nomeAutor = $_POST['txtNome'];
              $biografiaAutor = $_POST['txtBiografia'];

              $sql = "CALL sp_edita_autor('$codigoAutor','$nomeAutor','$biografiaAutor','$nomeImagem[0]','$codigoImagem[0]','$nomeImagem[1]','$codigoImagem[1]','$nomeImagem[2]','$codigoImagem[2]',@saida,@saida_rotulo)";
              executaQuery($sql, "autoresAdm.php");


            }else{


                }
      ?>
        <!--Fim principal-->

</div>
   </div>
    </main>
            <!--Encerrando conexão com banco-->
      <?php if(isset($con)){ mysqli_close($con); }  ?>
</body>
<?php
      }else{?>
         <meta http-equiv="refresh" content=0; url="login.php">
<?php
      }
?>
</html>   