<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class agendamento {

    protected $con;
    protected $itens = array();
    protected $matricula;
    protected $table;
    
    public function __construct($conect) {
        $this->con = $conect;
    }
    public function setTable($tabela) {
        $this->table = $tabela;
    }
    public function setMatricula($matricula){
        $this->matricula=$matricula;
    }
    public function checkFind($data) {
        if (date("w", $data) == 0 || date("w", $data) == 6) {
            return true;
        } else {
            return false;
        }
    }
    #conefe se o dia esta disponivel
    public function checkIndsp($data){
        return false;
    }
    #checa se ultrapassou 10 dias
    public function checkNdias($data){
        if($data > time()+(10*24*60*60)){
            return true;
        }
        return false;
    }
 public function insert($dados) {
        $aux = 0;
        $sql = "INSERT INTO `$this->table` (";
        foreach ($dados as $key => $value) {
            if ($aux == 0) {
                $sql.=" `$key`";
                $aux = 1;
            } else {
                $sql.=", `$key`";
            }
        }
        $sql.=") VALUES (";
        foreach ($dados as $key => $value) {
            if ($aux == 1) {
                $aux = 0;
                if(is_integer($value)){
                     $sql.=" $value";
                }else{
                      $sql.=" '$value'";
                }
            } else {
                if(is_integer($value)){
                     $sql.=" ,$value";
                }else{
                     $sql.=" ,'$value'";
                }
                     
            }
        }
        $sql.=");";
     
        $result = mysql_query($sql, $this->con);
    }
    public function checkagendamento($data,$tipo){
        $sql = "SELECT * FROM `$this->table` WHERE matricula='$this->matricula' AND data='".date('Y-m-d G:i:s',$data)."' AND tipo=".$tipo;
        $result = mysql_query($sql, $this->con);
        if(mysql_num_rows ($result) > 0 ){
            return true;
        }else{
            return false;
        }
    }

    public function checkHora($data,$tipo){
        
        $dataAtual=strtotime(date("Y-m-d"));
        if($dataAtual == $data){
            if($tipo == 2){
                if(date("H") > 12){
                    return true;
                }
                
            }
        }
        if($data == $dataAtual+(24*60*60)){
            if($tipo == 1){
               if(date("H") > 18){
                    return true;
                }
            }
        }
        if($data <= ($dataAtual) && $tipo == 1){
            return true;
        }
        if($data < ($dataAtual) && $tipo == 2){
            return true;
        }
        return false;
    }
    
    public function checar($data,$tipo){
        $saida['msg']='';
        $saida['status']=0;
        #se for final de semana bloqueia almoço e janta
        if($this->checkFind($data)){
            $saida['msg']='  <span class="error">Não.</span> Motivo: Tipo de refeição inválido para a data selecionada.  ';
            $saida['status']=0;
        }
        elseif($this->checkIndsp($data)){
            $saida['msg']='  <span class="error">Não.</span> Motivo: Dia não disponível para agendamento.  ';
            $saida['status']=0;
        }
        elseif ($this->checkNdias($data)) {
            $saida['msg']='  <span class="error">Não.</span> Motivo: A data ultrapassou 10 dias.  ';
            $saida['status']=0;
        }
        elseif($this->checkagendamento($data, $tipo)){
            $saida['msg']='  <span class="error">Não.</span> Motivo: Já existe agendamento para esta data.';
            $saida['status']=0;
        }
        elseif ($this->checkHora($data, $tipo)){
            $saida['msg']='  <span class="error">Não.</span> Motivo: Tempo insuficiente.';
            $saida['status']=0;
        }
        
        else{
            $saida['msg']='<span class="sucesso">Sim</span>';
            $saida['status']=1;
        }
        return $saida;        
    }
    public function getTable($inicio,$fim,$almoco,$janta){
        $str='';
        $str.='<button id="gravar" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>  Salvar</button></br></br>';
        $str.='<table class="table table-bordered"> ';
        $str.='<thead><tr><tr><th>Data</th> <th>Tipo de refeição</th> <th>Realizado ?</th> </tr></tr></thead>';
        $str.="<tbody>";
        for($data=$inicio;$data<=$fim;$data+=(1*24*60*60)){
            
            if($almoco == 'checked'){
                $saida=$this->checar($data,1);
                $str.="<tr><td>".date('j/m/Y',$data)."</td><td>Almoço</td><td>".$saida['msg']."</td></tr>";
            }
            if($janta == 'checked'){
                $saida=$this->checar($data,2);
                 $str.="<tr><td>".date('j/m/Y',$data)."</td><td>Janta</td><td>".$saida['msg']."</td></tr>";
            }
           
        }
        $str.="</tbody>";
        $str.='<table>';
        return $str;
    }
    public function convert($str) {
        $str = str_replace("/", "-", $str);
        $str = strtotime($str);
        
        return $str;
    }


    public function check($inicial, $final, $beneficio = false) {
        for ($dia = 0; $dia < 10; $dia++) {
            $inicial+= (1 * 24 * 60 * 60);
        }
    }
    # 0= almoco, 1=janta
    public function salvar($inicio, $fim, $almoco, $janta) {
        for($data=$inicio;$data<=$fim;$data+=(1*24*60*60)){
           
            if($almoco == 'checked'){
                $saida=$this->checar($data,1);
                if($saida['status']== 1){
                    $dados['matricula']=$this->matricula;
                    $dados['data']=date('Y-m-d G:i:s',$data);
                    $dados['tipo']=1;
                    $dados['status']=0;
                    $this->insert($dados);
                }
            }
            if($janta == 'checked'){
                $saida=$this->checar($data,2);
                if($saida['status']== 1){
                    $dados['matricula']=$this->matricula;
                    $dados['data']=date('Y-m-d G:i:s',$data);
                    $dados['tipo']=2;
                    $dados['status']=0;
                    $this->insert($dados);
                }
            }
           
        }
    }

}

