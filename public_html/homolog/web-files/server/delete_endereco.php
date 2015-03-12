<?php

set_time_limit(0);
require("../../system/model.php");

Class Querys extends Model {
    
    public function delete_enderecos($codendereco) {
        $this->_tabela = "enderecos";
        $where = "CODENDERECO='{$codendereco}'";
        return $this->delete($where);
    }
    
    public function delete_cadastro_rel_enderecos($codendereco) {
        $this->_tabela = "cadastro_rel_enderecos";
        $where = "CODENDERECO='{$codendereco}'";
        return $this->delete($where);
    }
        
    public function get_enderecos($codcadastro) {
        
        $query = $this->db->query("SELECT enderecos.* FROM `enderecos` "
                . "INNER JOIN `cadastro_rel_enderecos` ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO "
                . "WHERE cadastro_rel_enderecos.CODCADASTRO='{$codcadastro}'"
                . "GROUP BY enderecos.CODENDERECO"
                . " ORDER BY enderecos.DTA DESC");
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {                
                $rows->BAIRRO = utf8_encode($rows->BAIRRO);                
                $rows->CIDADE = utf8_encode($rows->CIDADE);                
                $rows->COMPLEMENTO = utf8_encode($rows->COMPLEMENTO);                
                $rows->NUMERO = utf8_encode($rows->NUMERO);                
                $rows->LOGRADOURO = utf8_encode($rows->LOGRADOURO);                
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    } 
    
    public function qntdd_enderecos($codcadastro) {
        
        $query = $this->db->query("SELECT enderecos.* FROM `enderecos` "
                . "INNER JOIN `cadastro_rel_enderecos` ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO "
                . "WHERE cadastro_rel_enderecos.CODCADASTRO='{$codcadastro}'"
                . "GROUP BY enderecos.CODENDERECO"
                . " ORDER BY enderecos.DTA DESC");
        $query->execute(); 
        return $query->rowCount();
    }
    
    public function update_status_enderecos($codendereco) {
        $this->_tabela = "enderecos";
        $dados['STATUS'] = 1;
        $where = "CODENDERECO='{$codendereco}'";
        return $this->update($dados, $where);
    }
}

$model = new Querys();

$codendereco = $_POST['CODENDERECO'];
$codcadastro = $_POST['CODCADASTRO'];

$model->delete_cadastro_rel_enderecos($codendereco);
$model->delete_enderecos($codendereco);

if( (int)$model->qntdd_enderecos($codcadastro) == 1 ){
    
    $enderecos_unic = $model->get_enderecos($codcadastro);
    foreach( $enderecos_unic as $endereco_unic){
        $model->update_status_enderecos($endereco_unic->CODENDERECO);
    }    
}

$enderecos = $model->get_enderecos($codcadastro);
$html = "";

if( $enderecos ){
    
    $i=1;
    foreach($enderecos as $endereco){
        
        if($endereco->STATUS == "1"){
            $html .= "<h4 colspan='2'>{$i}. Endereço de entrega</h4>";
        } else {
            $html .= "<h4 colspan='2'>{$i}. Endereço adicional</h4>";
        }
        $html .= "<div class='panel panel-default'> ";
            $html .= "<table class='table' style='font-size: 14px'>";
                $html .= "<tr>";
                    $html .= "<td rowspan='4'>";
                            $html .= "<input type='radio' value='{$endereco->STATUS}' name='prioridade' onclick=\"javascript:alter_endereco_entrega2(this.id)\" id='{$endereco->CODENDERECO}' ";
                    if($endereco->STATUS == "1"){
                        $html .= "checked='true'";
                    }
                    $html .= "/></td>\n";
                    $html .= "<td>CEP:</td>\n";
                    $html .= "<td>{$endereco->CEP}</td>\n";
                    $html .= "<td rowspan='4'><span class='plus' onclick=\"javascript:del_row_enderecos2('{$endereco->CODENDERECO}','{$codcadastro}')\"><i class='fa fa-times'></i></span></td>\n";
                $html .= "</tr>\n";
                $html .= "<tr><td>Endereço:</td><td>{$endereco->LOGRADOURO}, {$endereco->NUMERO}"; 
                if ($endereco->COMPLEMENTO != ""){
                    $html .= "- {$endereco->COMPLEMENTO}{/if}</td>\n";
                }
                $html .= "</tr>\n";
                $html .= "<tr> <td>Bairro:</td><td>{$endereco->BAIRRO}</td> </tr>\n";
                $html .= "<tr> <td>Cidade/UF:</td><td>{$endereco->CIDADE}/{$endereco->UF}</td> </tr>\n";
            $html .= "</table>\n";
        $html .= "</div>\n";
        $i++;    
    }
    
} else {
    $html .= "reload";
}


print($html);