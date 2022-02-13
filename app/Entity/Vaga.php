<?php 

  namespace App\Entity;

  use App\Db\Database;
  use \PDO;
  
class Vaga {

  // Identificador único da vaga.
  public $id;
  // Título da vaga.
  public $titulo;
  // DEscrição detalhada da vaga.
  public $descricao;
  // Status da vaga cadastrada.
  public $ativo;
  // Data de publicação da vaga.
  public $data;

  // Método responsável pro excluir a vaga do banco
  public function excluir() {
    return (new Database('vagas'))->delete('id = '.$this->id);
  }

  // atualiza os dados no banco
  public function atualizar() {
    return (new Database('vagas'))->update('id = '.$this->id, [
      'titulo'    => $this->titulo,
      'descricao' => $this->descricao,
      'ativo'     => $this->ativo,
      'data'      => $this->data
    ]);
  }

  // Método para cadastrar a vaga no banco, retornando um boolean
  public function cadastrar() {
    // Definir a data
    $this->data = date('Y-m-d H:i:s');
    // Inserir a vaga no Banco
    $obDatabase = new Database('vagas');
    $this->id = $obDatabase->insert([
      'titulo'    => $this->titulo,
      'descricao' => $this->descricao,
      'ativo'     => $this->ativo,
      'data'      => $this->data
    ]);

    // retornar sucesso
    return true;
  }

  // Static, pois retorna varias instancias de vagas
  // retorna arrays, métodos que obtem as vagas cadastradas
  // fetchAll retorna um array, de acordo com os dados passados
  // nesse caso será retornado um array da propria classe
  // devolvendo as chaves e seus devidos valores
  public static function getVagas($where = null, $order = null, $limit = null) {
    return (new Database('vagas'))->select($where, $order, $limit)
                                  ->fetchAll(PDO::FETCH_CLASS, self::class);
  } 

  // Responsável por buscar uma vaga com base no id
  public static function getVaga($id) {
    return (new Database('vagas'))->select('id = '.$id)
                                  ->fetchObject(self::class);
  }

}

?>