
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if((!isset ($_SESSION['matricula']) == true))
{
        unset($_SESSION['matricula']);
        unset($_SESSION['senha']);
        header('location:login.php');
}
?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Sistema Ru</title>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">



        <link rel="stylesheet" href="css/jquery-ui.css">
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link rel="stylesheet" href="css/cascade.css">
        <script type="text/javascript" src="js/jquery-1.8.3.min.js" charset="UTF-8"></script>
        <script src="js/bootstrap.min.js"></script>

        <script src="js/jquery-ui.js"></script>

        <script>
            $(function () {
                $("#datepicker").datepicker();
            });

        </script>


    </head>
    <body>
        <div class="row">
            <div class="container">
                <div>	
                    <div style="float:right">Bem-vindo(a), <?php echo $_SESSION['nome']?> </div>
                    <img src="img/logo_sistema.gif" alt="sistema de controle de restaurantes" title="Sistema de Controle de Restaurantes"/>
                    <div class="topo"><a>inicial</a> <div class="pull-right lead"><a href="#">Alterar senha</a> - <a href="sair.php">Sair</a></div></div> 
                    <h2>Agendamento de Refeições do RU</h2>

                    <div>Informe o tipo de refeição e o período o qual deseja realizar o agendamento de refeições.
                        Para cada data do período informado, o sistema faz as devidas verificações de autorização e, no final, exibe um relatório com o resultado.
                    </div>
                    <br>
                    <div class ="titulos">
                        Dados do agendamento
                    </div>
                    <div>
                        <div>
                            <h2 style="text-align:center;">Refeições:</h2>
                            <div id="refeicao" >
                                Almoço:   <input id="almoco"  type="checkbox">       
                                Janta:   <input id="janta" type="checkbox">         
                            </div></br>


                        </div>
                    </div>
                    <div class ="titulos">
                        Período do agendamento
                    </div><br>
                    <div class="row">
                        <div class="col-lg-10">

                            <p>Inicial: <input id="inicio" type="text" class="datepicker">Final:<input id="final" type="text" class="datepicker"  ></p>
                            <h2><i> A data final não pode ultrapassar 10 dias a partir da data de hoje.</i> </h2>

                        </div>
                    </div>
                    <div id="result"></div>
                </div>
            </div>

        </div>


        <script type="text/javascript">
            function agendamento() {
                if ($('#almoco').attr('checked') || $('#janta').attr('checked')) {
                    if (($('#inicio').val() != '') && ($('#final').val() != '')) {
                        $.ajax({url: "getagendamento.php?inicio=" + $('#inicio').val() + "&final=" + $('#final').val() + "&almoco=" + $('#almoco').attr("checked") + "&janta=" + $('#janta').attr("checked"), success: function (result) {
                                $("#result").html(result);
                            }});
                    }

                }
            }
            $(function () {
                $("#almoco").click(function(){agendamento()});
                $("#janta").click(function(){agendamento()});
                $("#gravar").live("click",function(){
                    if ($('#almoco').attr('checked') || $('#janta').attr('checked')) {
                            if (($('#inicio').val() != '') && ($('#final').val() != '')) {
                              
                                 location.href="savaagendamento.php?inicio=" + $('#inicio').val() + "&final=" + $('#final').val() + "&almoco=" + $('#almoco').attr("checked") + "&janta=" + $('#janta').attr("checked");
                                        
                            }

                        }else{
                            alert(' Ao menos uma refeição deve ser marcada.');
                        }
                });
                
                $(".datepicker").datepicker({maxDate: "+10d", minDate: "+0d", onClose: function () {
                       agendamento();
                    }
                });
            });
        </script>
    </body>


</html>


