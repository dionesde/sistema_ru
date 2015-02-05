<?php

require_once 'lib/form/excluir.php';
$excluir = new Excluir($con);
$excluir->setMatricula($_SESSION['matricula']);
$tpl->agendamento=$excluir->getAgendamneto();
