<?php
//Inclui o SDK PHP do Facebook
require '../src/facebook.php';
 
//Cria uma instancia do Objeto Facebook passando seu appId e secret
$facebook = new Facebook(array(
  'appId'  => '753360414679096',
  'secret' => '4470f0ca277488f7cd1656bf8f0828a1',
));
 
//Define quais permissões vamos solicitar para a API
$perm = 'email';
 
//Cria uma variavel contendo a URL necessária para o usuário efetuar login
$urlLogin = $facebook->getLoginUrl(array('scope'=>$perm));
 
//Captura o UID do usuário logado. Caso ele não esteja logado este método retorna 0;
$user = $facebook->getUser();
 
if ($user) {
  try {
    // Teste para garantir que temos acesso ao usuário via API
    $facebook->api('/me');
  } catch (FacebookApiException $e) {
    // Se falhar atribuimos null para a variavel $usuario
    $user = null;
  }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Site com Facebook Login</title>
</head>
<body>
 
    <?php 
    //Verifica se o usuário está deslogado ou se ele ainda não deu as permissões.
    if (is_null($user) || $user==0) { 
        // Ele estando deslogado é apresentado o link para ele acessar o Facebook
        // e conceder as permissões solicitadas
    ?>
        <p>Olá visitante!</p>
        <a href="<?php echo $urlLogin;?>">Entrar com Facebook</a>
 
    <?php 
    } else {
        // Caso ele esteja logado e tenha dados as permissões
        // é preparadas uma query em FQL (Facebook Query Language)
        // para obter os dados desejados
        $fql = "SELECT uid, email, username, name, pic_square, profile_url, sex FROM user WHERE uid = me()";
 
        // A instrução abaixo utiliza o método api para executar a query em FQL
        // e retornar o resultado para a variável $result.
        // O resultado desta chamada conterá os dados solicitados formatados em um Array.
        $result = $facebook->api(array('method'=>'fql.query', 'query'=>$fql));
        $userData = $result[0];
    ?>
    <p>
        Nome: <?php echo $userData['name']; ?><br>
        username: <?php echo $userData['username']; ?><br>
        Link perfil: <?php echo $userData['profile_url']; ?><br>
        Email: <?php echo $userData['email']; ?><br>
        Sexo: <?php echo $userData['sex']; ?><br>
        ID: <?php echo $userData['uid']; ?><br>
    </p>
        <p><img src="<?php echo $userData['pic_square']; ?>" /></p>
 
    <?php }  ?>
    </p>
 
</body>
</html>