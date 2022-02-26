<?php 

  require __DIR__.'/vendor/autoload.php';

  use \App\Entity\Usuario;
  use \App\Session\Login;

  // Desloga o usuário
  Login::logout();
  
?>