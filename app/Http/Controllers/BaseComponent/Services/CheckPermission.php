<?php

namespace App\Http\Controllers\BaseComponent\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


trait CheckPermission
{
  protected array $auths = [
    // 'all',
    // 'index',
    // 'create',
    // 'store',
    // 'show',
    // 'edit',
    // 'update',
    // 'destroy',
    // 'delete',
    // 'trash',
    // 'restore',
  ];

  protected $auth_name = null;

  protected function checkPermissions($method) 
  {
    $methodModife = $method;
    if(in_array('all', $this->getAuthenticatedRoutes()) || isset($this->auths['all'])){
      $methodModife = 'all';
    }
    if(isset($this->auths[$methodModife]) || in_array($methodModife, $this->getAuthenticatedRoutes())) {
      $permissionRoute = $this->getPremission($method);
      $permissions = ['all',$permissionRoute];
      $user = Auth::user();
      if(!$user->hasAnyPermission($permissions)) {
          abort(403);
      }
    }
  }

  protected function getPremission($method)
  {
    $auth_name = ($this->auth_name == null) ? $this->model->getTable() : $this->auth_name;

    $permissionRoute = null;
    switch ($method) {
      case 'index':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.list';
      break;
      case 'create':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.create';
      break;
      case 'store':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.create';
      break;
      case 'show':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.read';
      break;
      case 'edit':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.update';
      break;
      case 'update':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.update';
      break;
      case 'destroy':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.destroy';
      break;
      case 'delete':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.delete';
      break;
      case 'trash':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.trash';
      break;
      case 'restore':
        $permissionRoute = (isset($this->auths[$method])) ? $this->auths[$method] : $auth_name.'.restore';
      break;      
    }

    if(isset($this->auths['all'])){
      $permissionRoute = $this->auths['all'];
    }
    return $permissionRoute;
  }



  function getAuthenticatedRoutes() {
    return $this->auths;
  }


}
