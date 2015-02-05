<?php
session_start();
unset($_SESSION['matricula']);
unset($_SESSION['nome']);
unset ($_SESSION['beneficio']);
unset ($_SESSION['email']);

header('location:login.php');
?>
