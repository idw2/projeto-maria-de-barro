<?php

class HTML_Model extends Model {

    public function get_page($pagina) {
        
        $pagina = addslashes($pagina);
        
        $this->_tabela = "html";
        $where = "PAGINA='{$pagina}'";
        return $this->read($where);
    }
    
    public function update_conteudo($pagina, $conteudo) {
        
        $conteudo = addslashes($conteudo);
                
        $query = $this->db->prepare("UPDATE `html` SET CONTEUDO=:CONTEUDO WHERE PAGINA=:PAGINA");
        $query->bindParam(":PAGINA", $pagina, PDO::PARAM_STR, 20);
        $query->bindParam(":CONTEUDO", $conteudo,  PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
        $query->execute();
        return true;
    }

}
