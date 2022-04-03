<!DOCTYPE html>
<html lang="pt-br">
<?php
      if(!isset($_SESSION)){
         session_start();
      }
      if($_SESSION['acesso'] == true){

      
   ?>
<head>
   <?php
      include_once "header.html";
   ?>
    
    <title>Administração-Livraria Okinawa</title>
</head>
<body class="adm">

    <!--Menu superior-->
        
    <?php
      include_once "menuSuperior.html";
   ?>
    <!--Fim Menu superior-->

    <!--Começo principal-->
    <main class="container text-center">
       <h1>Administração</h1>
       <br>
       <div class="row text-center">

         <div class="col-md-3 opcoes">
            <a href="administracao/livrosadm.php">
            <span class="material-icons">library_books</span>
            <p>Cadastrar livro</p>
         </a>
         </div>
      
         <div class="col-md-3 opcoes">
            <a href="#">
            <span class="material-icons">description</span>
            <p>Livros Cadastrados</p>
         </a>
         </div>

         <div class="col-md-3 opcoes">
            <a href="administracao/autoresAdm.php">
            <span class="material-icons">perm_identity</span>
            <p>Autores</p>
         </a>
         </div>

         <div class="col-md-3 opcoes">
            <a href="administracao/categoriasAdm.php">
            <span class="material-icons">menu</span>
            <p>Categorias</p>
         </a>
         </div>
         

         <div class="col-md-3 opcoes">
            <a href="#">
            <span class="material-icons">text_snippet</span>
            <p>Banner principal</p>
         </a>
         </div>
         

         <div class="col-md-3 opcoes">
            <a href="usuariosAdm.php">
            <span class="material-icons">group</span>
            <p>Usuários</p>
         </a>
         </div>

         <div class="col-md-3 opcoes">
            <a href="#">
            <span class="material-icons">manage_accounts</span>
            <p>Minha Conta</p>
         </a>
         </div>

         <div class="col-md-3 opcoes">
            <a href="administracao/logoff.php">
            <span class="material-icons">logout</span>
            <p>Sair</p>
         </a>
         </div>

       </div>

    </main>

    <!--Fim principal-->
</body>
<?php
      }else{
         ?>
         <meta http-equiv="refresh" content=0;url="administracao/login.php">
         <?php
      }
?>
</html>