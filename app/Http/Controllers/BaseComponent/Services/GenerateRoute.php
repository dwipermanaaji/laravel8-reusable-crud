<?php 
namespace App\Http\Controllers\BaseComponent\Services;

trait GenerateRoute
{
  protected $route;
  public $routes = [];

  protected $customRoute = [
    'index' => null,
    'create' => null,
    'store' => null,
    'show' => null,
    'edit' => null,
    'update' => null,
    'destroy' => null,
    'delete' => null,
    'dataTable' => null,
    'trash' => null,
    'restore' => null,
    
  ];

  protected function setRoute()
  {
    if($this->route === null)
      $this->_handleDBTransactionError('route can not be empty');

      $this->routes['index'] = $this->generateRoute('index');
      $this->routes['create'] = $this->generateRoute('create');
      $this->routes['store'] = $this->generateRoute('store');
      $this->routes['show'] = $this->generateRoute('show');
      $this->routes['edit'] = $this->generateRoute('edit');
      $this->routes['update'] = $this->generateRoute('update');
      $this->routes['destroy'] = $this->generateRoute('destroy');
      $this->routes['delete'] = $this->generateRoute('delete');
      $this->routes['dataTable'] = $this->generateRoute('datatable');
      $this->routes['trash'] = $this->generateRoute('trash');
      $this->routes['restore'] = $this->generateRoute('restore');
      
      
  }

  protected function generateRoute($method)
  {
    $route = $this->route.'.'.$method;
    if(isset($this->customRoute[$method])){
      $route = $this->customRoute[$method];
    }
    return $route;
  }

}
