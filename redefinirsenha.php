<?php
include_once 'header.php';
//Conexão com db_connect
require_once 'db_connect.php';
//Sessão
session_start();
 function senhaValida($senhanova) {
	    $opc = false;
        $opc = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[\w$@]{6,}$/', $senhanova);
		return $opc;
	}
//Botão enviar
if(isset($_POST['btn-entrar'])):
	$erros = array();
	$login = mysqli_escape_string($connect, $_POST['login']);
	$senha = mysqli_escape_string($connect, $_POST['senha']);
	$senhanova = mysqli_escape_string($connect, $_POST['senhanova']);
	$senhanovac = mysqli_escape_string($connect, $_POST['senhanovac']);

	
	if(empty($login) or empty($senha) or empty($senhanova) or empty($senhanovac)):
		$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'> Os campos precisam ser preenchidos! </p>";
	else:
		$sql = "SELECT login FROM usuarios WHERE login = '$login'";
		$resultado = mysqli_query($connect, $sql);
		
		if(mysqli_num_rows($resultado) > 0):

			$senha = md5($senha);
			$sql = "SELECT * FROM usuarios WHERE login = '$login' and senha = '$senha'";
			$resultado = mysqli_query($connect, $sql);
			if(mysqli_num_rows($resultado) == 1 ):				
			  if($senhanova == $senhanovac):
			   $valida = senhaValida($senhanova);
				if($valida == true):
				$dados = mysqli_fetch_array($resultado);
				$senhanova = md5($senhanova);
				$sql = "UPDATE usuarios SET senha = '$senhanova' WHERE  login = '$login'";				
				$resultado = mysqli_query($connect, $sql);
				$_SESSION['logado'] = true;
				$_SESSION['id_usuario'] = $dados['id'];
				else:
				$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:500px;height:38px;'> A senha deve conter 6 caracteres, letras minúsculas e maiúsculas! </p>";
				endif;
			  else:
			  $erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'>Senhas não conferem! </p>";
			  endif;
			else:
			$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'> Usuário e senha não conferem! </p>";
			
			endif;
		else:
			$erros[] = "<p style='border:solid;border-radius:10px;border-color:lightblue;width:335px;height:38px;'> Usuário inexistente! </p>";
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
                <p style="font-size:35; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Olá crie uma nova senha!</p>
                <hr>
				<br>
				 <div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
				  <input type="text" name="login"  class="form-control" aria-describedby="emailHelp">
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Senha atual</label>
				  <input type="password" name="senha" class="form-control">
                </div>
				
                <div class="form-group">
                  <label for="exampleInputPassword1">Nova senha</label>
				  <input type="password" name="senhanova" class="form-control">
                </div>
				
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirme a nova senha</label>
				  <input type="password" name="senhanovac" class="form-control">
                </div>
                <button type="submit" name="btn-entrar" class="btn btn-light">Enviar</button>
              </form>
            </div>
        </div>
<button type="submit" name="btn-sair" class="btn btn-light"><a href="logout.php">Sair</a></button>


<?php
include_once 'footer.php';
?>