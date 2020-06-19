<?php
//Conexão com banco de dados
$servername = 'localhost:3308';
$username = 'root';
$password = "";
$db_name = 'sistemalogin';

$connect = mysqli_connect($servername, $username, $password, $db_name);

//$link = mysqli_connect($servername, $username, $password);
//$db = mysqli_select_db($db_name,$link);
//if(!$link)
//{
//echo "erro ao conectar ao banco de dados!";exit();
//}

//Verificação de possíveis erros

if(mysqli_connect_error()):
	echo "Falha na conexão: " .mysqli_connect_error();
endif;
