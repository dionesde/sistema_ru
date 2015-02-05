

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Sistema Ru</title>

        <link rel="stylesheet" href="../css/jquery-ui.css">
        <link href="../css/jquery-ui.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">


        <script type="text/javascript" src="../js/jquery-1.8.3.min.js" charset="UTF-8"></script>
        <script src="../js/jquery-ui.js"></script>
        <script src="../js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="../css/cascade.css">


    </head>
    <body>


        <?php
        session_start();
        unset($_SESSION['matricula']);
        unset($_SESSION['nome']);
        unset($_SESSION['beneficio']);

        function RandomString() {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 10; $i++) {
                $randstring .= $characters[rand(0, strlen($characters))];
            }
            return $randstring;
        }

        if ($_POST['login']) {
            require_once '../config.php';
            require 'mail.php';
            $msg='';
            $senha = RandomString();
            $login = $_POST['login'];
            $result = mysql_query("SELECT * FROM `usuarios` WHERE `matricula` = '$login' AND `email`!= ''");


            /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_assoc($result);

                $nome = $row['nome'];
                $matricula = $row['matricula'];
                $email = $row['email'];
              
                $msg=envia($matricula, $nome, $email, $senha);
                if(strpos($msg, 'Mailer Error:') == 0){
                      $result = mysql_query("UPDATE `usuarios` SET `senha` = '" . md5($senha) . "' WHERE `matricula` = " . $matricula);
                }            
            } else {
                $msg="Nenhum e-mail foi cadastrado neste sistema, para este login.";
            }
            echo "<script>alert('$msg')</script>";
        }
        ?>
        <div class="row">
            <div class="container">
                <img src="../img/logo_sistema.gif" alt="sistema de controle de restaurantes" title="Sistema de Controle de Restaurantes"/>
                <div class="topo"> <a href="javascript:history.back(1);"><< Voltar</a></div>
                <h1>Esqueci minha senha</h1>
                <div class='box alert bordered tip shadowed'>
                    Caso você tenha esquecido a sua senha, preencha os campos abaixo da seguinte forma:</br>
                    <ul class="no-bullets">
                        <li><strong>Alunos:</strong> informar a matrícula do curso atual no campo 'Login';</li>
                        <li><strong>Docentes e Téc. Adm. em Educação:</strong> informar a matrícula SIAPE no campo 'Login';</li>
                    </ul>
                    Após, o sistema enviará uma nova senha, gerada automaticamente, para o e-mail cadastrado no sistema.</br>
                    Cada nova solicitação sobrescreve a senha anterior. Por isso, utilize sempre a senha do último e-mail recebido.</br>
                    <br><br>
                    <form method="post" action="">
                        Login:<input name="login" type='text'>
                        <button  type="submit" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span> Solicitar senha</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>