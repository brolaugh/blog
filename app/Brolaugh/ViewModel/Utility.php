<?php


namespace Brolaugh\ViewModel;


class Utility
{
  public $currentPage;
  public $pageLimit;
  public $totalPages;
  public $tag;
  public $search;
  public $pagination;
  public $paginationRange;

  public function __construct($utilityModel)
  {
    $this->currentPage = $utilityModel->currentPage;
    $this->pageLimit = $utilityModel->pageLimit;
    $this->totalPages = $utilityModel->totalPages;
    $this->tag = $utilityModel->tag;
    $this->search = $utilityModel->search;
    $this->pagination = $utilityModel->pagination;
    $this->paginationRange = $utilityModel->paginationRange;
  }
}
