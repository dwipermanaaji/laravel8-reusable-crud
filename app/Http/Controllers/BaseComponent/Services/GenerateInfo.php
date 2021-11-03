<?php 
namespace App\Http\Controllers\BaseComponent\Services;

trait GenerateInfo
{
  public function info()
  {
    $info['title'] = $this->title;
    $info['description'] = $this->description;
    $info['breadcrumbs'] = $this->breadcrumbs;
    $info['routes'] = $this->routes;
    $info['datatableColumn'] = $this->datatableColumn;
    $info['views'] = $this->views;
    $info['softDelete'] = $this->softDelete;
    
    return (object)$info;
  }
}
