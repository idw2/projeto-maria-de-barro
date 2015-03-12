--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE IF NOT EXISTS `conta` (
  `CODCONTA` char(32) NOT NULL DEFAULT '',
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NOME` varchar(70) DEFAULT NULL,
  `EMAIL` varchar(32) DEFAULT NULL,
  `SENHA` char(32) DEFAULT NULL,
  `SEXO` char(1) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL,
  PRIMARY KEY (`CODCONTA`)
);

INSERT INTO `conta` (`CODCONTA`, `NOME`, `EMAIL`, `SENHA`, `STATUS`) VALUES
('71F8F8E9B09606EE49C65E9CC20F5927', 'Webmaster Designlab', 'contato@designlab.com.br', '9241E1A4CAD0A7D0BDD5E24DED3B3B8E', 1);


CREATE TABLE IF NOT EXISTS `fotos` (
  `CODFOTO` char(32) NOT NULL DEFAULT '',
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RAIZ` varchar(255) DEFAULT NULL,
  `FORMATO` varchar(255) DEFAULT NULL,
  `NOME` varchar(255) DEFAULT NULL,
  `TIPO` varchar(30) DEFAULT NULL,
  `ORIGINAL` varchar(255) DEFAULT NULL,
  `CROP` varchar(255) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL,
  `ORDEM` int(11) DEFAULT NULL,
  `DESTAQUE` char(1) DEFAULT '0',
  PRIMARY KEY (`CODFOTO`)
);

CREATE TABLE IF NOT EXISTS `fotos_rel_produtos` (
  `CODFOTO` char(32) NOT NULL DEFAULT '',
  `CODPRODUTO` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`CODFOTO`, `CODPRODUTO`)
);

-- http://www.webresourcesdepot.com/dynamic-dragn-drop-with-jquery-and-php/
-- http://www.webresourcesdepot.com/wp-content/uploads/file/jquerydragdrop/
-- http://www.webresourcesdepot.com/dynamic-dragn-drop-with-jquery-and-php/
-- http://johnny.github.io/jquery-sortable/




