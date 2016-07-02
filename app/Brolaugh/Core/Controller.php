<?php
namespace Brolaugh\Core;

use Brolaugh\Config;


class Controller
{
  private $twig;
  protected $visitor;

  public function __construct(){
    $loader = new \Twig_Loader_Filesystem('../app/Brolaugh/views/');
    $this->twig = new \Twig_Environment($loader, Config::get('twig'));
    $this->visitor = $this->model("Visitor");
  }

  public static function model($model, $modelArgs = [])
  {
    $model = '\Brolaugh\Model\\' . $model;

    $r = new \ReflectionClass($model);
    return $r->newInstanceArgs($modelArgs);
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
