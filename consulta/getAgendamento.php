<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../lib/form/consulta.php';
require_once '../config.php';
$consulta = new consulta($con);
session_start();
$consulta->setMatricula($_SESSION['matricula']);
$data_inicio=$_GET['inicio'];
$data_final=$_GET['final'];

$pesquisa=$_GET['consulta'];
if($pesquisa=='agendamento'){
    echo $consulta->getAgendamneto($data_inicio, $data_final);
}
if($pesquisa=='refeicao'){
    echo $consulta->getPresenca($data_inicio, $data_final);
}
if($pesquisa=='compras'){
     echo $consulta->getCompra($data_inicio, $data_final);
}

