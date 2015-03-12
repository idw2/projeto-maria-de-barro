-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 10-Mar-2015 às 13:47
-- Versão do servidor: 5.5.38-35.2
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `maria951_blog`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(6) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(40) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `title`, `slug`, `description`) VALUES
(1, 'Sem categoria', 'sem-categoria', 'Sem categoria'),
(2, 'Moda e Estilo', 'moda-e-estilo', ''),
(3, 'Beleza', 'beleza', ''),
(4, 'Inspiração', 'inspiraco', ''),
(5, 'Produtos', 'produtos', ''),
(6, 'Liqui', 'liqui', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int(6) NOT NULL,
  `post` int(6) NOT NULL,
  `status` enum('pending','approved','spam') NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(140) NOT NULL,
  `email` varchar(140) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_extend`
--

CREATE TABLE IF NOT EXISTS `blog_extend` (
  `id` int(6) NOT NULL,
  `type` enum('post','page') NOT NULL,
  `field` enum('text','html','image','file') NOT NULL,
  `key` varchar(160) NOT NULL,
  `label` varchar(160) NOT NULL,
  `attributes` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_extend`
--

INSERT INTO `blog_extend` (`id`, `type`, `field`, `key`, `label`, `attributes`) VALUES
(1, 'post', 'image', 'thumbnail', 'Thumbnail', '{"type":"","size":{"width":"120","height":"120"}}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_meta`
--

CREATE TABLE IF NOT EXISTS `blog_meta` (
  `key` varchar(140) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_meta`
--

INSERT INTO `blog_meta` (`key`, `value`) VALUES
('auto_published_comments', '0'),
('comment_moderation_keys', ''),
('comment_notifications', '0'),
('current_migration', '140'),
('custom_facebook', 'https://www.facebook.com/mariadebarroacessorios'),
('custom_google-plus', 'https://plus.google.com/u/0/113176039094986209102/posts'),
('custom_instagram', 'http://instagram.com/mariadebarro'),
('custom_twitter', 'https://twitter.com/Maria_de_barro'),
('date_format', 'jS M, Y'),
('description', 'A Maria do Barro é a uma loja de acessórios online dedicada especialmente ao público feminino.Tendo uma proposta variada e moderna com o objetivo de oferecer as nossas clientes os melhores produtos.  Pois estamos sempre buscando as principais tendências em acessórios.'),
('home_page', '1'),
('last_update_check', '2015-02-05 13:30:48'),
('posts_page', '1'),
('posts_per_page', '6'),
('sitename', 'Maria de Barro'),
('theme', 'default'),
('update_version', '0.9.2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_pages`
--

CREATE TABLE IF NOT EXISTS `blog_pages` (
  `id` int(6) NOT NULL,
  `parent` int(6) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `status` enum('draft','published','archived') NOT NULL,
  `redirect` text NOT NULL,
  `show_in_menu` tinyint(1) NOT NULL,
  `menu_order` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_pages`
--

INSERT INTO `blog_pages` (`id`, `parent`, `slug`, `name`, `title`, `content`, `status`, `redirect`, `show_in_menu`, `menu_order`) VALUES
(1, 0, 'posts', 'Posts', 'Maria de Barro', '', 'published', '', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_page_meta`
--

CREATE TABLE IF NOT EXISTS `blog_page_meta` (
  `id` int(6) NOT NULL,
  `page` int(6) NOT NULL,
  `extend` int(6) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(6) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `html` text NOT NULL,
  `css` text NOT NULL,
  `js` text NOT NULL,
  `created` datetime NOT NULL,
  `author` int(6) NOT NULL,
  `category` int(6) NOT NULL,
  `status` enum('draft','published','archived') NOT NULL,
  `comments` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `description`, `html`, `css`, `js`, `created`, `author`, `category`, `status`, `comments`) VALUES
(5, 'Sessentinha', 'sessentinha', '', 'Por aqui, todo mundo adora roubar as peças vintage do armário da Vó e misturar com as nossas roupas novas. Mas você já parou para pensar como mãe da sua mãe se arrumava para ir às festas na época que os vestidos de bolinha eram a última moda? O fotógrafo ***Arthur Schatz*** pode matar nossa curiosidade. Em plenos anos 60, ele capturou imagens lindinhas dos jovens durante os intervalos nas aulas da faculdade, que mostram exatamente seus estilos na época. Prontas para uma viagem no tempo? \r\n\r\n![awebic-moda-anos-60-3.jpg](http://blog.mariadebarro.com.br/content/awebic-moda-anos-60-3.jpg)\r\n\r\nNa Maria de Barro a tendência sessentinha já chegou, e trouxe com ela aquele toque romântico e uma pitadinha de ousadia para deixar o seu look ainda mais incrível! Inspire-se!\r\n\r\n![sixties.png](http://blog.mariadebarro.com.br/content/sixties.png)\r\n\r\n**Gostou? É só passar lá no site:**\r\n\r\n1. Brinco dourado com base oval e pendente - [http://bit.ly/1DiEaw1](http://bit.ly/1DiEaw1)\r\n2. Colar dourado de madre perola com franja - [http://bit.ly/1zcB5ai](http://bit.ly/1zcB5ai)\r\n3. Brinco pequeno branco com duas pérolas - [http://bit.ly/1IaflXb](http://bit.ly/1IaflXb)\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '', '', '2015-02-05 18:05:16', 1, 4, 'published', 1),
(6, 'Cabelos de Sereia', 'cabelos-de-sereia', '', 'A trança espinha de peixe é um daqueles penteados despretensiosos que caem bem tanto para um fim de tarde na praia quanto para uma noite de gala. Não atoa, ele já é  o queridinho entre celebridades como Blake Lively, a cantora Rihanna e até a super clássica Jennifer Aniston.\r\n\r\n![trança-valendo.jpg](http://blog.mariadebarro.com.br/content/tran-a-valendo.jpg)\r\n\r\n\r\nQue o visual é versátil e cai bem todo, mundo já sabia. Mas vamos combinar que esse tipo de amarração, pelo menos ao olhar, não parece nem um pouco fácil de resolver. Por isso… tan tan tan tan! Separamos um diy da trança espinha de peixe que vai tornar as nossas manhãs muito mais fáceis. Olha só:\r\n\r\n![passo-a-passo-trança-espinha-de-peixe.jpg](http://blog.mariadebarro.com.br/content/passo-a-passo-tran-a-espinha-de-peixe.jpg)\r\n\r\n![trança-espinha-de-peixe-passo-a-passo.jpg](http://blog.mariadebarro.com.br/content/tran-a-espinha-de-peixe-passo-a-passo.jpg)\r\n\r\nO resultado? Ah, esse todo mundo já conhece.\r\n\r\n\r\n', '', '', '2015-02-06 16:43:12', 1, 3, 'published', 1),
(7, 'Gordice de Sexta', 'gordice-de-sexta', '', 'Ela viaja o mundo, descobre delícias locais e gera imagens de dar água na boca para postar no seu perfil no Instagram. Esse é o trabalho da *Melissa*, que, com um iphone 5 na mão e muita gordice na cabeça, criou o projeto **“Girl Eat World"**.\r\n\r\n![follow-the-colours-girl-eat-world-tokio1-600x322.png](http://blog.mariadebarro.com.br/content/follow-the-colours-girl-eat-world-tokio1-600x322.png)\r\n\r\n![follow-the-colours-girl-eat-world-london.jpg](http://blog.mariadebarro.com.br/content/follow-the-colours-girl-eat-world-london.jpg)\r\n\r\n![follow-the-colours-girl-eat-world-Rothenburg.jpg](http://blog.mariadebarro.com.br/content/follow-the-colours-girl-eat-world-Rothenburg.jpg)\r\n\r\nUma ótima ideia para se inspirar para o fim de semana, não? **Wanderlust! **\r\n\r\n\r\n\r\n', '', '', '2015-02-06 18:10:41', 1, 4, 'published', 1),
(8, 'Verão Fresquinho', 'vero-fresquinho', '', 'Verão chegando, biquíni na fila do armário e nada mais cool que soltar, na mesa com amigos, a seguinte frase: “eu não tomo refrigerantes, obrigada!”. Quem concorda com a gente, vai gostar da novidade. A nossa equipe é adepta do estilo de vida leve e descobriu uma receita de refrigerante feito em casa que, além de preservar nosso corpo dos conservantes e açúcares em excesso,  é muito mais déli do que os normais. Caneta e papel na mão? \r\n\r\n**Você vai precisar de:**\r\n*4 rodelas de abacaxi\r\n1 maçã Fuji\r\n1 colher (sopa) de agave\r\n1 sachê de chá branco orgânico\r\n1 xícara de água filtrada\r\n6 folhas de hortelã\r\nÁgua com gás e gelo*\r\n\r\n**Mão na massa (ou no líquido):**\r\nFerva a água e deixe o sachê do chá branco agir por um minuto junto com as folhas de hortelã. Retire as folhas de hortelã e adicione o chá pronto no liquidificador com a maçã e o abacaxi. Coe e reserve na geladeira. A mistura pode ser mantida em refrigerada  por até 4 dias.\r\n\r\n**Refrescante, né?**\r\n\r\n![d6dd00848c49d2162c00a17bd4df6b72.jpg](http://blog.mariadebarro.com.br/content/d6dd00848c49d2162c00a17bd4df6b72.jpg)', '', '', '2015-02-09 18:08:12', 1, 4, 'published', 1),
(9, 'Amarradas', 'amarradas', '', 'Alguém ainda duvida que o lenço estampado na cabeça é o nosso truque de beautè da temporada? Com os cabelos soltos ou presos num coque alto, é só apostar nos tecidos com nó para um visual com a cara do verão, seja ele nórdico ou tropical. Veja nossas inspirações de amarração e tente você também !\r\n\r\nNo coque:\r\n![no-coque.jpg](http://blog.mariadebarro.com.br/content/no-coque.jpg)\r\n\r\nNa praia:\r\n![na-praia.jpg](http://blog.mariadebarro.com.br/content/na-praia.jpg)\r\n\r\nNa franja:\r\n![franja.jpg](http://blog.mariadebarro.com.br/content/franja.jpg)\r\n\r\n\r\n\r\n\r\n\r\n', '', '', '2015-02-09 18:10:18', 1, 2, 'published', 1),
(10, 'Trend-Alert: Flash Tattoo', 'trend-alert-flash-tattoo', '', 'Quem acompanha blogs de street style já deve ter visto uma tendência que ganhou força no verão: As Flash Tattoos, que são tatuagens metálicas temporárias que lembram jóias. A ideia é essa mesmo, fingir que você está toda produzida e cheia de acessórios em qualquer lugar, inclusive na praia.\r\n\r\n![flashtattsinspo (1).jpg](http://blog.mariadebarro.com.br/content/flashtattsinspo-1.jpg)\r\n\r\nA ideia não é novidade, quem lembra daquelas tatuagens temporárias que a Channel lançou há alguns anos atrás? Mas essa aqui é bem mais democrática já que os preços variam e chegam, no máximo, a U$25 a cartela com vários desenhos.\r\n\r\nNós amamos a novidade e estamos adorando ver os looks fresquinhos e descontraídos de verão ganhando mais glamour. E o legal é que você pode combinar com as suas bijoux!\r\n\r\n\r\n', '', '', '2015-02-10 17:37:04', 1, 2, 'published', 1),
(11, 'Tá quente!', 'ta-quente', '', 'Todo verão tem aquela lista de tendências que viram hits absolutos e, quando você menos percebe, já está usando. Quer saber tudo o que está rolando, do dress code da praia aos drinks da moda? Algumas das dicas tem cara de “já te vi”, outras, se você ainda não aderiu, pode botar wishlist da temporada:\r\n\r\n**1.  Óculos espelhados** - \r\nRedondos ou mais quadrados, grandes ou menores, a bossa é abusar das lentes coloridas com armações neutras.\r\n\r\n![3667f2452bb93640c5202f2b391590b9.jpg](http://blog.mariadebarro.com.br/content/3667f2452bb93640c5202f2b391590b9.jpg)\r\n\r\n**2. Bolsa étnica** -\r\nA tendência já passou pelas roupas, brincos e agora se estendeu às bolsas. Você pode até levar a sua para passear a noite, mas cool mesmo é carregá-la para a praia cheia de produtos para os cuidados com pele e cabelo.\r\n\r\n![15d40e9302c3bf6f10b7fd79ad8514b1.jpg](http://blog.mariadebarro.com.br/content/15d40e9302c3bf6f10b7fd79ad8514b1.jpg)\r\n\r\n**3. My name is “Hugo”** - \r\nParece nome de personagem de desenho animado, mas o Hugo é o novo Spritz na jarra lá nas bandas do caribe. Feito da mistura de prosseco, soda, limão e hortelã, é perfeito para beber a beira da piscina.\r\n\r\n![csm_mood-04-01-22-04-0001_hugo_drink_6cefd5c46c-652x328.jpg](http://blog.mariadebarro.com.br/content/csm_mood-04-01-22-04-0001_hugo_drink_6cefd5c46c-652x328.jpg)\r\n\r\n- Tomou nota?\r\n\r\n\r\n\r\n\r\n\r\n ', '', '', '2015-02-10 17:51:43', 1, 2, 'published', 1),
(12, 'Meu Bloco na Rua', 'meu-bloco-na-rua', '', 'Alo, alo, galera da folia! Falta só 1 dia para o carnaval começar oficialmente – isso porque, sabemos, para alguns a festa já tá rolando desde a virada do mês – e chegou a tão esperada hora de tirar a fantasia do armário.\r\nOi? Você ainda não providenciou a sua indumentária colorida e cheia de purpurina? Então chega mais que a gente tem um monte de ideias de adereços simples e super fácies de achar para você fazer bonito nos bloquinhos de rua Brasil afora.\r\n\r\n**1. Carmem Miranda** - \r\nEssa é fácil, vai! Frutas, estampas, turbante na cabeça e muito gingado já bastam pra mostrar pro mundo “o que é que a baiana tem”.\r\n\r\n![10947381_838932669504945_9030884511155484970_o.jpg](http://blog.mariadebarro.com.br/content/10947381_838932669504945_9030884511155484970_o.jpg)\r\n\r\n**2. Máscaras e óculos divertidos.** - \r\nQuem nunca? É só vestir pra entrar no clima!\r\n\r\n![10421447_838933339504878_2377126500436861381_n (1).jpg](http://blog.mariadebarro.com.br/content/10421447_838933339504878_2377126500436861381_n-1.jpg)\r\n\r\n\r\n**3. A melhor dica de todas** - \r\nA bordo de qualquer fantasia, não esqueça o mais importante: reúna seus amigos, cante, dance e vista-se de alegria!\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '', '', '2015-02-12 18:20:18', 1, 4, 'published', 1),
(13, 'Franjinhas', 'franjinhas', '', 'A gente sempre quer mudar algo na nossa aparência, né? Quando vem esse “plim” de mudança, na maioria das vezes nossos cabelos acabam sendo nosso principal alvo! Também, é fácil entender o porquê: Cortou, não gostou, cresce de novo! Ainda bem que atualmente podemos dispor de uma infinidade de cores, estilos e cortes para podermos mudar o quanto quisermos, e, também, da ajuda da internet pra nos inspirar a fazer tudo isso. Então que tal começar pela franja? Separamos alguns tipos de cortes para você escolher qual combina mais com você!\r\n\r\n**1.** A clássica franjinha arredondada.\r\n\r\n![franjinha-curta-cortando-a-franja.jpg](http://blog.mariadebarro.com.br/content/franjinha-curta-cortando-a-franja.jpg)\r\n\r\n**2.** A franja de lado, ou a franja "arredondada que cresceu".\r\n\r\n![franjinha-curta-de-lado-cortando-a-franja-b.jpg](http://blog.mariadebarro.com.br/content/franjinha-curta-de-lado-cortando-a-franja-b.jpg)\r\n\r\n\r\n\r\n\r\n', '', '', '2015-02-23 15:22:17', 1, 2, 'published', 1),
(14, 'A culpa é das Estrelas', 'a-culpa-e-das-estrelas', '', 'A culpa é delas! Sim, estamos falando das estrelas. Lembra daquela blusinha com estampa de estrelinha que você tem há um tempão? Pois é, se você achou que era coisa ultrapassada pode tirar ela do armário porque voltou com tudo depois de vários desfiles famosos lá na griga. \r\n\r\n![estrelinhas5.jpg](http://blog.mariadebarro.com.br/content/estrelinhas5.jpg)\r\n\r\nElas até ficaram meio esquecidas (estampa galaxy não conta, né?) mas depois de investirmos em estampa floral, animal, geométrica e listras, as estrelas voltaram a brilhar! Então se prepara pra essa constelação que promete invadir a moda em 2015!\r\n\r\n![estrelinhas3.jpg](http://blog.mariadebarro.com.br/content/estrelinhas3.jpg)\r\n\r\n\r\n\r\n', '', '', '2015-02-27 19:49:10', 1, 2, 'published', 1),
(15, 'As cores que serão tendência em 2015', 'as-cores-que-sero-tendencia-em-2015', '', 'O ano mal começou e já veio com muito estilo! No mundinho fashion muita gente já fala em algumas tendências que possivelmente irão pegar por aqui, como a vibe anos 70, tecidos fluídos, roupas navy e muito mais. Nisso, três cores bem diferentes entre sí também estão em foco agora: O *laranja*, o *azul celeste* e o *vinho marsala*. Quer ver algumas inspirações de como usar essas cores no seu dia a dia de um jeito bem fácil? Olha só!\r\n\r\n**MARSALA**\r\nEssa cor de nome diferente pode até te fazer pensar que não a conhecia, mas na realidade é como se fosse a união do marrom com um vermelho.\r\n\r\n\r\n![marsala-cor-2015.jpg](http://blog.mariadebarro.com.br/content/marsala-cor-2015.jpg)\r\n\r\n\r\n**AZUL CELESTE**\r\nEsse tom de azul, um pouco puxado para o azul bebê, promete vir elegante e discreto direto para os nossos guarda-roupas.\r\n\r\n\r\n![azul-celeste-cor-2015.jpg](http://blog.mariadebarro.com.br/content/azul-celeste-cor-2015.jpg)\r\n\r\n\r\n**LARANJA**\r\nO laranja vai pegar agora bem no início do ano, enquanto ainda estamos no verão.\r\n\r\n\r\n![laranja-cor-tendencia-2015.jpg](http://blog.mariadebarro.com.br/content/laranja-cor-tendencia-2015.jpg)\r\n\r\n\r\n', '', '', '2015-03-03 20:26:32', 1, 2, 'published', 1),
(16, 'Nail art: 101 Dalmatas', 'nail-art-101-dalmatas', '', '![disney-dalmata.jpg](http://blog.mariadebarro.com.br/content/disney-dalmata.jpg)\r\n\r\n\r\nO formato dessa nail art é o “minimalista”, ótimo para quem está começando a se aventurar no mundo das artes nas unhas por ter desenhos super fáceis de fazer e pouquíssimos detalhes. O resultado fica super delicado e, para fazer em casa, você vai precisar de: \r\n\r\n1. Esmaltes nas cores: branco, preto, vermelho e dourado. \r\n2. Para os desenhos, você pode usar um pincel fininho para nail art, um grampo ou até mesmo um palito de dente. \r\n3. Algodão e removedor para limpar os cantinhos das unhas.\r\n\r\n\r\n![nail-art-dalmatas.jpg](http://blog.mariadebarro.com.br/content/nail-art-dalmatas.jpg)\r\n\r\n\r\nProntinho! ', '', '', '2015-03-06 20:45:01', 1, 3, 'published', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_post_meta`
--

CREATE TABLE IF NOT EXISTS `blog_post_meta` (
  `id` int(6) NOT NULL,
  `post` int(6) NOT NULL,
  `extend` int(6) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_post_meta`
--

INSERT INTO `blog_post_meta` (`id`, `post`, `extend`, `data`) VALUES
(6, 5, 1, '{"name":"awebic-moda-anos-60-1.jpg","filename":"awebic-moda-anos-60-1.jpg"}'),
(7, 10, 1, '{"name":"flashtattsinspo.jpg","filename":"flashtattsinspo.jpg"}'),
(8, 12, 1, '{"name":"10421447_838933339504878_2377126500436861381_n.jpg","filename":"10421447_838933339504878_2377126500436861381_n.jpg"}'),
(9, 13, 1, '{"name":"topo-cortando-a-franja.jpg","filename":"topo-cortando-a-franja.jpg"}'),
(10, 14, 1, '{"name":"estrelinha-topo.jpg","filename":"estrelinha-topo.jpg"}'),
(11, 15, 1, '{"name":"topo-cores-2015.jpg","filename":"topo-cores-2015.jpg"}'),
(12, 16, 1, '{"name":"nail-art-dalmatas.jpg","filename":"nail-art-dalmatas.jpg"}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_sessions`
--

CREATE TABLE IF NOT EXISTS `blog_sessions` (
  `id` char(32) NOT NULL,
  `expire` int(10) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_sessions`
--

INSERT INTO `blog_sessions` (`id`, `expire`, `data`) VALUES
('0rYH7eSvT5mx601s7oa4elXDv708FGnj', 1426063705, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('3a6TiRnBjh6FWEHPY4pagGYq5QSUZUOT', 1426033535, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('3DTneprBBMnr2jbAuhVEwgQ0OjoSgGK0', 1426042641, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('5THs6RHOh9jchJ40r6XL1MpMa61QFEtQ', 1426011146, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('7BS4TqpryA4HscFGiZUvMMgxiCH51IbW', 1426031806, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('AlDZ16UqiUqXkVwmccg4UlaJNLIEbRei', 1426007651, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('b3wsccrHV7hfNzlLp8sok45IRuUzk1st', 1426065583, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('CfbIrwMf0wNMkLsqjp5TuvFWrvU6NPKV', 1426035443, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('hDKFam8KPf8Zo72HI04bz06CQSIZbTLy', 1426031844, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('IrY756q019MQ9FNWmGmGkkNDSnqXkKAD', 1426050995, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('jPIs2V8lV0CD9Lq7KHPQkSrTwaRANOYt', 1426040675, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('NIkAA1kVg7qOYgyxZFT122xpQtqct42e', 1426082395, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('Nw8XgSTDKsremkrKNnPGIuLtfY5O0Fiz', 1426040820, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('oJqR9N3M0akXUsQwWAVp0xoLDhgiWU0M', 1426085361, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('PRjotBAvkscfQn0ZWzF7vKt8apSD65ik', 1426035086, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('QOcSov2OmAfNbb5BQxK3Mji9xWRp0rFQ', 1426078383, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('RHoDV1Zb8g6MIlEfCBF3wBgKZIFH7Jym', 1426090137, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}'),
('YfIQflO2wUn0NJmAW5qxTKMAZTz4UGXH', 1426079905, 'a:2:{s:4:"_out";a:0:{}s:3:"_in";a:0:{}}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `blog_users`
--

CREATE TABLE IF NOT EXISTS `blog_users` (
  `id` int(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(140) NOT NULL,
  `real_name` varchar(140) NOT NULL,
  `bio` text NOT NULL,
  `status` enum('inactive','active') NOT NULL,
  `role` enum('administrator','editor','user') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `blog_users`
--

INSERT INTO `blog_users` (`id`, `username`, `password`, `email`, `real_name`, `bio`, `status`, `role`) VALUES
(1, 'admin', '$2a$10$PBfF6Qc3IDjRMFd07OzYm.nMRfmJNdQShv4E1Ll1aHwS5cbe/jiFy', 'joao@designlab.com.br', 'Administrator', 'The bouse', 'active', 'administrator'),
(2, 'joker', '$2a$10$pMETdvFm1vL36622hTGQS.W.Ho2QHExtiTQnQkJP5TMwoTLHDh98a', 'joao@designlab.com.br', 'João Ahmad', '', 'active', 'administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`), ADD KEY `post` (`post`), ADD KEY `status` (`status`);

--
-- Indexes for table `blog_extend`
--
ALTER TABLE `blog_extend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_meta`
--
ALTER TABLE `blog_meta`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `blog_pages`
--
ALTER TABLE `blog_pages`
  ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`), ADD KEY `slug` (`slug`);

--
-- Indexes for table `blog_page_meta`
--
ALTER TABLE `blog_page_meta`
  ADD PRIMARY KEY (`id`), ADD KEY `page` (`page`), ADD KEY `extend` (`extend`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`), ADD KEY `slug` (`slug`);

--
-- Indexes for table `blog_post_meta`
--
ALTER TABLE `blog_post_meta`
  ADD PRIMARY KEY (`id`), ADD KEY `post` (`post`), ADD KEY `extend` (`extend`);

--
-- Indexes for table `blog_sessions`
--
ALTER TABLE `blog_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_users`
--
ALTER TABLE `blog_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blog_extend`
--
ALTER TABLE `blog_extend`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blog_pages`
--
ALTER TABLE `blog_pages`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blog_page_meta`
--
ALTER TABLE `blog_page_meta`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `blog_post_meta`
--
ALTER TABLE `blog_post_meta`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `blog_users`
--
ALTER TABLE `blog_users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
