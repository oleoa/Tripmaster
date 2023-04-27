<?php

namespace App\Classes;

/**
 * Essa classe é responsável apenas
 * por fazer a ligação entre o nome
 * do item da sidebar e o nome da view.
 * 
 * É usada para conseguir fazer a comparação
 * da pagina atual e conseguir destacar
 * na sidebar.
 * 
 * This class is responsible only for linking
 * the li name and the view name.
 * 
 * It is used to compare the current page and
 * highlight it on the sidebar.
 */
class SidebarCurrent
{
  // li name => view path
  private $links = array(
    'home' => 'home',
    'stays' => 'stays.index',
    'projects' => array(
      'projects.list',
      'projects.create',
    ),
    'signin' => 'sign.in',
    'signup' => 'sign.up',
  );

  public function get($correctPage)
  {
    $data = array();
    foreach($this->links as $key => $value)
      if(is_array($value))
        foreach($value as $subkey => $subvalue)
          $data[$key] = $subvalue == $correctPage || (isset($data[$key]) && $data[$key] == true);
      else
        $data[$key] = $value == $correctPage;

    return $data;
  }
}