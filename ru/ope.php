<?php 
// session_start inicia a sessão
session_start();
// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$senha = md5($_POST['senha']);
require_once 'config.php';
// A vriavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
$result = mysql_query("SELECT * FROM `usuarios` WHERE `matricula` = '$login' AND `senha`= '$senha'");


/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
if(mysql_num_rows ($result) > 0 )
{
$row = mysql_fetch_assoc($result);
$_SESSION['matricula'] = $login;
$_SESSION['nome'] =$row['nome'] ;
header('location:agendamento.php');

}
else{
	unset ($_SESSION['matricula']);
	unset ($_SESSION['nome']);
	header('location:login.php?error=true');

	}

?>
