<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(!isset ($_SESSION['matricula']) == true)
{
        unset($_SESSION['matricula']);
        header('location:login.php');
}

    require_once("lib/raelgc/view/Template.php");
    require_once("config.php");
    
    use raelgc\view\Template;

    $tpl = new Template("index.html");
    
    $pasta=$_GET['option'];

    if($_GET['option']){
	$pagina="index";
	if($_GET['action']){
		$pagina=$_GET['action'];
	}
        if(file_exists($pasta."/$pagina.html")){
            $tpl->addFile("conteudo", $pasta."/$pagina.html");	
        }
        if(file_exists($pasta."/$pagina.php")){
		require_once($pasta."/$pagina.php");
	}

    }else{
        $tpl->addFile("conteudo","home.html");	
    }

    $tpl->addFile("menu","menu.html");	
    $tpl->show();

?>
