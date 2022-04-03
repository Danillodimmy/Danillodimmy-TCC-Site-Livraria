<!DOCTYPE html>
<html lang="pt-br">
<head>
   <?php
      include_once "header.html";
      include_once "../conexao.php";
      include_once "../mais/funcoes.php";
   ?>
    
    
    <script type="text/javascript">
       function ValidaCampos(){
          if (document.fmUsuarios.txtNome.value == ""){
             alert("Por favor, preencha um nome!");
             document.fmUsuarios.txtNome.focus();
             return false;
          }
          if (document.fmUsuarios.txtEmail.value == ""){
             alert("Por favor, preencha um E-mail!");
             document.fmUsuarios.txtEmail.focus();
             return false;
          }
          if (document.fmUsuarios.txtLogin.value == ""){
             alert("Por favor, preencha um login!");
             document.fmUsuarios.txtLogin.focus();
             return false;
          }
          if (document.fmUsuarios.txtSenha1.value == ""){
             alert("Por favor, preencha uma senha!");
             document.fmUsuarios.txtSenha1.focus();
             return false;
          }
          if (document.fmUsuarios.txtSenha2.value == ""){
             alert("Por favor, repita a senha!");
             document.fmUsuarios.txtSenha2.focus();
             return false;
          }
          if (document.fmUsuarios.txtSenha1.value != document.fmUsuarios.txtSenha2.value){
             alert("As senhas devem ser iguais");
             document.fmUsuarios.txtSenha2.focus();
             return false;
          }
       }

    </script>

<title>Usuarios-Administração-Livraria Okinawa</title>
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
           <div class="col-md-3 col-sm-3">
               <?php include_once "menuAdm.html" ?>
        </div>
           <div class="col-md-9 col-sm-9">
               <?php
                  if(isset($_POST['btnSubmitUsuario'])){
                     $nome =  $_POST['txtNome'];
                     $email = $_POST['txtEmail'];
                     $login = $_POST['txtLogin']; 
                     $senha = $_POST['txtSenha1']; 
                     $nivel = $_POST['selNivel']; 
                     $salt = '123';

               $sql = "CALL sp_cadastra_usuario('$nome','$login', '$email', '$senha', '$salt', '$nivel', @saida, @rotulo)";
                     
               executaQuery($sql, "usuariosAdm.php");

                  }else{
               ?>
            
         
         <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Cadastro</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Usuários cadastrados</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <h3>Cadatrar novo usuario:</h3>
            <form name="fmUsuarios" method="post" action="usuariosAdm.php" onsubmit="return ValidaCampos()">

               <label>Nome:</label><br>
               <input type="text" name="txtNome" class="form control" maxlength="70"><br>

               <label>E-mail:</label><br>
               <input type="email" name="txtEmail" class="form control" maxlength="50" aria-describedby="emailHelp"><br>

               <label>Login:</label><br>
               <input type="text" name="txtLogin" class="form control" maxlength="30"><br>

               <label>Senha:</label><br>
               <input type="password" name="txtSenha1" class="form control" maxlength="16"><br>

               <label>Repita a senha:</label><br>
               <input type="password" name="txtSenha2" class="form control" maxlength="16"><br>

               <label>Nivel de Usuário:</label><br>
               <select name="selNivel" class="form-control">
                  <option value="1">1 - Administrador</option>
                  <option value="2">2 - Moderador</option>
               </select><br>
   
            <button type="submit" name="btnSubmitUsuario" class="btn btn-primary w-100">Cadastrar Usuário:</button>
            <br>
            <br>
            <br>
         </form>
      <?php
       }
      ?>
  </div>

 
  
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><h2>Usuários Cadastrados:</h2>
      <div class="row">
         <?php
            $sql = "SELECT * FROM vvw_usuario";
               if($res=mysqli_query($con, $sql)){

                  $nomeUsuario = array();
                  $codigoUsuario = array();
                  $i = 0;

                  while($reg=mysqli_fetch_assoc($res)){
                     $nomeUsuario[$i] = $reg['nome_usuario'];
                     $codigoUsuario[$i] = $reg['id_usuarios'];
                  }
                     ?>
                     <div class="col-md-4 itensCadastrados text-center">
                        <h4><?php echo $nomeUsuario[$i]. " codigo: ".$codigoUsuario[$i]; ?> </h4>
                        <div class="btn-group" role="group" aria-label="Basic sample">
                        <a href="editaUsuarioAdm.php?editaUsuario=<?php echo $codigoUsuario[$i] ?>&nomeUsuario=<?php echo $nomeUsuario[$i] ?>" class="btn btn-primary">Editar</a>
                      <a href="editaUsuarioAdm.php?excluirUsuario=<?php echo $codigoUsuario[$i];?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                     </div><br>
                     </div>
                     
                     <?php
               $i++;
                
                    
                }else{
                   echo "ERRO ao executar a query!";
                }

               ?>
</div>

</div>

</div>
</div>
   </div>
      </main>
     
                  <!--Encerrando conexão com banco-->
      <?php if(isset($con)){ mysqli_close($con); }  ?>
   <!--Fim principal-->
  
</body>
</html>   