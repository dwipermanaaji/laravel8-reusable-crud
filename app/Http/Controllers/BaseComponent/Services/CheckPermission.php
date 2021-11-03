<?php

namespace App\Http\Controllers\BaseComponent\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


trait CheckPermission
{
  protected $auths = array (
    'index',
    'store',
    'show',
    'edit',
    'update',
    'destroy',
    'delete',
    'trash',
    'restore',
  );

  protected $auth_name = null;

  protected function checkPermissions($authenticatedRoute, $authorize) 
  {
    if(in_array($authenticatedRoute, $this->getAuthenticatedRoutes())) {
        $auth_name = ($this->auth_name == null) ? $this->model->getTable() : $this->auth_name;
        $permissions = ['all',$auth_name.'.'.$authorize];
        $user = Auth::user();
        if(!$user->hasAnyPermission($permissions)) {
            abort(403);
        }
      }
  }



  function getAuthenticatedRoutes() {
    return $this->auths;
  }


}
