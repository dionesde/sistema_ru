<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class form {

    protected $consulta = "";
    protected $con;
    protected $itens = array();
    protected $table;
    protected $option;

    public function __construct($conect) {
        $this->con = $conect;
    }

    public function addTex($nameForm, $nameDb) {
        $item->type = 'text';
        $item->nome = $nameForm;
        $item->table = $nameDb;
        array_push($this->itens, $item);
    }

    public function addChecked($nameForm, $nameDb) {
        $item->type = 'checked';
        $item->nome = $nameForm;
        $item->table = $nameDb;
        array_push($this->itens, $item);
    }

    public function setTable($tabela) {
        $this->table = $tabela;
    }

    public function setOption($option) {
        $this->option = $option;
    }

    public function getForm($id) {
        $sql = "SELECT * FROM `$this->table` WHERE id=$id";
        $result = mysql_query($sql, $this->con);
        $row = mysql_fetch_assoc($result);
         
        $saida = "<form id='defaultForm' method='post' class='form-horizontal' action='index.php?option='.$$this->option.'/cadastro.php'>";
        if($row['id'] != ''){
            $saida.='<INPUT TYPE="hidden" NAME="id" VALUE="'.$row['id'].'">';
        }
        foreach ($this->itens as $value) {
            $saida.="
                <div class='form-group'>
                    <label class='col-lg-3 control-label'>$value->nome :</label>
                        ";
            if ($value->type == 'checked') {
                if($row[$value->table] == 1){
                     $saida.="<div class='col-lg-1'><input type='checkbox' checked class='form-control' name='$value->table' />";
                }else{
                    $saida.="<div class='col-lg-1'><input type='checkbox'  class='form-control' name='$value->table' />";
                }
            } else {
                $saida.="<div class='col-lg-5'><input type='text' class='form-control' name='$value->table' value='".$row[$value->table]."'/>";
            }
            $saida.="</div></div>";
        }
        $saida.="<div class='form-group'><div class='col-lg-9 col-lg-offset-3'>";
        if($row['id'] != ''){
            $saida.="<button type='submit' class='btn btn-primary'>Alterar</button>";
        
        }else{
           $saida.="<button type='submit' class='btn btn-primary'>Gravar</button>";
         
        }
        $saida.="<button class='btn btn-default' onclick=\"location.href = '/index.php?option=$this->option'\" style='margin:6px' type='button'>Cancelar</button>";
        $saida.="</div></div>";
        return $saida;
    }
    public function update($dados){
       $aux=0;	
       $sql="UPDATE $this->table SET";
        foreach ($dados as $key => $value) {
            if ($aux == 0) {
                $sql.=" $key='$value'";
                $aux = 1;
            } else {
                if($value == 'on'){
                    $sql.=",$key= 1";
                }elseif ($value == 'off') {
                    $sql.=",$key= 0";
                }  else {
                    $sql.=",$key= '$value'";
                }
                
            }
        }
        $sql.=" WHERE id = ".$_POST['id'];
        
        $result = mysql_query($sql, $this->con);        
    }
    public function delete($id) {
        $sql = " DELETE FROM $this->table WHERE `id` =" . $id;

        $result = mysql_query($sql, $this->con);
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
                if ($value == 'on') {
                    $sql.=" 1";
                } elseif ($value == 'off') {
                    $sql.=" 0";
                }else{
                      $sql.=" '$value'";
                }
            } else {
                if ($value == 'on') {
                    $sql.=" ,1";
                } elseif ($value == 'off') {
                    $sql.=" ,0";
                }else{
                      $sql.=" ,'$value'";
                }
            }
        }
        $sql.=");";
        
        $result = mysql_query($sql, $this->con);
    }

    public function getTable($orden = "") {
        $saida = "<table class='table table-bordered table-hover'>";
        $sql = "SELECT * FROM `$this->table` WHERE 1 $orden";

        $result = mysql_query($sql, $this->con);
        if (mysql_num_rows($result) != 0) {
            // output data of each row
            $cont = 0;
            $saida.="<thead class='cabecalho'><th>#</th>";

            foreach ($this->itens as $value) {
                $saida.="<th>$value->nome</th>";
            }
            $saida.="<th>          </th></tr></thead>";
            $saida.='<tbody>';
            $indice = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $indice+=1;
                $saida.="<tr><td>$indice</td>";
                foreach ($this->itens as $value) {
                    if ($value->type == 'checked') {
                        if ($row[$value->table] == '1') {
                            $saida.="<td><center><img width='30px' src=img/checked.png><center></td>";
                        } else {
                            $saida.="<td><center><img width='30px' src='img/unchecked.png'></center></td>";
                        }
                    } else {
                        $saida.="<td>" . $row[$value->table] . "</td>";
                    }
                }
                $id = $row['id'];
                $saida.="
                <td>
                <div  width='70px'>
                    <a href='index.php?option=$this->option&edit=$id'>
                        <img width='30px' height='30px' src='img/edit.png' title='Editar'></img>
                    </a>
                    <a href='index.php?option=$this->option&excluir=$id'>
                        <img width='30px' height='30px' src='img/delete.png' title='Deletar'></img>
                    </a>
                </div>
                </td>";
                $saida.="</tr>";
            }

            $saida.="</tbody></table>";
        }



        return $saida;
    }

}
