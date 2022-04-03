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
   
   <title>Livros Administração-Livraria Okinawa</title>
   <script type="text/javascript">
       function ValidaCampos(){
          if (document.fmLivros.txtNome.value == ""){
             alert("Por favor, preencha um nome!");
             document.fmLivros.txtNome.focus();
             return false;
          }

          if (document.fmLivros.txtDescricao.value == ""){
             alert("Por favor, preencha uma descrição!");
             document.fmLivros.txtDescricao.focus();
             return false;
          }
       }

    </script>

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
               if (isset($_POST['btnSubmitLivros'])){

                  $nomeImagem1 = $_FILES['imagem_livro1']['name'];
                  $nomeImagem2 = $_FILES['imagem_livro2']['name'];
                  $nomeImagem3 = $_FILES['imagem_livro3']['name'];

               if ($nomeImagem1 <> "" && isset($_FILES['imagem_livro1']['name'])){
                  $nomeImagem1 = enviaImagem($_FILES['imagem_livro1']['name'], "livros", $_FILES['imagem_livro1']['tmp_name']);
               }else{
                  $nomeImagem1 = "";
               }

               if($nomeImagem2 <> "" && isset($_FILES['imagem_livro2']['name'])){
                  $nomeImagem2 = enviaImagem($_FILES['imagem_livro2']['name'], "livros", $_FILES['imagem_livro2']['tmp_name']);
               }else{
                  $nomeImagem2 = "";
               }

               if($nomeImagem3 <> "" && isset($_FILES['imagem_livro3']['name'])){
                  $nomeImagem3 = enviaImagem($_FILES['imagem_livro3']['name'], "livros", $_FILES['imagem_livro3']['tmp_name']);
               }else{
                  $nomeImagem3 = "";
               }
  
            

               $nome = $_POST['txtNome'];
               $desc = $_POST['txtDescricao'];

               $sql = "CALL sp_cadastra_livros('$nome',' $desc', '$nomeImagem1', '$nomeImagem2', '$nomeImagem3', @saida, @saida_rotulo)";

               executaQuery($sql, "livrosadm.php");

               
               }else{
            ?>
                      
   <ul class="nav nav-tabs" id="myTab" role="tablist">
   <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Cadastro</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Livros cadastrados</button>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <h3 clas="text-center">Cadatrar novos Livros:</h3>
            <form name="fmLivros" method="post" action="livrosadm.php"  enctype="multipart/form-data" onsubmit="return ValidaCampos()">

               <label>Nome:</label><br>
               <input type="text" name="txtNome" class="form control" maxlength="70"><br>

               <label>Descrição do livro:</label><br>
               <textarea name="txtDescricao" cols="30" rows="10" max-length="500" placeholder="Pequena descrição do livro(a:)" class="form control"></textarea>
               <br>
               <label>Imagens dos livros:</label><br>
               <input type="file" name="imagem_livro1" class="btn btn-success w-100" maxlength="30" accept="IMAGE/png, IMAGE/jpeg">
               <br><br>
               <input type="file" name="imagem_livro2" class="btn btn-success w-100" maxlength="30" accept="IMAGE/png, IMAGE/jpeg">
               <br><br>
               <input type="file" name="imagem_livro3" class="btn btn-success w-100" maxlength="30" accept="IMAGE/png, IMAGE/jpeg"><br>
               <br>
            <button type="submit" name="btnSubmitLivros" class="btn btn-primary w-100">Cadastrar </button>
            <br>
            <br>
     
         </form>
           <?php
               }
         ?>
        </div>
        
            <br>
         <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><h2>Livros Cadastrados:</h2>
      <div class="row">
         <?php
            $sql = "SELECT * FROM vw_retorna_livros";
               if($res=mysqli_query($con, $sql)){
                  $nomeLivro = array();
                  $codigoLivro = array();
                  $imagemLivro = array();
                  $i = 0;

                  while($reg=mysqli_fetch_assoc($res)){
                     $nomeLivro[$i] = $reg['nome_livro'];
                     $codigoLivro[$i] = $reg['id_livro'];
                     $imagemLivro[$i] = $reg['caminho_imagem'];

                     if(!isset($imagemLivro[$i])){
                        $imagemLivro[$i] = "sem_imagem.png";

                     }
                     ?>
                     <div class="col-md-4 itensCadastrados text-center">
                       <img src="../img/livros/<?php echo $imagemLivro[$i]; ?>" class="img-responsive img-thumbnail"> 
                        <h4><?php echo $nomeLivro[$i]. " codigo: ".$codigoLivro[$i]; ?> </h4>
                        <div class="btn-group" role="group" aria-label="Basic sample">
                           <a href="editaLivroAdm.php?editaLivro=<?php echo $codigoLivro[$i] ?>&nomeLivro=<?php echo $nomeLivro[$i];?>" class="btn btn-primary">Editar</a>
                           <a href="editaLivroAdm.php?excluirLivro=<?php echo $codigoLivro[$i];?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir este(a) livro?')">Excluir</a>
                        </div>
                     
                     </div>
                     <?php
                     $i++;

                  }
               }else{
                  echo "Erro ao executar a query!";
               }
            
         ?>

</div>

</div>

</div>
</div>
   </div>
    </main>
 
     <?php
      }
     ?>
                  <!--Encerrando conexão com banco-->
      <?php if(isset($con)){ mysqli_close($con); }  ?>
   <!--Fim principal-->

</body>
</html