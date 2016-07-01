<?php

namespace Brolaugh\Model;

use \Brolaugh\Core\Database;

class Blog
{
  public $id;
  public $title;
  public $name;
  public $author;
  public $description;
  public $stylesheet;
  public $numPosts;

  public function prepare($blog)
  {
    $this->id = $blog;
    $data = $this->getBlogByID($blog);
    $this->title = $data->title;
    $this->name = $data->name;
    $this->author = $data->author;
    $this->description = $data->description;
    $this->numPosts = $this->getNumPosts();
  }

  private function getBlogByID($blogID)
  {
    $stmt = Database::prepare("SELECT * FROM blog WHERE id = ?");
    $stmt->bind_param("i", $blogID);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    return $res->fetch_object();
  }

  private function getNumPosts()
  {
    $stmt = Database::prepare("SELECT count(id) AS numPosts FROM post WHERE blog = ?");
    $stmt->bind_param("i", $this->id);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    return $res->fetch_object()->numPosts;
  }

}
