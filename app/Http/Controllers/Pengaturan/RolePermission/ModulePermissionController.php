<?php

namespace App\Http\Controllers\Pengaturan\RolePermission;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseComponent\BaseController;
use Illuminate\Http\Request;

class ModulePermissionController  extends BaseController
{
    protected $f_model = 'RolePermission\ModulePermission';
    protected $title = 'Module Permission';
    protected $route = 'pengaturan.module-permission';    
    

    public $datatableColumn = [
        ['data' => 'module_name', 'title' => 'Module Name', 'orderable' => true, 'searchable' => true],
        ['data' => 'action', 'title' => 'Opsi', 'orderable' => false, 'searchable' => false, 'width' => '130px'],
    ];


    public function _setForm($method)
    {
        $forms = [
            'module_name'=>[
                    'name'=> 'module_name',
                    'type'=> 'text',
                    'label'=> 'Module Name',
                    'colForm'=>12,
                    'option'=> [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder'=>'Enter Module Name',
                    ],
                ],
        ];
        return $forms;
    }
  

}
