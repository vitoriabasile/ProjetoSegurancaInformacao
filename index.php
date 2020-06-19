<?php
include_once 'header.php';
//Conexão com db_connect
require_once 'db_connect.php';
//Sessão
session_start();

//Botão enviar
if(isset($_POST['btn-entrar'])):
	$erros = array();
	$login = mysqli_escape_string($connect, $_POST['login']);
	$senha = mysqli_escape_string($connect, $_POST['senha']);

	
	if(empty($login) or empty($senha)):
		$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'> O campo login/senha precisa ser preenchido! </p>";
	else:
		$sql = "SELECT login FROM usuarios WHERE login = '$login'";
		$resultado = mysqli_query($connect, $sql);
		
		if(mysqli_num_rows($resultado) > 0):
			echo $senha;
			$senha = md5($senha);
			$sql = "SELECT * FROM usuarios WHERE login = '$login' and senha = '$senha'";
			$resultado = mysqli_query($connect, $sql);
			if(mysqli_num_rows($resultado) == 1):
				$dados = mysqli_fetch_array($resultado);
				//mysqli_close($connect);
				$_SESSION['logado'] = true;
				$_SESSION['id_usuario'] = $dados['id'];
				header('Location: redefinirsenha.php');
			else:
				$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'>Usuário e senha não conferem! </p>";
			
			endif;
		else:
			$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'> Uusuário inexistente! </p>";
		endif;
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
             <form name="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <p style="font-size:35; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Login</p>
                <hr>
				<br>
                <div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
				  <input type="text" name="login"  class="form-control" aria-describedby="emailHelp">
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <br>
                <div class="form-group">
                  <label for="exampleInputPassword1">Senha</label>
				  <input type="password" name="senha" class="form-control">
				  <button type="button" class="btn btn-link" style="font-size:12;"><a href="cadastro.php">Cadastre-se</a></button>
                  <button type="button" class="btn btn-link" style="font-size:12;"><a href="esqueceu.php">Esqueceu sua senha</a></button>
                </div>
                <button type="submit" name="btn-entrar" class="btn btn-light">Sign In</button>
              </form>
            </div>
        </div>
<?php
include_once 'footer.php';
?>