<?php

//conexao com o banco de dados livraria

$host = "localhost";
$user = "root";
$pass = "";
$base ="banco_liv";

//Fazendo a conexão com o banco de dados
$con = mysqli_connect($host, $user, $pass);
$banco = mysqli_select_db($con, $base);

//Mensagem de falha de conexão
if(mysqli_connect_errno()){
    die("Falha de conexão com banco de dados: ".
    mysqli_connect_errno() . "(" . mysqli_connect_errno() . ")"
);
}
//configuração de caracteres

mysqli_query($con, "SET NAMES 'utf8'");
mysqli_query($con, "SET caracter_set_connection=utf8");
mysqli_query($con, "SET caracter_set_client=utf8");
mysqli_query($con, "SET caracter_set_result=utf8");

?>