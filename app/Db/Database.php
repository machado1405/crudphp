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

    // Nétodo responsável por executar queries dentro do banco de dados
    public function execute ($query, $params = []) {
      // executa  ação no banco corretamente, seguindo os padroes
      // da PDO, para insert, delete, update não se faz tão necessário
      // porém para uma query de consulta(select) é recomendado
      try {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
      } catch(PDOException $e) {
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

      // Array values, passa somente os valores do array,
      // porem precisa que os índices sejam numéricos, por isso
      // utilizou-se o a array_keys.
      // Executa o insert.
      $this->execute($query, array_values($values));

      // Retorna por padrão o último id inserio no banco
      return $this->connection->lastInsertId();
    }

    // Método responsável por realizar uma consulta no banco de dados
    public function select($where = null, $order = null, $limit = null, $fields = '*') {
      // dados da query
      $where = strlen($where) ? 'WHERE '. $where : '';
      $order = strlen($order) ? 'ORDER BY '. $order : '';
      $limit = strlen($limit) ? 'LIMIT '. $limit : '';

      // monta a query
      $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

      // executa a query
      return $this->execute($query);
    }

    // executa atualizações no banco de dados
    public function update($where, $values) {
      // dados da query
      $fields = array_keys($values);

      // monta a query
      $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

      // executa a query
      $this->execute($query, array_values($values));

      // retorna o sucesso
      return true;
    }

    // Método responsáve por excluir dados do banco
    public function delete($where) {
      // monta a query
      $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

      // executa a query
      $this->execute($query);

      // retorna o sucesso
      return true;
    }

  }

?>