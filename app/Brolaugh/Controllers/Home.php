<?php

namespace Brolaugh\Controllers;

use Brolaugh\Core\Controller;
use Brolaugh\Core\Database;

class Home extends Controller
{

  public function index($name = '')
  {
    $user = $this->model('User');

    $blogs = [];
    foreach( Database::getAllBlogs() as $blog) {
      $newBlog = $this->model("Blog");
      $newBlog->prepare($blog);
      $blogs[] = $newBlog;
    }
    $this->view('home/index', [
      'blogs' => $blogs,
      'user' => $this->visitor,
    ]);
  }
}
