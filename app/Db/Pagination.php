<?php 

  namespace App\Db;

  class Pagination {
    // número máximo de registros
    private $limit;
    // resultados obtidos do banco
    private $results;
    // Quantidade de páginas
    private $pages;
    // Página atual
    private $currentPage;

    // construtor da classe
    public function __construct($results, $currentPage = 1, $limit = 10 ){
      $this->results = $results;
      $this->limit = $limit;
      $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
      $this->calculate();
    }

    // método responsável por calcular a paginação
    private function calculate() {
      // arredonda o numero para cima e calcula o total de paginas
      $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

      // verifica se a página atual nao excede o numero de paginas
      $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * Método responsável pro retornar a clausula limit da sql
     * @return string
     */
    public function getLimit() {
      $offset = ($this->limit * ($this->currentPage - 1));

      return $offset.','.$this->limit;
    }

    /**
     * Método responsável por retornar as opções de páginas disponíveis
     * @return array
     */
    public function getPages() {
      // não retorna páginas
      if ($this->pages == 1) {
        return [];
      }

      // Páginas
      $paginas = [];
      for($i = 1; $i <= $this->pages; $i++) {
        $paginas[] = [
          'pagina' => $i,
          'atual'  => $i == $this->currentPage
        ];
      }

      return $paginas;
    }
  }

?>