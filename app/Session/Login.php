<?php

  namespace App\Session;

  class Login {

    /**
     * Método responável por iniciar a sessão
     */
    private static function init() {
      // verifia o status da sessão
      if (session_status() !== PHP_SESSION_ACTIVE) {
        // inicia a sessão, criando o cookie necessário
        session_start();
      }
    }

    /**
     * Método responável por retornar os dados do usuário logado
     * @return array
     */
    public static function getUsuarioLogado() {
      // Inicia a sessão
      self::init();

      // retorna dados do usuário
      return self::isLogged() ? $_SESSION['usuario'] : null;
    }

    /**
     * Método responsável por logar o usuário, criando a sessão
     * @param Usuario
     */
    public static function login($obUsuario) {
      // Inicia a sessão
      self::init();

      // Variável global, sessão de usuário
      $_SESSION['usuario'] = [
        'id'    => $obUsuario->id,
        'nome'  => $obUsuario->nome,
        'email' => $obUsuario->email
      ];

      // Redireciona o usuário para a index
      header('location: index.php');
      exit;
    }

    /**
     * Método responsável por deslogar o usuário
     */
    public static function logout() {
      // Inicia a sessão
      self::init();

      // Remove a sessão de usuário
      unset($_SESSION['usuario']);

      // Redireciona o usuário para o login
      header('location: login.php');
      exit;
    }

    /**
     * Método responsável por verificar
     * se o usuário está logado.
     * @return boolean
     */
    public static function isLogged() {
      // Inicia a sessão
      self::init();

      // Validação da sessão
      return isset($_SESSION['usuario']['id']);
    }

    /**
     * Método responsável por obrigar o
     * usuário a estar logado para acessar
     */
    public static function requireLogin() {
      if (!self::isLogged()) {
        // Sempre usar o exit após o header location
        // assim evitando saida de códigos indesejados
        header('location: login.php');
        exit;
      }
    }

    /**
     * Método responsável por obrigar o
     * usuário a estar deslogado para acessar
     */
    public static function requireLogout() {
      if (self::isLogged()) {
        // Sempre usar o exit após o header location
        // assim evitando saida de códigos indesejados
        header('location: index.php');
        exit;
      }
    }

  }

?>