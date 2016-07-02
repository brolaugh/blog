<?php
namespace Brolaugh\Model;

use Brolaugh\Config;
use Brolaugh\Core\Controller;
use \Brolaugh\Core\Database;
use Brolaugh\Helper\Token;

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

  //Fetches data from the database based on the postID argument
  public function prepare($post, $blogID = 0)
  {
    if (is_numeric($post)) {
      $this->id = $post;
      if($dbPost = $this->getPostByID($post)){
        $this->fillSelfWithData($dbPost);
        return true;
      } else
        return false;

    } else if (is_string($post)) {
      if ($blogID == 0) {
        throw new \Exception('first argument in \Models\Post::prepare was non numeric string... Need second argument if first argument is non numeric string');
      } else {
        $this->url_title = $post;
        if($dbPost = $this->getPostByURLTitle($post, $blogID)){
          $this->fillSelfWithData($dbPost);
          return true;
        }else
          return false;
      }
    }
  }

  private function getPostByURLTitle($urlTitle, $blog)
  {
    $stmt = Database::prepare("SELECT * FROM post WHERE url_title = ? AND blog = ?");
    $stmt->bind_param("si", $urlTitle, $blog);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    return $res->fetch_object();
  }

  public function getSideMenuItems($blog)
  {
    $stmt = Database::prepare("SELECT url_title, title FROM post WHERE blog = ? AND status = 4 ORDER BY publishing_time");
    $stmt->bind_param("i", $blog);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    $retval = [];
    while ($row = $res->fetch_object()) {
      $row->kappa = "Keppo";
      $retval[] = $row;
    }
    return $retval;
  }

  //Collects data from the compose form and then sends it to the database
  public function send($blog)
  {
    if(Token::check($_POST[Config::get('session/session_name')]));
    $this->blog = $blog;
    $this->title = $_POST['compose-title'];
    $this->url_title = strtolower(preg_replace('([^a-zA-Z0-9\+\.=_-])', '', str_replace(' ', '_', $_POST['compose-url-title'])));
    $this->content = $_POST['compose-body'];
    $this->status = $_POST['compose-visibility'];
    $this->tags = explode(",", $_POST['compose-tags']);


    if ($this->doesURLTitleExistInBlog($this->url_title, $this->blog)) {
      //Send client back to /blog/compose
      exit("That URL title already exists on this blog");
    } else {
      $this->sendPost($this);
    }
  }

  public function loadStatusOptions()
  {
    $stmt = Database::prepare("SELECT * FROM post_status");
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    $retval = [];
    while ($row = $res->fetch_object()) {
      $retval[] = $row;
    }
    $this->statusOptions = $retval;
  }

  private function getPostByID($postID)
  {
    $stmt = Database::prepare("SELECT * FROM post WHERE id = ?");
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    return $res->fetch_object();
  }

  private function fillSelfWithData($data)
  {
    $this->id = $data->id;
    $this->blog = $data->blog;
    $this->title = $data->title;
    $this->url_title = $data->url_title;
    $this->content = $data->content;
    $this->status = $data->status;
    $this->create_time = $data->create_time;
    $this->publishing_time = $data->publishing_time;
    $this->tags = $this->getTagsFromPostID($this->id);
  }

  //Sends the data to the database as a new row
  private function sendPost($blog)
  {
    $stmt = Database::prepare("INSERT INTO post(blog, title, url_title, content, status, create_time, publishing_time) VALUES(?,?,?,?,?, NOW(), NOW())");
    $stmt->bind_param('isssi', $blog->blog, $blog->title, $blog->url_title, $blog->content, $blog->status);
    $retval = $stmt->execute();

    foreach ($this->tags as $tag) {
      $tagObject = Controller::model("Tags");
      $tagObject->connectTagAndPost($stmt->insert_id, $tagObject->getTagIdByName($tag));
    }
    $stmt->free_result();
    $stmt->close();
    return $retval;
  }

  private function doesURLTitleExistInBlog($urlTitle, $blog)
  {
    $stmt = Database::prepare("SELECT id FROM post WHERE url_title = ? AND blog = ?");
    $stmt->bind_param("si", $urlTitle, $blog);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();

    return ($res->num_rows > 0) ? $res->fetch_object()->id : false;
  }

  private function getTagsFromPostID($postID)
  {
    $stmt = Database::prepare("SELECT tag.name FROM post_tag LEFT JOIN tag ON post_tag.tag=tag.id WHERE post_tag.post = ?");
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $res = $stmt->get_result();
    $retval = [];
    while ($row = $res->fetch_object()) {
      $retval[] = $row->name;
    }
    $stmt->free_result();
    $stmt->close();
    return $retval;
  }
}
