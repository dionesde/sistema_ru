<?php
$con = mysql_connect("127.0.0.1", "root", "ufsmcs") or die ("Sem conexão com o servidor");
$select = mysql_select_db("UFSM_RU_HOMOLOG",$con) or die("Sem acesso ao DB, Entre em contato com o Administrador,diones.de@redes.ufsm.br");
?>
