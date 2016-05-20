    <?php
class App{
    protected $controller = 'home';
    protected $method = 'index';
    protected $param = [];

    public function __construct()
    {
        $blog = "";
        $url = $this->parseUrl();
        if(file_exists('../app/controllers/' . $url[0] . '.php')){
            if($url[0] != 'blog')
                $this->controller = $url[0];
            unset($url[0]);

        }//blog_exists not yet correctly implemented
        else if($this->blog_exists($url[0])){
            $this->controller = 'blog';
            $blog = $url[0];
            unset($url[0]);
        }


        require_once '../app/controllers/' . $this->controller . '.php';

        $this->controller = ($this->controller = 'blog') ? new $this->controller($blog) : new $this->controller();

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->param = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->param);
        
    }
    protected function parseUrl(){
        if(isset($_GET['url'])){
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

    }
    private function blog_exists($blog){
        $database = new Database();
        return $database->blog_exists($blog);
    }
}