<?php

namespace Brolaugh\Core;

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $param = [];

    public function __construct()
    {
      $blog = "";
        $url = $this->parseUrl();
        if (file_exists('../app/Brolaugh/Controllers/' . $url[0] . '.php')) {
            if ($url[0] != 'Blog')
                $this->controller = $url[0];
            unset($url[0]);

        } else if ($blog = $this->blog_exists($url[0])) {
            $this->controller = 'Blog';
            unset($url[0]);
        }


        if ($this->controller == 'Blog') {
            $controller = "\\Brolaugh\\Controllers\\" . $this->controller;
            $this->controller = new $controller($blog);
        } else {
            $controller = "\\Brolaugh\\Controllers\\" . $this->controller;
            $this->controller = new $controller($blog);
        }

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->param = $url ? array_values($url) : null;
        call_user_func([$this->controller, $this->method], $this->param);

    }

    protected function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/',
                filter_var(
                    str_replace(" ", "_",
                        trim($_GET['url'], '/')
                    )
                    , FILTER_SANITIZE_URL
                )
            );
        }

    }

    private function blog_exists($blog)
    {
        return (new Database())->blog_exists($blog);
    }
}
