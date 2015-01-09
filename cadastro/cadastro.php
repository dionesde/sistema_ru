<?php
header('Content-Type: text/html; charset=utf-8');

session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
		{
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location:login.html');
        }

$logado = $_SESSION['login'];

$con = mysql_connect("127.0.0.1", "root", "ufsmcs") or die ("Sem conexão com o servidor");
$select = mysql_select_db("rede") or die("Sem acesso ao DB, Entre em contato com o Administrador, gilson_sales@bytecode.com.br");
$mac=strtolower($_POST['mac']);
$ip=$_POST['ip'];
$host=strtoupper($_POST['host']);
$resp=$_POST['reponsavel'];
$locacao =$_POST['locacao'];
$privado=$_POST['privado'];
$id=$_GET['id'];
	if($privado == 'on')
	{
		$privado=1;
	}
	else
	{
		$privado=0;
	}

	if($_GET['excluir'])
	{
		$sql=" DELETE FROM `rede`.`maquina` WHERE `maquina`.`id` =".$_GET['id'];
		
	}
	elseif($_GET['editar'])
	{

		$sql="UPDATE rede.maquina SET mac = '$mac', ip = '$ip' , host = '$host' , responsavel = '$resp' ,privado = '$privado',locacao= '$locacao'  WHERE id = $id";
		echo $sql;		
	}
	else
	{
		
	
	    $sql="INSERT INTO `rede`.`maquina` (`id`, `host`, `mac`, `responsavel`,`locacao`, `ip`, `privado`,`status`) VALUES (NULL, '$host', '$mac', '$resp','$locacao', '$ip','$privado', '1');";
	}

	if($_GET['mac']){
		$mac=$_GET['mac'];
		 $result = mysql_query("SELECT * FROM `maquina` WHERE `mac` = '$mac'");

                if(mysql_num_rows ($result) == 1 )
                {
                
                echo "mac já cadastrado";
                 return;
                }else{
		return;
		}
		

	}

$result = mysql_query($sql);
header('location:/index.php?option=cadastro');
?>

