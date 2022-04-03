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
<title>Livros Administração-Livraria Okinawa</title>
</head>
<body class="adm">

    <!--Menu superior-->
        
    <?php
      include_once "menuSuperior.html";
   ?>
    <!--Fim Menu superior-->

 <!--Começo principal-->
    
 <main class="container">
       <h1 class="text-center">Livros-Administração</h1><br>
       <div class="row">
           <div class="col-md-3 col-sm-3">
               <?php include_once "menuAdm.html" ?>
        </div>
           <div class="col-md-9 col-sm-9">
               <?php
                if(isset($_GET['excluirLivro'])){

                    $codigoLivro = $_GET['excluirLivro'];
                    //excluir imagens dos Livros
                    excluirImagens($codigoLivro, "livros");

                        $sql = "CALL sp_deleta_livros($codigoLivro, @saida, @saida_rotulo);";
                        executaQuery($sql, "livrosadm.php");
               
                }elseif(isset($_GET['editaLivro'])){

                  /*Criação de arrays de sessão */
                  $_SESSION['caminho_imagem'] = array();
                  $_SESSION['codigo_imagem'] = array();

               /*Carregar as informações dos Livros*/

               $codigoLivro = $_GET['editaLivro'];
               $_SESSION['codigo_livro'] = $codigoLivro;
               $imagenslivro = array();
               $imagensCodigo = array();

               $sql = "SELECT * FROM vw_retorna_livros WHERE id_livro = $codigoLivro";
               if($res = mysqli_query($con, $sql)){
                  $reg = mysqli_fetch_assoc($res);
                  $nomeLivro = $reg['nome_livro'];
                  $desc = $reg['descricao_livro'];
               
            }else{
                  echo "Algo deu errado ao executar a query!";
               }
               $imagensLivro = array();
               $imagensCodigo = array();
               $i = 0;
               $sql = "SELECT * FROM imagens WHERE id_livro = $codigoLivro";
               if($res = mysqli_query($con, $sql)){
                  while($reg = mysqli_fetch_assoc($res)){
                     $imagensLivro[$i] = $reg['caminho'];
                     $imagensCodigo[$i] = $reg['id_imagens'];

                     $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
                     $_SESSION['codigo_imagem'][$i] = $reg['id_imagens'];
   
                     $i++;
                  }
               }else{
                  echo "Algo deu errado ao executar a query!";
               }
               ?>

               <!--Exibir as informações dos Livros no formulário-->
            <form name="fmLivros" method="post" action="editaLivroAdm.php"  enctype="multipart/form-data" onsubmit="return ValidaCampos()">

            <label>Nome:</label><br>
            <input type="text" name="txtNome" class="form control" maxlength="70" value="<?php echo $nomeLivro; ?>"><br>

            <label>Descrição do livro:</label><br>
            <textarea name="txtDescricao" cols="30" rows="10" max-length="500" placeholder="Pequena descrição do livro(a:)" class="form control"><?php echo $desc;?></textarea>
            <br>
            <label>Imagens dos Livros:</label>
            <div class="row text-center">
               <div class="col-md-3"><strong>Imagem do livro</strong></div>
               <div class="col-md-6"><strong>Carregar uma nova imagem</strong></div>
               <div class="col-md-3"><strong>Excluir imagem atual</strong></div>

               <?php
                  for ($i=0; $i < 3; $i++) {?>
                     <div class="col-md-3">
                     <?php
                     if(isset($imagensLivro[$i])){
                        ?>
                        <img src="../img/livros/<?php echo $imagensLivro[$i]; ?>" title="<?php echo $imagensLivro[$i]; ?>" style="max-width: 100px; padding: 5px;">
                        <?php
                     }else{
                        ?>
                        <img src="../img/livros/sem_imagem.png" title="sem_imagem.png" style="max-width: 100px; padding: 5px;">
                        <?php 

                     }?>
                     <br>
                  </div>
                  <div class="col-md-6">
                     <input type="file" name="<?php echo "fileImagemLivro".$i ?>" class="btn btn-success w-100" accept="IMAGE/png, IMAGE/jpeg">
                  </div>
                  <div class="col-md-3">
                     <input type="checkbox" name="<?php echo "chExcluir".$i ?>" class="w-100">
                  </div>
                  <?php
                  }
               ?>
   </div>
   <button type="submit" name="btnSubmitLivros" class="btn btn-primary w-100">Salvar alterações</button>
   <br><br>
   <div class="row">
      <div class="col-md-6">
      <a href="livrosadm.php" class="btn btn-success  w-100">Voltar</a>
      </div>
      <div class="col-md-6">
      <a href="editaLivroAdm.php?excluirLivro=<?php echo $codigoLivro;?>" class="btn btn-danger w-100" onclick="return confirm('Tem certeza que deseja excluir este livro')">Excluir</a>
      </div>
   </div>
</form>
<br>   
<?php
               
            }elseif(isset($_POST['btnSubmitLivros'])){
               /*
               $_SESSION['caminho_imagem'][$i] = $reg['caminho'];
               $_SESSION['codigo_imagem'][$i] = $reg['id_imagens'];
               */
              $codigoLivro = $_SESSION['codigo_livro'];
              unset($_SESSION['codigo_livro']);

              $nomeImagem = array();
              $codigoImagem = array();

              for($i=0; $i < 3; $i++){

               $nomeImagem[$i] = $_FILES['fileImagemLivro'.$i]['name'];
               $codigoImagem[$i] = "";

               if($nomeImagem[$i] <> "" && isset($_FILES['fileImagemlivro'.$i]['name'])){
                  $nomeImagem[$i] = enviaImagem($_FILES['fileImagemlivro'.$i]['name'], "livros", $_FILES['fileImagemlivro'.$i]['tmp_name']);

               }elseif(isset($_SESSION['caminho_imagem'][$i])){
                  $nomeImagem[$i] = $_SESSION['caminho_imagem'][$i];                  
               }
               
               if(isset($_SESSION['codigo_imagem'][$i])){
                  $codigoImagem[$i] = $_SESSION['codigo_imagem'][$i];                  
               }
            
               if(isset($_SESSION['caminho_imagem'][$i]) && isset($nomeImagem[$i])){
                  if($_SESSION['caminho_imagem'][$i] <> $nomeImagem[$i] ){
                     excluiUmaImagem($codigoImagem[$i], "livros");
                  }
               }
               if(isset($_POST['chExcluir'.$i])){
                  excluiUmaImagem($codigoImagem[$i], "livros");
                  $nomeImagem[$i] = "";
               
               }

              }/*Fim do FOR */

              if(isset($_SESSION['caminho_imagem']) || $_SESSION['codigo_imagem']){
                 unset($_SESSION['caminho_imagem']);
                 unset($_SESSION['codigo_imagem']);
              }

              $nomeLivro = $_POST['txtNome'];
              $desc = $_POST['txtDescricao'];

              $sql = "CALL sp_edita_livro('$codigoLivro','$nomeLivro','$desc','$nomeImagem[0]','$codigoImagem[0]','$nomeImagem[1]','$codigoImagem[1]','$nomeImagem[2]','$codigoImagem[2]',@saida,@saida_rotulo)";
              executaQuery($sql, "livrosadm.php");


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