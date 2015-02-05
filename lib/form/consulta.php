<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Consulta {

    protected $con;
    protected $itens = array();
    protected $matricula;

    public function __construct($conect) {
        $this->con = $conect;
    }

    public function convert($str) {
        $str = explode("/", $str);
        $saida = $str[2] . "-" . $str[1] . "-" . $str[0];

        return $saida;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getCredito() {
        $result = mysql_query("SELECT * FROM `usuarios` WHERE `matricula` = '" . $this->matricula . "'");
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            return $row['creditos'];
        } else {
            return 0;
        }
    }

    public function getCompra($dataInicio = '', $dataFinal = '') {
        $dataAtual = date('Y-m-d', strtotime("-30 days"));

        if ($dataInicio != '' && $dataFinal != '') {
            $dataInicio = $this->convert($dataInicio);
            $dataFinal = $this->convert($dataFinal);
            $sql = "SELECT * FROM `compras` WHERE `matricula` = '" . $this->matricula . "' and  data between '$dataInicio'AND '$dataFinal' ORDER BY data";
            $result = mysql_query($sql);
        } else {

            $result = mysql_query("SELECT * FROM `compras` WHERE `matricula` = '" . $this->matricula . "'AND data > '$dataAtual'  ORDER BY data");
        }/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        $saida = '';
        if (mysql_num_rows($result) == 0) {
            return 'Sem resultados';
        }
        $saida.='<table class="table">';
        $saida.='<thead><tr><th>Créditos</th><th>Data</th></tr></thead>';
        while ($row = mysql_fetch_assoc($result)) {
            $saida.='<tr><td>' . "R$ " . number_format($row['creditos'], 2, ',', ' ') . '</td><td>' . date('d/m/Y (H:i:s)', strtotime($row['data'])) . '</td></tr>';
        }
        $saida.="</table>";
        return $saida;
    }

    public function getPresenca($dataInicio = '', $dataFinal = '') {

        $dataAtual = date('Y-m-d', strtotime("-30 days"));

        if ($dataInicio != '' && $dataFinal != '') {
            $dataInicio = $this->convert($dataInicio);
            $dataFinal = $this->convert($dataFinal);
            $sql = "SELECT * FROM `presenca` WHERE `matricula` = '" . $this->matricula . "' and  data between '$dataInicio'AND '$dataFinal' ORDER BY data,tipo ";
            $result = mysql_query($sql);
        } else {
            $result = mysql_query("SELECT * FROM `presenca` WHERE `matricula` = '" . $this->matricula . "'AND data > '$dataAtual'  ORDER BY data,tipo ");
        }
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        $saida = '';
        if (mysql_num_rows($result) == 0) {
            return 'Sem resultados';
        }
        $saida.='<table class="table">';
        $saida.='<thead><tr><th>Data</th><th>Tipo de refeição</th></tr></thead>';
        while ($row = mysql_fetch_assoc($result)) {
             if ($row['tipo'] == 1) {
                $tipo = 'Almoço';
            } elseif ($row['tipo'] == 2) {
                $tipo = "Janta";
            } elseif ($row['tipo'] == 3) {
                $tipo = "Distribuição";
            }
            $aviso = '';
            if ($row['status'] == 1) {
                $aviso = '- <span class="error">Refeição realizada sem agendamento.</span>';
            }
            if ($row['status'] == 2) {
                $aviso = '- <span class="error">Refeição não realizada.</span>';
            }
            $saida.='<tr><td>' . date('d/m/Y (H:i:s)', strtotime($row['data'])) . '</td><td>' . $tipo . " " . $aviso . '</td></tr>';
        }
        $saida.="</table>";
        return $saida;
    }

    public function getAgendamneto($dataInicio = '', $dataFinal = '') {
        $dataAtual = date("Y-m-d");
        $concat = "data >= '$dataAtual'";
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        if ($dataInicio != '' && $dataFinal != '') {
            $dataInicio = $this->convert($dataInicio);
            $dataFinal = $this->convert($dataFinal);

            $concat = "data >= '$dataInicio' AND data <='$dataFinal'";
        }
        $saida = "";

        $result = mysql_query("SELECT * FROM `agendamento` WHERE `matricula` = '" . $this->matricula . "'AND $concat  ORDER BY data,tipo ");
        if (mysql_num_rows($result) == 0) {
            return "Sem resultados";
        }
        $saida.='<table class="table">';
        $saida.='<thead><tr><th>Data</th><th>Tipo de refeição</th></tr></thead>';
        while ($row = mysql_fetch_assoc($result)) {
            if ($row['tipo'] == 1) {
                $tipo = 'Almoço';
            } elseif ($row['tipo'] == 2) {
                $tipo = "Janta";
            } elseif ($row['tipo'] == 3) {
                $tipo = "Distribuição";
            }
            $saida.='<tr><td>' . date('d/m/Y', strtotime($row['data'])) . '</td><td>' . $tipo . '</td></tr>';
        }
        $saida.="</table>";
        return $saida;
    }

}
