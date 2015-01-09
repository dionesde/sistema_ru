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

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getCredito() {
        $result = mysql_query("SELECT * FROM `usuarios` WHERE `matricula` = '".$this->matricula."'");
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            return $row['creditos'];
        }else{
            return 0;
        }
    }
    public function getCompra(){
        $result = mysql_query("SELECT * FROM `compras` WHERE `matricula` = '".$this->matricula."'");
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        $saida='';
        if(mysql_num_rows($result) == 0){
            return 'Sem resultados';
        }
        $saida.='<table>';
        $saida.='<thead><tr><th>Créditos</th><th>Data</th></tr></thead>';
        while( $row = mysql_fetch_assoc($result)){
             $saida.='<tr><td>'.$row['creditos'].'</td><td>'.date('d/m/Y (H:i:s)', strtotime($row['data'])).'</td></tr>';
        }
        $saida.="</table>";
        return $saida;
    }
    public function getPresenca(){
        $dataAtual=strtotime(date("Y-m-d"));
        $result = mysql_query("SELECT * FROM `presenca` WHERE `matricula` = '".$this->matricula."'AND data > ".$dataAtual." ORDER BY data,tipo ");
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        $saida='';
        if(mysql_num_rows($result) == 0){
            return 'Sem resultados';
        }
        $saida.='<table>';
        $saida.='<thead><tr><th></th><th>Data</th><th>Tipo de refeição</th></tr></thead>';
        while( $row = mysql_fetch_assoc($result)){
            if($row['tipo'] == 1){
                $tipo='Almoço';
            }else{
                $tipo="Janta";
            }
             $saida.='<tr><td></td><td>'.date('d/m/Y (H:i:s)', strtotime($row['data'])).'</td><td>'.$tipo.'</td></tr>';
        }
        $saida.="</table>";
        return $saida;
    }
    public function getAgendamneto($dataInicio='',$dataFinal){
        $dataAtual=strtotime(date("Y-m-d"));
        $result = mysql_query("SELECT * FROM `agendamento` WHERE `matricula` = '".$this->matricula."'AND data > $dataAtual  ORDER BY data,tipo ");
        /* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
        $saida='';
        if(mysql_num_rows($result) == 0){
            return 'Sem resultados';
        }
        $saida.='<table>';
        $saida.='<thead><tr><th></th><th>Data</th><th>Tipo de refeição</th></tr></thead>';
        while( $row = mysql_fetch_assoc($result)){
            if($row['tipo'] == 1){
                $tipo='Almoço';
            }else{
                $tipo="Janta";
            }
             $saida.='<tr><td></td><td>'.date('d/m/Y', strtotime($row['data'])).'</td><td>'.$tipo.'</td></tr>';
        }
        $saida.="</table>";
        return $saida;
    }

}
