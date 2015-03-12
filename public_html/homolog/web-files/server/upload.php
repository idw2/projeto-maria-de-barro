<?php

set_time_limit(0);
require("../../system/model.php");


Class Querys extends Model {

    public function insert_fotos(Array $dados) {
        $this->_tabela = "fotos";
        return $this->insert($dados);   
    }
    
    public function insert_fotos_rel_produtos(Array $dados) {
        $this->_tabela = "fotos_rel_produtos";
        return $this->insert($dados);
    }

    public function getPrimarykey() {
        return strtoupper(md5(uniqid(rand(), true)));
    }

    public function get_produto($key) {
        $this->_tabela = "produtos";
        $where = "URL_AMIGAVEL='{$key}'";
        return $this->read($where);
    }
    
     public function qnts_fotos($url_amigavel) {
        $query = $this->db->prepare("SELECT * FROM `fotos`
    INNER JOIN `fotos_rel_produtos` ON `fotos_rel_produtos`.CODFOTO=`fotos`.CODFOTO
    INNER JOIN `produtos` ON `fotos_rel_produtos`.CODPRODUTO=`produtos`.CODPRODUTO
    WHERE URL_AMIGAVEL=:URL_AMIGAVEL");
        $query->bindParam(":URL_AMIGAVEL", $url_amigavel, PDO::PARAM_STR, 70);
        $query->execute();
        return $query->rowCount();
    }

}


$model = new Querys();

$produto = $model->get_produto($_GET["url_amigavel"]);

$foto = $_FILES["myfile"];
$folder = $model->getPrimarykey();

$path = "../upload/" . $folder;
$raiz = $caminho;


if (!is_dir($path)) {
    mkdir($path, 0777, true);
}

preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $foto["name"], $ext);
$filename = $model->getPrimarykey() . "." . $ext[1];

$caminho_imagem = $path . "/" . $filename;
$original = str_replace("../", "/web-files/", $caminho_imagem);
$raiz = str_replace("../", "/web-files/", $path) . "/";

$dados["CODFOTO"] = $model->getPrimarykey();
$dados["RAIZ"] = $raiz;
$dados["FORMATO"] = $ext[1];
$dados["TIPO"] = $foto["type"];
$dados["NOME"] = $foto["name"];
$dados["ORIGINAL"] = $original;
$dados["RAIZ"] = $raiz;
$dados["STATUS"] = 1;

$count = $model->qnts_fotos($_GET["url_amigavel"]);
$dados["ORDEM"] = ($count+1);
$dados["DESTAQUE"] = 0;

$model->insert_fotos($dados);
$fotos_rel_produtos["CODFOTO"] = $dados["CODFOTO"];
$fotos_rel_produtos["CODPRODUTO"] = $produto->CODPRODUTO;
$model->insert_fotos_rel_produtos($fotos_rel_produtos);

move_uploaded_file($foto["tmp_name"], $caminho_imagem);

