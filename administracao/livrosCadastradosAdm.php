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

          if (document.fmLivros.txtdescricao.value == ""){
             alert("Por favor, preencha uma descrição!");
             document.fmLivros.txtdescricao.focus();
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

                     if(!isset($imagemlivro[$i])){
                        $imagemLivro[$i] = "sem_imagem.png";

                     }
                     ?>
                     <div class="col-md-4 itensCadastrados text-center">
                       <img src="../img/Livros/<?php echo $imagemLivro[$i]; ?>" class="img-responsive img-thumbnail"> 
                        <h4><?php echo $nomeLivro[$i]. " codigo: ".$codigoLivro[$i]; ?> </h4>
                        <div class="btn-group" role="group" aria-label="Basic sample">
                           <a href="editalivroAdm.php?editalivro=<?php echo $codigoLivro[$i]; ?>&nomelivro=<?php echo $nomeLivro[$i];?>" class="btn btn-primary">Editar</a>
                           <a href="editalivroAdm.php?excluirlivro=<?php echo $codigoLivro[$i];?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir este(a) livro/livroa?')">Excluir</a>
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