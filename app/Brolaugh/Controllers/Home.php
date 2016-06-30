<?php

namespace Brolaugh\Controllers;

use Brolaugh\Core\Controller;

class Home extends Controller
{
    public function index($name = '')
    {
        $user = $this->model('User');
        $user->name = $name;
        $blogs = [];
        foreach ((new \Brolaugh\Core\Database())->getAllBlogs() as $blog) {
            $newBlog = $this->model("Blog");
            $newBlog->prepare($blog);
            $blogs[] = $newBlog;
        }
        $this->view('home/index', [
            'blogs' => $blogs
        ]);
    }
}