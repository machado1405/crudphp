<?php 

  require __DIR__.'/vendor/autoload.php';
  define('TITLE', 'Cadastrar vaga');
  use \App\Entity\Vaga;
  use \App\Session\Login;

  // Obriga o usuário a estar logado
  Login::requireLogin();

  // Instância de vaga
  $obVaga = new Vaga;
  // validação
  if (isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])) {
    $obVaga->titulo    = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo     = $_POST['ativo'];
    $obVaga->cadastrar();

    // sempre que usar um redirecionamento,
    // utilizar o exit para impedir o
    // carregamento do resto da página
    header('location: index.php?status=success');
    exit;
  }
  // O VIDEO PAROU EM 1 HORA E 18 MINUTOS E 40 SEGUNDOS
  include __DIR__.'/includes/header.php';
  include __DIR__.'/includes/formulario.php';
  include __DIR__.'/includes/footer.php';

?>