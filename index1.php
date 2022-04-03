<!DOCTYPE html>
<html lang="pt-br">
<head>
   <?php
      include_once "header.html";
      include_once "conexao.php";
   ?>
    
    <title>Início-Livraria Okinawa</title>
</head>
<body>

    <!--Menu superior-->
        
    <?php
      include_once "menuSuperior.html";
   ?>

    <!--Fim Menu superior-->


    <!--Começo Carrousel-->

    <?php
      include_once "carousel.php";
   ?>

    <!--Fim Carroussel-->
    
    <!--Começo Livros em destaque-->
    <hr>
    <?php
      //include_once "Conteudo home.html";//
      ?>
      <?php
      $sql = "SELECT * FROM vw_retorna_Livros";
         if($res=mysqli_query($con, $sql)){
            $nomelivro = array();
            $codigoBiografia = array();
            $imagemlivro = array();
            $i = 0;

            while($reg=mysqli_fetch_assoc($res)){
               $nomelivro[$i] = $reg['nome_livro'];
               $codigoBiografia[$i] = $reg['biografia_livro'];
               $imagemlivro[$i] = $reg['caminho_imagem'];

               if(!isset($imagemlivro[$i])){
                  $imagemlivro[$i] = "sem_imagem.png";

               }
               ?>

               <div class="col-md-3" style="width: 18rem;">
               <img src="img/Livros/<?php echo $imagemlivro[$i]; ?>" class="img-responsive img-thumbnail" style="max-width: 200px; padding: 5px;" alt="...">
               <div class="card-body">
                  <h5 class="card-title"><?php echo $nomelivro[$i];?></h5>
                  <p class="card-text"><?php echo $codigoBiografia[$i];?></p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
               </div>
               </div>

               <!--<div id="card"></div>
               <div class="col-md-3 itensCadastrados text-center">
                 <div><img src="img/Livros/<?php echo $imagemlivro[$i]; ?>" class="img-responsive img-thumbnail" style="max-width: 200px; padding: 5px;"><br></div>
                  <h3><?php echo $nomelivro[$i];?></h3>
                  <p class="justify text-align"><?php echo $codigoBiografia[$i];?></p>
                  <div class="btn-group" role="group" aria-label="Basic sample">
                  <a href="editalivroAdm.php" class="btn btn-primary w-100">Veja mais!</a>
               </div> -->
                  
               
            
               <?php
               $i++;

            }
         }else{
            echo "Erro ao executar a query!";
         }
      
   ?>
   ?>
     
    <!--Fim Livros em destaque-->

    <!--Começo do rodapé-->

    <?php
      include_once "rodape.html";
   ?>

    <!--Fim do rodapé---->
    </div>

</div>

                  <!--Encerrando conexão com banco-->
      <?php if(isset($con)){ mysqli_close($con); }  ?>
   <!--Fim principal-->
</body>
</html>