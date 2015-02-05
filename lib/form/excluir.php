<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Excluir {

    protected $con;
    protected $itens = array();
    protected $matricula;

    public function __construct($conect) {
        $this->con = $conect;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function checkHora($data, $tipo) {

        $dataAtual = strtotime(date("Y-m-d"));
        if ($dataAtual == $data) {
            if ($tipo == 2) {
                if (date("H") >= 12) {
                    return true;
                }
            }
        }
        if ($data == ($dataAtual + (24 * 60 * 60))) {
            if ($tipo == 1) {
                if (date("H") >= 18) {
                    return true;
                }
            }
        }
        if ($data <= ($dataAtual) && $tipo == 1) {
            return true;
        }
        if ($data < ($dataAtual) && $tipo == 2) {
            return true;
        }
        return false;
    }

    public function apagar($id) {
        if (!$this->checkHora(strtotime($row['data']), $row['tipo'])) {
            $sql = "DELETE FROM `agendamento` WHERE `matricula` = '" . $this->matricula . "'and `id` = $id";
            mysql_query($sql);
            return "ok";
        }else{
            return "Tempo insuficiente para esta operação.";
        }
    }

    public function getAgendamneto($dataInicio = '', $dataFinal = '') {

        $dataAtual = date("Y-m-d");

        if ($dataInicio != '' && $dataFinal != '') {
            $dataInicio = $this->convert($dataInicio);
            $dataFinal = $this->convert($dataFinal);
            $sql = "SELECT * FROM `agendamento` WHERE `matricula` = '" . $this->matricula . "' and  data between '$dataInicio'AND '$dataFinal' ORDER BY data,tipo ";
            $result = mysql_query($sql);
        } else {
            $result = mysql_query("SELECT * FROM `agendamento` WHERE `matricula` = '" . $this->matricula . "'AND data >= '$dataAtual'  ORDER BY data,tipo ");
        }
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        $saida = '';
        if (mysql_num_rows($result) == 0) {
            return 'Sem resultados';
        }
        $saida.='<table class="table">';
        $saida.='<thead><tr><th style="width:70px">Excluir</th><th>Data</th><th>Tipo de refeição</th></tr></thead>';
        while ($row = mysql_fetch_assoc($result)) {
             if ($row['tipo'] == 1) {
                $tipo = 'Almoço';
            } elseif ($row['tipo'] == 2) {
                $tipo = "Janta";
            } elseif ($row['tipo'] == 3) {
                $tipo = "Distribuição";
            }
            if (!$this->checkHora(strtotime($row['data']), $row['tipo'])) {
                $excluir = '<button onclick="excluir(\'' . $row['id'] . '\')"><span style="padding:5px" class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
            }
            $saida.="<tr id='table_" . $row['id'] . "'><td>$excluir</td><td>" . date('d/m/Y', strtotime($row['data'])) . '</td><td>' . $tipo . '</td></tr>';
        }
        $saida.="</table>";
        return $saida;
    }

}
