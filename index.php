<?php 

  require __DIR__.'/vendor/autoload.php';

  use \App\Entity\Vaga;
  use \App\Db\Pagination;
  use \App\Session\Login;

  // Obriga o usuário a estar logado
  Login::requireLogin();

  // Busca, filter input pede 2 parametros, primeiro o tipo
  // se é get/post/put/delete etc... e o segundo é o nome do input
  // que foi inserido na tag name="", e o terceiro é o tipo de filtro
  $busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

  // filtro de status
  $filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);
  $filtroStatus = in_array($filtroStatus, ['s', 'n']) ? $filtroStatus : '';
  
  // condições sql para efetuar a busca
  $condicoes = [
    strlen($busca) ? 'titulo LIKE "%'.str_replace(' ', '%', $busca).'%"' : null,
    strlen($filtroStatus) ? 'ativo = "'.$filtroStatus.'"' : null
  ];

  // remove posições vazias da string
  $condicoes = array_filter($condicoes);

  // cláusula where, implode a string adicionando o and para concatenar
  $where = implode(' AND ', $condicoes);

  // quantidade total de vagas
  $quantidadeVagas = Vaga::getQuantidadeVagas($where);

  // paginação
  $obPagination = new Pagination($quantidadeVagas, $_GET['pagina'] ?? 1, 5);
  
  // chamada das vagas
  $vagas = Vaga::getVagas($where, null, $obPagination->getLimit());

  // includes das páginas e componentes necessários
  //  para compor a página
  include __DIR__.'/includes/header.php';
  include __DIR__.'/includes/listagem.php';
  include __DIR__.'/includes/footer.php';

?>