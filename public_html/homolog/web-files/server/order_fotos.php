<?php

set_time_limit(0);
require("../../system/model.php");

Class Querys extends Model {
/*
    public function get_foto($key) {
        $this->_tabela = "fotos";
        $where = "CODFOTO='{$key}'";
        return $this->read($where);
    }*/

    public function update_ordem(Array $dados, $key) {
        $this->_tabela = "fotos";
        $where = "CODFOTO='{$key}'";
        return $this->update($dados, $where);
    }

}

$keys = $_POST["keys"];
$_keys = explode(";", $keys);
$model = new Querys();


$i=1;
foreach($_keys as $value){
    if($value != "" || $value != null){
        $codfoto = strtoupper($value);
        $dados["ORDEM"] = $i; 
        $model->update_ordem($dados, $codfoto);
    }
    $i++;
}

echo foi;
/*
$indice = $_POST["indice"];
$x1 = $_POST["x1"];
$y1 = $_POST["y1"];
$x2 = $_POST["x2"];
$y2 = $_POST["y2"];
$codfoto = strtoupper($_POST["codfoto"]);

$model = new Querys();
$foto = $model->get_foto($codfoto);

$jpeg_quality = 100;

$src = "../" . str_replace("/web-files/", "", $foto->ORIGINAL);
$extensao = strtoupper(pathinfo($src, PATHINFO_EXTENSION));


switch ($extensao) {
    case 'JPG':
        $img_r = imagecreatefromjpeg($src);
        break;
    case 'JPEG':
        $img_r = imagecreatefromjpeg($src);
        break;
    case 'PNG':
        $img_r = imagecreatefrompng($src);
        break;
    case 'GIF':
        $img_r = imagecreatefromgif($src);
        break;
    case 'BMP':
        $img_r = imagecreatefrombmp($src);
        break;
}


$larg_foto = $_POST['w'];
$alt_foto = $_POST['h'];
$fator = $alt_foto / $larg_foto;
$altura_nova = $larg;

switch ($indice) {

    case "1":
        $mddX1 = 263;
        $mddY1 = ( 263 * $fator);
        break;
    case "2":
        $mddX1 = 750;
        $mddY1 = ( 750 * $fator);
        break;
    case "3":
        $mddX1 = 550;
        $mddY1 = ( 550 * $fator);
        break;
}



$dst_r2 = ImageCreateTrueColor($mddX1, $mddY1);
imagecopyresampled($dst_r2, $img_r, 0, 0, $_POST['x1'], $_POST['y1'], $mddX1, $mddY1, $_POST['w'], $_POST['h']);

$folder = strtoupper(md5(uniqid(rand(), true)));
$caminho = "../upload/thumbs/" . $folder;
$filename = $caminho . "/" . strtoupper(md5(uniqid(rand(), true))) . "." . pathinfo($src, PATHINFO_EXTENSION);

mkdir($caminho, 0777, true);

switch ($extensao) {
    case 'JPG':
        imagejpeg($dst_r2, $filename, $jpeg_quality);
        break;
    case 'JPEG':
        imagejpeg($dst_r2, $filename, $jpeg_quality);
        break;
    case 'PNG':
        imagepng($dst_r2, $filename, 9 / 100);
        break;
    case 'GIF':
        imagegif($dst_r2, $filename, $jpeg_quality);
        break;
    case 'BMP':
        imagewbmp($dst_r2, $filename, $jpeg_quality);
        break;
}

$filename = str_replace("../", "/web-files/", $filename);


switch ($indice) {
    case 1:
        if (file_exists(str_replace("/web-files/", "../", $foto->CROP268))) {
            @unlink(str_replace("/web-files/", "../", $foto->CROP268));
            $dir = explode("/", $foto->CROP268);
            $diretorio = "../" . $dir[2] . "/" . $dir[3] . "/" . $dir[4] . "/";
            if (is_dir($diretorio)) {
                @rmdir($diretorio);
            }
        }
        $dados["CROP268"] = $filename;
        break;
    case 2:
        if (file_exists(str_replace("/web-files/", "../", $foto->CROP770))) {
            @unlink(str_replace("/web-files/", "../", $foto->CROP770));
            $dir = explode("/", $foto->CROP770);
            $diretorio = "../" . $dir[2] . "/" . $dir[3] . "/" . $dir[4] . "/";
            if (is_dir($diretorio)) {
                @rmdir($diretorio);
            }
        }
        $dados["CROP770"] = $filename;
        break;
    case 3:
        if (file_exists(str_replace("/web-files/", "../", $foto->CROP550))) {
            @unlink(str_replace("/web-files/", "../", $foto->CROP550));
            $dir = explode("/", $foto->CROP550);
            $diretorio = "../" . $dir[2] . "/" . $dir[3] . "/" . $dir[4] . "/";
            if (is_dir($diretorio)) {
                @rmdir($diretorio);
            }
        }
        $dados["CROP550"] = $filename;
        break;
}
if($model->update_thumbs($dados, $codfoto)){
    echo "Crop realizado com sucesso!";
}else{
    echo "Ocorreu um erro ao tentar fazer o crop!";
}


*/