<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../config.php';

// Define uma função que poderá ser usada para validar e-mails usando regexp
function validaEmail($email) {
    $conta = "^[a-zA-Z0-9\._-]+@";
    $domino = "[a-zA-Z0-9\._-]+.";
    $extensao = "([a-zA-Z]{2,4})$";

    $pattern = $conta . $domino . $extensao;

    if (ereg($pattern, $email)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET['senha'])) {
    $senha = $_GET['senha'];
    $novamente = $_GET['novamente'];
    if ($senha != $novamente) {
        echo 'Senhas não conferem.';
        return;
    }
    if ($senha == '' || $novamente == '') {
        echo 'Os campos devem ser preenchidos.';
        return;
    }
    session_start();
    $result = mysql_query("UPDATE `usuarios` SET `senha` = '" . md5($senha) . "' WHERE `matricula` = " . $_SESSION['matricula']);
    echo "ok";
}
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    if (validaEmail($email)) {
        if ($email == '') {
            echo 'O campo E-mail deve ser preenchido.';
            return;
        }
        session_start();
        $_SESSION['email'] = $email;
        $result = mysql_query("UPDATE `usuarios` SET `email` = '" . $email . "' WHERE `matricula` = " . $_SESSION['matricula']);
        echo "ok";
    } else {
        echo "O E-mail inserido é invalido!";
    }
}
if (isset($_GET['nome'])) {
    $nome = $_GET['nome'];

    if ($nome == '') {
        echo 'O campo Nome deve ser preenchido.';
        return;
    }
    session_start();
    $_SESSION['nome'] = $nome;
    $result = mysql_query("UPDATE `usuarios` SET `nome` = '" . $nome . "' WHERE `matricula` = " . $_SESSION['matricula']);
    echo "ok";
}