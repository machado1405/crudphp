<?php 

  namespace App\Db;

  use Exception;
  use \PDO;
  use \PDOException;

  class Database {

    // Host de conexão com o banco de dados
    const HOST = 'localhost';
    const NAME = 'vagas';
    const USER = 'root';
    const PASS = '';

    // Define a tabela a ser modificada
    private $table;
    // Estabelece a conexao com o banco PDO.
    private $connection;

    public function __construct($table = null){
      $this->table = $table;
      $this->setConnection();
    }

    // Método responsável por estabelecer a conexão
    private function setConnection() {
      try {
        $this->connection = new PDO("mysql:host=".self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
        // seta erros caso ocorra no banco, facilitando
        // entendimento, assim lança uma exception caso 
        // ocorra qualquer problema ao conectar, ou
        // realizar alguma operação no banco de dados
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        // A carater de estudo pode-se utilizar a mensagem
        // porém em um sistema em produção, não mostrar para o
        // usuário os erros, salvar a mensagem em um log, e 
        // converter para uma mensagem mais amigável ao usuário
        die("ERROR:" . $e->getMessage());
      }
    }

    // Método responsável por inserir dados no banco chave valor
    // retornando o id
    public function insert($values) {
      // Dados da query
      $fields = array_keys($values);
      $binds  = array_pad([], count($fields), '?');
      
      // monta a query
      $query = 'INSERT INTO ' .$this->table.' ('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';

      echo $query;
      exit;
    }

  }

?>