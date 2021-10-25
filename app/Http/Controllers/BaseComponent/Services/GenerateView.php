<?php 
namespace App\Http\Controllers\BaseComponent\Services;

trait GenerateView
{
  public $views = []; 

  protected $customPage = [
    'index' => null,
    'show' => null,
    'create' => null,
    'edit' => null,
    'form' => null,
  ];


  protected function setView()
  {
    $baseComponentView = 'base-component.base-view-component';
    $this->views['index'] = $this->generateView('index');
    $this->views['show'] = $this->generateView('show');
    $this->views['create'] = $this->generateView('create');
    $this->views['edit'] = $this->generateView('edit');
    $this->views['form'] = $this->generateView('form');
    
  }

  protected function generateView($method)
  {
    $baseComponentView = 'base-component.base-view-component';
    $view = $baseComponentView.'.'.$method;
    if(isset($this->customPage[$method])){
      $view = $this->customPage[$method];
    }
    return $view;
  }
}