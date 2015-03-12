<?php

set_time_limit(0);
require("../../system/model.php");

//Class Querys extends Model {
    /*
    public function add_lista_desejos($dados) {
        $this->_tabela = "lista_desejos";
        return $this->insert($dados);
    }
    
    public function get_drop_lista_desejos($url_amigavel_or_codproduto, $client_hidden = null) {
        
        $query = $this->db->query("SELECT 
                produtos.CODPRODUTO, 
                produtos.NOME, 
                fotos.CROP80 as FOTO, 
                CASE produtos.CATEGORIA 
                WHEN 'aneis' THEN 'Anéis'
                WHEN 'brincos' THEN 'Brinco'
                WHEN 'colares' THEN 'Colares'
                ELSE 'Pulseiras' 
                END AS CATEGORIA, 
                produtos.PRECO, 
                (produtos.PRECO*SUM(lista_desejos.QUANTIDADE)) as TOTAL, 
                SUM(lista_desejos.QUANTIDADE) as QUANTIDADE 
        FROM produtos
        INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
        INNER JOIN fotos_rel_produtos ON fotos_rel_produtos.CODPRODUTO=produtos.CODPRODUTO
        INNER JOIN fotos ON fotos_rel_produtos.CODFOTO=fotos.CODFOTO
        WHERE produtos.CODPRODUTO='{$url_amigavel_or_codproduto}' 
        OR produtos.URL_AMIGAVEL='{$url_amigavel_or_codproduto}' 
        OR lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
        AND fotos.DESTAQUE=1
        GROUP BY produtos.CODPRODUTO
        ORDER BY (produtos.NOME) ASC");
        
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME = strtoupper(utf8_decode($rows->NOME));
                $rows->PRECO = $this->formataReais($rows->PRECO);
                $rows->TOTAL = $this->formataReais($rows->TOTAL);
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }
    
    public function formataReais($valorReal) {
        $size = strlen($valorReal);
        $result = null;
        if ($size >= 9) {
            //9.999.999,99                                                                         
            if ($size == 9) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -9, 1);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            } elseif ($size == 10) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -10, 2);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            } elseif ($size == 11) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -11, 3);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            }
            return $result;
        } elseif ($size == 8) {
            //999.999,99                                                                           
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -8, 3);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 7) {
            //99.999,99                                                                            
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -7, 2);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 6) {
            //9.999,99                                                                             
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -6, 1);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 5) {
            //999,99                                                                               
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 4) {
            //99,99                                                                                
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -4, 2);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 3) {
            //9,99                                                                                 
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -3, 1);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 2) {
            //0,99                                                                                 
            $p1 = substr($valorReal, -2);
            $result = "0," . $p1;
            return $result;
        }

        return false;
    }*/
//}

//var_dump($_POST);
/*
$model = new Querys();
$_POST["CODLISTADESEJOS"] = strtoupper(md5(uniqid(rand(), true)));
$_POST["QUANTIDADE"] = ($_POST["QUANTIDADE"] == "" || $_POST["QUANTIDADE"] == "NaN" || $_POST["QUANTIDADE"] == null) ? $_POST["QUANTIDADE"] = 1 : $_POST["QUANTIDADE"];

$model->add_lista_desejos($_POST);

$listas = $model->get_drop_lista_desejos(null, $_POST["CLIENT_HIDDEN"]);

$str = "";

if(is_array($listas)){
    
    foreach( $listas as $obj){
        
        $str .= "<li role='presentation>
            <a role='menuitem' tabindex='-1' onclick='return false'>
                <table>
                    <tr>
                        <td>
                            <img src='{$obj->FOTO}' alt='{$obj->NOME}' title='{$obj->NOME}' border='0'/><br/>
                        </td>
                        <td>
                            {$obj->NOME}<br/>
                            {$obj->CATEGORIA}<br/>                                        
                            Quantidade: {$obj->QUANTIDADE}<br/>
                            Unitário: R$ {$obj->PRECO}<br/>
                            Total: R$ {$obj->TOTAL}
                        </td>
                    </tr>
                </table>
            </a>
        </li>
         <li role='presentation' class='divider'></li>";
        
        
    }
    
    $str .= "<li role='presentation'><a role='menuitem' tabindex='-1' href='#' class='btn btn-default navbar-btn topclass'>Checkout</a></li>";
    
}

print($str);
