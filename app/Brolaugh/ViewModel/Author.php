<?php
/**
 * Created by IntelliJ IDEA.
 * User: brolaugh
 * Date: 6/30/16
 * Time: 7:19 PM
 */

namespace Brolaugh\ViewModel;


class Author extends User
{
  public $name;

  public function __construct($authorModel)
  {
    parent::__construct($authorModel);
    $this->name = $authorModel->name;
  }
}
