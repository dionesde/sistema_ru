<?php

require_once 'lib/form/form.php';

$tpl->url_form="/index.php?option=$pasta&novo=true";

$form=new form($con);
$form->setTable('cursos');

if($_GET['excluir']){
    $form->delete($_GET['excluir']);
}
if($_POST['id']){
    $form->update($_POST);
}
if($_GET['novo']){
    $form->insert($_POST);
}


$form->setOption($pasta);
$form->addTex('Código', 'cod');
$form->addTex('Nome', 'nome');
$tpl->table=$form->getTable('order by id DESC');
$tpl->titulo="Cursos UFSM-CS";


if($_GET['edit']){
    $tpl->form = $form->getForm($_GET['edit']);
    $tpl->url_form="/index.php?option=$pasta";
}else{
    $tpl->form = $form->getForm($_GET['edit']);
}
?>
