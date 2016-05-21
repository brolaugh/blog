<?php

/**
 * Created by PhpStorm.
 * User: hannes.kindstrommer
 * Date: 2016-05-17
 * Time: 13:20
 */
class home extends Controller
{
    public function index($name = ''){
        echo 'home/index';
        $user = $this->model('User');
        $user->name = $name;
        $db = new Database();
        $blogs = [];
        foreach($db->getAllBlogs() as $blog){
            $newBlog = $this->model("blog");
            $newBlog->prepare($blog);
            $blogs[] = $newBlog;
        }
        $this->view('home/show_all_blogs', ['blogs' => $blogs]);
    }
}