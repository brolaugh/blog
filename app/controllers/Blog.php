<?php

class Blog extends Controller
{
    private $blog;

    public function __construct($blog){
        $this->blog = $blog;
        echo "/$blog/";
    }

    public function index($post = ''){
        if(strlen($post) > 0)
            $this->post($post);
        else
            echo 'index';
    }
    public function post($post){
        echo 'post/' . $post;
    }
    
}