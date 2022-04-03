<?php
    include_once "../conexao.php";
    $codigoAugusto = $_GET['excluirUsuario'];

    echo $codigoAugusto;

    $sql = "CALL sp_deleta_usuarios($codigoAugusto,@saida,@saida_rotulo)";
    echo $sql;
    if($res=mysqli_query($con, $sql)){
        $reg=mysqli_fetch_assoc($res);
        $saida = $reg['saida'];
        $rotulo = $reg['saida_rotulo'];
        switch($rotulo){
            case 'Tudo certo!';
             echo 'alert-primary';
            break;

            case 'Ops!';
            echo  'alert-warning';
           break;

           case 'ERRO!';
           echo  'alert-danger';
           break;
       }
    }
?>

