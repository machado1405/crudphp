<?php 

  namespace App\Entity;

  use App\Db\Database;

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

    // Método para cadastrar a vaga no banco, retornando um boolean
    public function cadastrar() {
      // Definir a data
      $this->data = date('Y-m-d H:i:s');
      // Inserir a vaga no Banco
      $obDatabase = new Database('vagas');
      $obDatabase->insert([
        'titulo'    => $this->titulo,
        'descricao' => $this->descricao,
        'ativo'     => $this->ativo,
        'data'      => $this->data
      ]);
      // atribuir o id da vaga na instancia

      // retornar sucesso

    }

  }

?>