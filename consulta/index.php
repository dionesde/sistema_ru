<?php

require_once 'lib/form/consulta.php';
$consulta = new consulta($con);
$consulta->setMatricula($_SESSION['matricula']);

$tpl->nome = $_SESSION['nome'];
$creditos = $consulta->getCredito();

    $creditos = "R$ ".number_format($creditos, 2, ',', ' ');

$tpl->credito = $creditos;
$tpl->compras=$consulta->getCompra();
$tpl->agendamento=$consulta->getAgendamneto();
$tpl->refeicao=$consulta->getPresenca();