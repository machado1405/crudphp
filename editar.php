<?php 

  require __DIR__.'/vendor/autoload.php';
  define('TITLE', 'Editar vaga');
  use \App\Entity\Vaga;

  // Validação do id
  if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
  }

  // Consulta a vaga
  $obVaga = Vaga::getVaga($_GET['id']);

  // validar a existencia da vaga
  if (!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
  }

  // validação
  if (isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])) {
    $obVaga->titulo    = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo     = $_POST['ativo'];
    //$obVaga->cadastrar();

    // sempre que usar um redirecionamento,
    // utilizar o exit para impedir o
    // carregamento do resto da página
    header('location: index.php?status=success');
    exit;
  }

  include __DIR__.'/includes/header.php';
  include __DIR__.'/includes/formulario.php';
  include __DIR__.'/includes/footer.php';

?>