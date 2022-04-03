<!DOCTYPE html>
<html lang="pt-br">
   <?php
      if(!isset($_SESSION)){
         session_start();
      }
      if(isset($_SESSION['acesso'])){
         ?>
         <center><h2>A sessão já está aberta</h2>
            <br>
            <br>
            <h4>Você está sendo redirecionado para página de Administração.</h4>
      </center>
         <meta http-equiv="refresh" content=2;url="../adm.php>
         <?php
      }else{

      
   ?>
<head>
   <?php
      include_once "header.html";
      include_once "../conexao.php";
   ?>
    
    <title>Usuarios-Administração-Livraria Okinawa</title>
    <script type="text/javascript">
       function ValidaCampos(){
          if (document.fmLogin.txtLogin.value == ""){
             alert("Por favor, preencha o seu login!");
             document.fmlogin.txtLogin.focus();
             return false;
          }
          if (document.fmLogin.txtSenha.value == ""){
             alert("Por favor, preencha a sua senha!");
             document.fmLogin.txtSenha.focus();
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
       <h1 class="text-center">Usuários-Administração</h1><br>
       <div class="row">
           <div class="col-md-7 col-sm-7">
               <img src="../img/img header/logo3.jpg" class="w-100" alt="Imagem do logo da pagina da pagina de login" >
               
        </div>
           <div class="col-md-5 col-sm-5">
              <?php
               if(isset($_POST['btnSubmitLogin'])){
                  $usuario = $_POST['txtLogin'];
                  $senha = $_POST['txtSenha'];
                  $sql = "SELECT login, senha FROM usuarios where login = '$usuario' and senha = '$senha'";
                  if($res=mysqli_query($con, $sql)){
                     $linhas = mysqli_affected_rows($con);
                     if($linhas > 0){
                        $_SESSION['acesso'] = true;

                        ?>
                          <div class="alert alert-sucess" role="alert">
                             <h2 class="text-center">Login efetuado com sucesso</h2>
                             <br>
                        </div>
                        <meta http-equiv="refresh" content=2;url="../adm.php">
                        <?php
                     }else{ ?>
                        <div class="alert alert-danger" role="alert">
                             <h2 class="text-center">Usuario ou senha invalida!</h2>
                             <br><br>
                             <a href='login.php' class="alert-link "target='_self'>Voltar</a>
                        </div>
                        <?php
                     }
                  }else{
                     echo "<h3>Erro ao executar a Query!</h3>";
                  }

               }else{
              ?>
               <form name="fmLogin" method="post" action="login.php" onsubmit="return ValidaCampos();">
                    <h2 class="text-center">Insira o seu Login e Senha:</h2>
                    <input type="text" name="txtLogin" placeholder="insira o seu login aqui" class="form-control text-center"><br><br>
                    <input type="password" name="txtSenha" placeholder="insira a sua senha aqui" class="form-control text-center"><br><br>
            
            
            <button type="submit" name="btnSubmitLogin" class="btn btn-primary w-100">Entrar</button>
         </form>
         <?php
               }
         ?>
        </div>
        </div>
      </main>
                  <!--Encerrando conexão com banco-->
      <?php if(isset($con)){ mysqli_close($con); }  ?>
   <!--Fim principal-->
  
</body>
<?php
}
?>
</html>
        