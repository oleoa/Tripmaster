<?php

namespace App\Classes;

/**
 * Essa classe é responsável apenas
 * por fazer a ligação entre o nome
 * da rota e o nome da view.
 * 
 * É usada para conseguir fazer a comparação
 * da pagina atual e conseguir destacar
 * na sidebar.
 * 
 * This class is responsible only for linking
 * the route name and the view name.
 * 
 * It is used to compare the current page and
 * highlight it on the sidebar.
 */
class SidebarCurrent
{
  // route name => 
  private $links = array(
    'home' => 'home',
    'stays' => 'stays.index',
    'projects' => array(
      'projects.list',
      'projects.create',
    ),
    'home' => 'home',
  );

  public function __construct()
  {

  }
}