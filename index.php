<?php 

  require __DIR__.'/vendor/autoload.php';

  use \App\Entity\Vaga;

  // Busca, filter input pede 2 parametros, primeiro o tipo
  // se é get/post/put/delete etc... e o segundo é o nome do input
  // que foi inserido na tag name="", e o terceiro é o tipo de filtro
  $busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

  // filtro de status
  $filtroStatus = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
  $filtroStatus = in_array($filtroStatus, ['s', 'n']) ? $filtroStatus : '';
  
  // condições sql
  $condicoes = [
    strlen($busca) ? 'titulo LIKE "%'.str_replace(' ', '%', $busca).'%"' : null,
    strlen($filtroStatus) ? 'ativo = "'.$filtroStatus.'"' : null
  ];

  // remove posições vazias
  $condicoes = array_filter($condicoes);

  // cláusula where
  $where = implode(' AND ', $condicoes);

  $vagas = Vaga::getVagas($where);

  include __DIR__.'/includes/header.php';
  include __DIR__.'/includes/listagem.php';
  include __DIR__.'/includes/footer.php';

?>