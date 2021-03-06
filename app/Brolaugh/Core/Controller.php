<?php
namespace Brolaugh\Core;

class Controller
{
  private $twig;
  public function __construct(){
    $loader = new \Twig_Loader_Filesystem('../app/Brolaugh/views/');
    $this->twig = new \Twig_Environment($loader, [
      'cache' => "../twigcache/",
      'debug' => true,
      'auto_reload' => true,
      'autoescape' => false,
    ]);
  }

  public static function model($model)
  {
    $model = '\Brolaugh\Model\\' . $model;
    return new $model();
  }

  public function view($view, $data = [])
  {
    echo $this->twig->render($view . ".twig", $data);

  }

  public function Error404($backLink = "")
  {

    $this->view("404", ["backlink" => $backLink]);

  }
  protected function multiConstruct($models){
    $retval= [];
    foreach($models as $model){
      $modelName =  '\Brolaugh\ViewModel\\' . (new \ReflectionClass($model))->getShortName();
      $retval[] = new $modelName($model);
    }
    return $retval;
  }
}
