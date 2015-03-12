<?php

/*
 * rogerio.pontes
 * 
 * //chamando a classe
 * require_once("Crop.class.php");
 * $crop = new Crop();
 *
 * // [x][y] = coordenadas do corte
 * // [w][h] = tamanho da imagem
 * $crop->x = ?; //obrigatorio
 * $crop->y = ?; //obrigatorio
 * $crop->w = ?; //nao recomendado informar
 * $crop->h = ?; //nao recomendado informar
 *
 * //informe o diretorio raiz terminado em "/" para salvar o crop
 * $crop->path = "../upload/thumbs/";
 * 	 
 * //caso seja arquivos enviados requisicao $_FILES
 * $crop->SET_FILES($_FILES);
 * 
 * * //caso seja por requisicao $_FILES
 * $crop->src = "caminho/seu_arquivo.jpg";
 * 
 * //indicando o tamanho do crop, caso nao seja informado o valor padrao e 150
 * $crop->cropSize = 150;
 *
 * 
 */

class Crop {

    public $folder, $caminho, $newname, $caminho_imagem, $path, $x = 0, $y = 0, $w, $h, $cropSize = 150, $src, $quality = 100, $img_r, $targ_w, $targ_h, $dst_r;

    /*
     * funcao responsavel para setar a requisicao $_FILES
     */

    public function SET_FILES($_FILES) {
        if ($_FILES) {

            foreach ($_FILES as $_FILE) {

                foreach ($_FILE as $nome => $valor) {
                    $this->$nome = $_FILE[$nome];
                }
            }

            $this->SET();
        } else {
            return false;
        }
    }

    /*
     * retorna o nome da extensao: JPG,JPEG,PNG,GIF,BMP
     */

    public function EXT() {
        if (substr_count($this->src, ".tmp") >= 1) {
            return strtoupper(pathinfo($this->name, PATHINFO_EXTENSION));
        } else {
            return strtoupper(pathinfo($this->src, PATHINFO_EXTENSION));
        }
    }

    /*
     * funcao principal que configura os parametros do corte
     */

    public function SET() {

        if ($this->src == "") {
            $this->src = $this->tmp_name;
        }

        if (!file_exists($this->src)) {
            $this->ERROR("ERROR_SRC");
        } else {
            $ext = $this->EXT();

            if ($ext == "PNG") {
                $quality = 9 / 100;
            }

            $this->targ_w = $this->targ_h = $this->cropSize;
            $this->img_r = $this->CREATE_FROM($ext);
            $this->dst_r = $this->CREATE_COLOR();

            $this->img_r;
            $this->SIZE();

            $this->CROP();
            $this->SAVE();
        }
    }

    /*
     * funcao que seta a altura e a largura atual da imagem
     */

    public function SIZE() {
        if ($this->w == "" || $this->h == "") {
            $imnfo = getimagesize($this->src);
            $this->w = $imnfo[0];
            $this->h = $imnfo[1];
        }
    }

    /*
     * funcao que trata possiveis erros
     */

    public function ERROR($error) {
        if ($error == "ERROR_SRC") {
            die("Para continuar o crop e necessário setar a propriedade src, exemplo: [objeto]->src = 'caminho/seu_arquivo.jpg'; ");
        } elseif ($error == "NO_CROP") {
            die("Não existem parâmetros de coordenadas para realizar o crop, exemplo: [objeto]->x = ?,[objeto]->y = ?,[objeto]->w = ?,[objeto]->h = ?'; ");
        }
    }

    /*
     * funcao que cria uma copia da imagem atual deixando na area de transferencia
     */

    public function CREATE_FROM($extensao) {

        switch ($extensao) {
            case 'JPG':
                $img_r = imagecreatefromjpeg($this->src);
                break;
            case 'JPEG':
                $img_r = imagecreatefromjpeg($this->src);
                break;
            case 'PNG':
                $img_r = imagecreatefrompng($this->src);
                break;
            case 'GIF':
                $img_r = imagecreatefromgif($this->src);
                break;
            case 'BMP':
                $img_r = imagecreatefrombmp($this->src);
                break;
        }
        return $img_r;
    }

    /*
     * funcao que cria uma imagem vazia com o tamanho do crop
     */

    public function CREATE_COLOR() {
        return ImageCreateTrueColor($this->targ_w, $this->targ_h);
    }

    /*
     * funcao que corta a imagem
     */

    public function CROP() {
        imagecopyresampled($this->dst_r, $this->img_r, 0, 0, $this->x, $this->y, $this->targ_w, $this->targ_h, $this->w, $this->h);
    }

    public function SAVE() {

        $this->folder = strtoupper(md5(uniqid(rand(), true)));
        $this->caminho = $this->path . $this->folder;
        $this->newname = strtoupper(md5(uniqid(rand(), true))) . "." . pathinfo($src, PATHINFO_EXTENSION);


        @mkdir($this->caminho, true);

        while (!is_dir($this->caminho)) {
            $this->folder = strtoupper(md5(uniqid(rand(), true)));
            $this->caminho = $this->path . $this->folder;
            @mkdir($this->caminho, true);
        }

        $this->caminho_imagem = $this->caminho . "/" . $this->newname;

        switch ($extensao) {
            case 'JPG':
                imagejpeg($this->dst_r, $this->caminho_imagem, $quality);
                break;
            case 'JPEG':
                imagejpeg($this->dst_r, $this->caminho_imagem, $quality);
                break;
            case 'PNG':
                imagepng($this->dst_r, $this->caminho_imagem, 9 / 100);
                break;
            case 'GIF':
                imagegif($this->dst_r, $this->caminho_imagem, $quality);
                break;
            case 'BMP':
                imagewbmp($dst_r, $caminho_imagem, $quality);
                break;
        }
    }

}
