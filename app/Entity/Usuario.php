<?php 

  // nomeando namespace
  namespace App\Entity;
  // inclusão da classe Database, para ligações com o banco de dados
  use \App\Db\Database;
  // Inclsuão do pdo, classe que possui padroes de comunicação com banco de dados
  use \PDO;

  class Usuario {

    /**
     * Identificador do usuário
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * Email do usuário
     * @var string
     */
    public $email;

    /**
     * Hash da senha do usuário
     * @var string
     */
    public $senha;

    /**
     * Método responsável por cadastrar um usuário no banco
     * @return boolean
    */
    public function cadastrar() {
      // Database
      $obDatabase = new Database('usuarios');

      // Insere um novo usuário
      $this->id = $obDatabase->insert([
        'nome'  => $this->nome,
        'email' => $this->email,
        'senha' => $this->senha
      ]);

      // Sucesso
      return true;
    }

    /**
     * Método responável por retornar uma instância do usuario
     * com base no seu e-mail
     * @return Usuario
     */
    public static function getUsuarioPorEmail($email) {
      return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

  }

?>