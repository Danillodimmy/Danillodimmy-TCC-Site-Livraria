<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta-Administração</title>
    <?php
    if(!isset($_SESSION)){
        session_start();
    }

?>
</head>
<?php
    include_once "../conexao.php";
    ?>
<body>
    



<!---Encerrando a conexão com o banco de dados banco_liv -->
<?php if (isset($con)) { mysqli_close($con); } ?>

</body>
</html>