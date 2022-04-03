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
   
   <title>Autores Administração-Livraria Okinawa</title>
   <script type="text/javascript">
       function ValidaCampos(){
          if (document.fmAutores.txtNome.value == ""){
             alert("Por favor, preencha um nome!");
             document.fmAutores.txtNome.focus();
             return false;
          }

          if (document.fmAutores.txtBiografia.value == ""){
             alert("Por favor, preencha uma Biografia!");
             document.fmAutores.txtBiografia.focus();
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
       <h1 class="text-center">Autores-Administração</h1><br>
       <div class="row">
           <div class="col-md-3 col-sm-3">
               <?php include_once "menuAdm.html" ?>
        </div>
           <div class="col-md-9 col-sm-9">

            <?php
               if (isset($_POST['btnSubmitAutores'])){

                  $nomeImagem1 = $_FILES['imagem_autor1']['name'];
                  $nomeImagem2 = $_FILES['imagem_autor2']['name'];
                  $nomeImagem3 = $_FILES['imagem_autor3']['name'];

               if ($nomeImagem1 <> "" && isset($_FILES['imagem_autor1']['name'])){
                  $nomeImagem1 = enviaImagem($_FILES['imagem_autor1']['name'], "autores", $_FILES['imagem_autor1']['tmp_name']);
               }else{
                  $nomeImagem1 = "";
               }

               if($nomeImagem2 <> "" && isset($_FILES['imagem_autor2']['name'])){
                  $nomeImagem2 = enviaImagem($_FILES['imagem_autor2']['name'], "autores", $_FILES['imagem_autor2']['tmp_name']);
               }else{
                  $nomeImagem2 = "";
               }

               if($nomeImagem3 <> "" && isset($_FILES['imagem_autor3']['name'])){
                  $nomeImagem3 = enviaImagem($_FILES['imagem_autor3']['name'], "autores", $_FILES['imagem_autor3']['tmp_name']);
               }else{
                  $nomeImagem3 = "";
               }
  
            

               $nome = $_POST['txtNome'];
               $bio = $_POST['txtBiografia'];

               $sql = "CALL sp_cadastra_autores('$nome',' $bio', '$nomeImagem1', '$nomeImagem2', '$nomeImagem3', @saida, @saida_rotulo)";

               executaQuery($sql, "autoresAdm.php");

               
               }else{
            ?>
                      
   <ul class="nav nav-tabs" id="myTab" role="tablist">
   <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Cadastro</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Autores cadastrados</button>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <h3 clas="text-center">Cadatrar novos Autores:</h3>
            <form name="fmAutores" method="post" action="autoresAdm.php"  enctype="multipart/form-data" onsubmit="return ValidaCampos()">

               <label>Nome:</label><br>
               <input type="text" name="txtNome" class="form control" maxlength="70"><br>

               <label>Biografia do autor:</label><br>
               <textarea name="txtBiografia" cols="30" rows="10" max-length="500" placeholder="Pequena descrição do autor(a:)" class="form control"></textarea>
               <br>
               <label>Imagens dos Autores:</label><br>
               <input type="file" name="imagem_autor1" class="btn btn-success w-100" maxlength="30" accept="IMAGE/png, IMAGE/jpeg">
               <br><br>
               <input type="file" name="imagem_autor2" class="btn btn-success w-100" maxlength="30" accept="IMAGE/png, IMAGE/jpeg">
               <br><br>
               <input type="file" name="imagem_autor3" class="btn btn-success w-100" maxlength="30" accept="IMAGE/png, IMAGE/jpeg"><br>
               <br>
            <button type="submit" name="btnSubmitAutores" class="btn btn-primary w-100">Cadastrar </button>
            <br>
            <br>
     
         </form>
           <?php
               }
         ?>
        </div>
        
            <br>
         <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><h2>Autores Cadastrados:</h2>
      <div class="row">
         <?php
            $sql = "SELECT * FROM vw_retorna_autores";
               if($res=mysqli_query($con, $sql)){
                  $nomeAutor = array();
                  $codigoAutor = array();
                  $imagemAutor = array();
                  $i = 0;

                  while($reg=mysqli_fetch_assoc($res)){
                     $nomeAutor[$i] = $reg['nome_autor'];
                     $codigoAutor[$i] = $reg['id_autor'];
                     $imagemAutor[$i] = $reg['caminho_imagem'];

                     if(!isset($imagemAutor[$i])){
                        $imagemAutor[$i] = "sem_imagem.png";

                     }
                     ?>
                     <div class="col-md-4 itensCadastrados text-center">
                       <img src="../img/autores/<?php echo $imagemAutor[$i]; ?>" class="img-responsive img-thumbnail"> 
                        <h4><?php echo $nomeAutor[$i]. " codigo: ".$codigoAutor[$i]; ?> </h4>
                        <div class="btn-group" role="group" aria-label="Basic sample">
                           <a href="editaAutorAdm.php?editaAutor=<?php echo $codigoAutor[$i]; ?>&nomeAutor=<?php echo $nomeAutor[$i];?>" class="btn btn-primary">Editar</a>
                           <a href="editaAutorAdm.php?excluirAutor=<?php echo $codigoAutor[$i];?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir este(a) Autor/Autora?')">Excluir</a>
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