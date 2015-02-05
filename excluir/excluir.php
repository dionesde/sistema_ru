<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../lib/form/excluir.php';
require_once '../config.php';
$excluir = new Excluir($con);
session_start();
$excluir->setMatricula($_SESSION['matricula']);

echo $excluir->apagar($_GET['id']);