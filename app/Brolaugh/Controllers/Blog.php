<?php

namespace Brolaugh\Controllers;

use Brolaugh\Core\Controller;
use Brolaugh\Core\Database;

class Blog extends Controller
{
    private $blog;
    private $blogModel;
    private $authorModel;
    private $sideMenuItems = [];
    private $utilityModel;

    public function __construct($blog)
    {
        parent::__construct();
        $this->blog = $blog;

        $this->blogModel = $this->model("Blog");
        $this->blogModel->prepare($this->blog);

        $this->authorModel = $this->model("Author");
        $this->authorModel->prepare($this->blogModel->author);

        $this->utilityModel = $this->model("Utility");
    }

    private function calculateUrl($url = [])
    {
        /*
         * The function argument is an array consisting of a name and data pair.
         * eg. ["page", 4]
         * This array tells us that the to be presented is #4 if the argument is relevant.
         * The array should always have an even number of indexes
         */
        $popOffs = [];
        for ($i = 0; $i < count($url); $i++) {
            if ($url[$i] == "page") {
                if (isset($url[$i + 1])) {

                    if (!is_numeric($url[$i + 1])) {
                        $this->utilityModel->currentPage = 1;
                    } else {
                        $this->utilityModel->currentPage = (int)$url[$i + 1];
                    }


                    //Calculation of how many pages exist
                    $this->utilityModel->totalPages = (int)ceil($this->blogModel->numPosts / $this->utilityModel->pageLimit);

                    // If current page is greater than the total number of pages
                    if ($this->utilityModel->totalPages < $this->utilityModel->currentPage) {
                        // Set current page to the last
                        $this->utilityModel->currentPage = $this->utilityModel->totalPages;

                    } //If the current page is lesser than 1
                    else if ($this->utilityModel->currentPage < 1) {
                        // Set current page to the first page
                        $this->utilityModel->currentPage = 1;
                    }
                    $popOffs[] = $i + 1;
                    $i++;
                }
                $popOffs[] = $i;

            } elseif ($url[$i] == "tag") {
                if (isset($url[$i + 1])) {
                    $this->utilityModel->tag = $url[$i + 1];
                    $popOffs[] = $i + 1;
                    $i++;
                }
                $popOffs[] = $i;

            } elseif ($url[$i] == "search") {
                if (isset($url[$i + 1])) {
                    $this->utilityModel->search = $url[$i + 1];
                    $popOffs[] = $i + 1;
                    $i++;
                }
                $popOffs[] = $i;
            }
        }
        foreach ($popOffs as $popOffElement) {
            unset($url[$popOffElement]);
        }
        $this->utilityModel->calculatePagination();
        return array_values($url);


    }

    public function index($data = [])
    {
        if (count($data) == 1) {
            $this->post($this->calculateUrl($data));
        } else {
            $options = [];
            if (count($data) != 0) {
                $this->calculateUrl($data);
            } else {
                $this->utilityModel->totalPages = (int)ceil($this->blogModel->numPosts / $this->utilityModel->pageLimit);
            }


            $options["offset"] = ($this->utilityModel->currentPage - 1) * $this->utilityModel->pageLimit;
            $options["limit"] = $this->utilityModel->pageLimit;

            $posts = (new Database())->getPostsByBlog($this->blog, $options);
            $postModels = [];
            foreach ($posts as $postID) {
                $post = $this->model("Post");
                $post->prepare($postID, $this->blog);
                $postModels[] = $post;
            }
            $this->view("blog/index", [
                "blog" => $this->blogModel,
                "posts" => $postModels,
                "author" => $this->authorModel,
                "utility" => $this->utilityModel
            ]);
        }

    }

    public function post($post = [])
    {
        if (count($post) == 0) {
            header("Location: /" . $this->blogModel->name . "/");
        } else {

            $postModel = $this->model("Post");
            if (!$postModel->prepare($post[0], $this->blog)) {
                $this->Error404();
                exit();
            }

            // Code below breaks $postModel
            /* foreach($this->model("Post")->getSideMenuItems($this->blog) as $sideMenuItem){
                $this->sideMenuItems[] = $sideMenuItem;
            }*/

            $this->view("blog/post", [
                "blog" => $this->blogModel,
                "post" => $postModel,
                "author" => $this->authorModel,
                "sideMenuItems" => $this->sideMenuItems,
                "utility" => $this->utilityModel
            ]);
        }
    }

    public function compose($post = ["new"])
    {
        $postModel = $this->model("Post");
        $unPublishedPostModels = [];
        $options = [
            "limit" => "int.MaxValue",
            "offset" => 0,
            "status" => [1]
        ];
        switch ($post[0]) {
            case "send":
                $postModel->send($this->blog);
                header("Location:/" . $this->blogModel->name . "/post/" . $postModel->url_title);
                break;

            case "new":
                $unPublishedPostModels = (new Database())->getPostsByBlog($this->blog, $options);
                $postModel->loadStatusOptions();
                break;

            default:
                //get $post from database and fill forms
                $unPublishedPostModels = (new Database())->getPostsByBlog($this->blog, $options);
                $postModel->loadStatusOptions();
                $postModel->prepare($post, $this->blog);
                break;

        }
        $this->view("blog/compose", [
            "blog" => $this->blogModel,
            "post" => $postModel,
            "author" => $this->authorModel,
            "unpublishedPosts" => $unPublishedPostModels,
            "utility" => $this->utilityModel
        ]);
    }

}
