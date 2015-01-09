<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'lib/form/agendamento.php';
require_once("config.php");
$agn=new agendamento();
session_start();
$data_inicio=$agn->convert($_GET['inicio']);
$data_final=$agn->convert($_GET['final']);
$agn=new agendamento($con);
$agn->setTable('agendamento');
$agn->setMatricula($_SESSION['matricula']);
#$data_inicio=date("w", $data_inicio);
 echo $agn->getTable($data_inicio, $data_final,$_GET['almoco'],$_GET['janta']);