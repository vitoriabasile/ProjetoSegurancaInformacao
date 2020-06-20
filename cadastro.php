<?php
include_once 'header.php';

//$senha
//$senha_db = "auhfiuahfakhfuashf"
//if(password_verify($senha, $senha_db)):
//echo "Senha valida";
//$senhaHash = password_hash(%senha, PASSWORD_DEFAULT);
//Conexão com db_connect
require_once 'db_connect.php';
//Sessão
session_start();
//Botão enviar
if(isset($_POST['btn-entrar'])):
	$erros = array();
	$tamanho = 0;
	$login = mysqli_escape_string($connect, $_POST['login']);
	$nome = mysqli_escape_string($connect, $_POST['nome']);
	
	if(empty($login) or empty($nome)):
		$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'> O campo login/nome precisa ser preenchido! </p>";
	else:
//Gerando senha aleatória
 
	function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
  $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
  $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
  $nu = "0123456789"; // $nu contem os números
  //$si = "!@#$%¨&*()_+="; // $si contem os símbolos
  $sprovisoria = '';
  $senhaHash = '';
  if ($maiusculas){
        // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
        $sprovisoria .= str_shuffle($ma);
  }
 
    if ($minusculas){
        // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
        $sprovisoria .= str_shuffle($mi);
    }
 
    if ($numeros){
        // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
        $sprovisoria .= str_shuffle($nu);
    }
 
    //if ($simbolos){
    //    // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
    //    $sprovisoria .= str_shuffle($si);
    //}
	
	//$senhaHash = password_hash($sprovisoria, PASSWORD_DEFAULT);
    
    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
    return substr(str_shuffle($sprovisoria),0,$tamanho);
	
	
	}
    $senha = gerar_senha(6, true, true, true, true);
	echo "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'> Sua senha é: $senha</p>"; 
	$senha = md5($senha);
	$sql = "INSERT INTO usuarios (login, nome, senha)VALUE('$login','$nome','$senha')";
	$resultado = mysqli_query($connect, $sql);
	
	
	header("refresh: 10;index.php");
	endif;
endif;
?>

<?php
if(!empty($erros)):
	foreach($erros as $erro):
		echo $erro;
	endforeach;
endif;
?>
        <div class="container">
           <div class="content">
             <form name="login" onsubmit="return logina();" method="post">
                <p style="font-size:35; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Register</p>
                <hr>
				<br>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
				  <input type="text" name="login" class="form-control" aria-describedby="emailHelp">
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <br>
                <div class="form-group">
                  <label for="exampleInputPassword1">Name</label>
				  <input type="name" name="nome" class="form-control">
                </div>
                <button type="submit" name="btn-entrar" class="btn btn-light">Sign In</button>
              </form>
            </div>
        </div>

<?php
include_once 'footer.php';
?>