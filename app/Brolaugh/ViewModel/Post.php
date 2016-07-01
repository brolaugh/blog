<?php

namespace Brolaugh\ViewModel;


class Post
{
  public $id;
  public $blog;
  public $title;
  public $url_title;
  public $content;
  public $status;
  public $create_time;
  public $publishing_time;
  public $tags;

  public $statusOptions;

  public function __construct($postModel)
  {
    $this->id = $postModel->id;
    $this->blog = $postModel->blog;
    $this->title = htmlspecialchars($postModel->title, ENT_QUOTES, "UTF-8");
    $this->url_title = $postModel->url_title;
    $this->content = (new \Parsedown())->setMarkupEscaped(true)->text($postModel->content);
    $this->status = $postModel->status;
    $this->create_time = $postModel->create_time;
    $this->publishing_time = $postModel->publishing_time;
    $this->tags = $postModel->tags;
    $this->statusOptions = $postModel->statusOptions;
  }
}
