<?php

namespace Brolaugh\ViewModel;


class Blog
{
  public $id;
  public $title;
  public $name;
  public $author;
  public $description;
  public $stylesheet;
  public $numPosts;

  public function __construct($blogModel)
  {
    $this->id = $blogModel->id;
    $this->title = $blogModel->title;
    $this->name = $blogModel->author;
    $this->description = $blogModel->description;
    $this->stylesheet = $blogModel->stylesheet;
    $this->numPosts = $blogModel->numPosts;
  }
}