<?php

namespace Brolaugh\Model;


class Utility
{
  public $currentPage = 1;
  public $pageLimit = 5;
  public $totalPages;
  public $tag;
  public $search;
  public $pagination = [];
  public $paginationRange = 5;

  public function calculatePagination(){
    for ($x = ($this->currentPage - $this->paginationRange); $x < (($this->currentPage + $this->paginationRange) + 1); $x++) {
      // Checks wether the page number is valid
      if (($x > 0) && ($x <= $this->totalPages)) {
        $this->pagination[] = $x;
      }
    }
  }
}
