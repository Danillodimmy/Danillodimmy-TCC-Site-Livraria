    <?php
    // Função para criar imagens
    function enviaImagem($imagem, $caminho, $imagemTemp){
        $extensao = pathinfo($imagem, PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);

        if(strstr('.jpg;.jpeg;.png', $extensao)){
            $imagem = $caminho.mt_rand().".".$extensao;

            $diretorio = "../img/".$caminho."/";
            //../imagens/teste
            move_uploaded_file($imagemTemp, $diretorio.$imagem);
        }else{ ?>
            <div class="alert alert-danger" role="alert">
                Você poderá enviar apenas imagens do tipo *.jpeg,*.jpg e *.png!
        
           </div> <br><br>
    
        <?php
    }
    return $imagem;
    }
?>

<?php
    /* Fuções para executar as querys e retornar as mensagens de saída*/

    function executaQuery($sql, $paginaDeRetorno){
    include "../conexao.php";
    if($res = mysqli_query($con, $sql)){
    $reg=mysqli_fetch_assoc($res);
    $saida = $reg['saida'];
    $rotulo = $reg['saida_rotulo'];
    switch($rotulo){
        case 'Tudo certo!';
            $alert = 'alert-primary';
        break;

        case 'Ops!';
        $alert = 'alert-warning';
        break;

        case 'ERRO!';
        $alert = 'alert-danger';
        break;
    }
    ?>
        
        <div class="<?php echo $alert; ?>" role="alert">
            <h3><?php echo $rotulo; ?></h3>
            <?php echo $saida; ?><br>
            
            <a href="<?php echo $paginaDeRetorno;?>" class="alert-link "target='_self'>Voltar</a>

     </div>   
   <?php

    }else{
    echo "Erro ao executar a query.";
    }


    /*Encerrando conexão com banco*/
     if(isset($con)){ mysqli_close($con); }  

    }


    /*Função para excluir imagens de livro/diretor/livro/banner */

    function excluirImagens($codigo, $alvo){
        include "../conexao.php";

        //$imagens = array();
        $linhas = 0;
        $where = $alvo."_codigo";

        $sql = "SELECT * FROM imagens WHERE ".$where." = $codigo";
        if($res = mysqli_query($con, $sql)){
            $linhas = mysqli_affected_rows($con);
            if ($linhas > 0){
                while($reg = mysqli_fetch_assoc($res)){

                    $delete = unlink("../img/".$alvo."/".$reg["caminho"]);
                    if(!$delete){
                        ?>
    <div class="alert danger" role="alert">
            <h3>Erro!</h3>
            <p>Algo deu errado ao excluir a imagem:<?php $reg["caminho"]; ?></p>
            <br>
     </div>   
      <?php

                    }

                }

            }

        }else{ ?>
    <div class="alert danger" role="alert">
     <h3>Erro!</h3>
      <p>Algo deu errado executar a query!</p>
            <br>
     </div>
     <?php  
        }


   /*Encerrando conexão com banco*/
   if(isset($con)){ mysqli_close($con); }  

}

   /*Função para excluir uma imagem de livro/diretor/livro/banner */

   function excluiUmaImagem($codigo, $alvo){
    include "../conexao.php";
    $sql = "SELECT * FROM imagens WHERE id_imagens = ".$codigo;
    if($res = mysqli_query($con, $sql)){
            while($reg = mysqli_fetch_assoc($res)){

                $delete = unlink("../img/".$alvo."/".$reg["caminho"]);
                if(!$delete){
                    ?>
<div class="alert danger" role="alert">
        <h3>Erro!</h3>
        <p>Algo deu errado ao excluir a imagem:<?php $reg["caminho"]; ?></p>
        <br>
 </div>   
  <?php

                }


        }

    }else{ ?>
<div class="alert danger" role="alert">
 <h3>Erro!</h3>
  <p>Algo deu errado executar a query!</p>
        <br>
 </div>
 <?php  
    }


/*Encerrando conexão com banco*/
if(isset($con)){ mysqli_close($con); }  

}

   
    ?>


    

