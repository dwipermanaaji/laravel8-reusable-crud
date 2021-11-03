<?php

namespace App\Http\Controllers\Pengaturan\RolePermission;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseComponent\BaseController;
use App\Models\RolePermission\ModulePermission;
use App\Models\RolePermission\SubModulePermission;
use Illuminate\Http\Request;

class SubModulePermissionController  extends BaseController
{
    protected $f_model = 'RolePermission\SubModulePermission';
    protected $title = 'Sub Module Permission';
    protected $route = 'pengaturan.sub-module-permission';    
    

    public $datatableColumn = [
        ['data' => 'module_permission.module_name', 'title' => 'Module Name', 'orderable' => true, 'searchable' => true],
        ['data' => 'sub_module_name', 'title' => 'Sub Module Name', 'orderable' => true, 'searchable' => true],
        ['data' => 'action', 'title' => 'Opsi', 'orderable' => false, 'searchable' => false, 'width' => '130px'],
    ];


    public function _dataTableWith($model)
    {
        $model = $model->with('module_permission');
        return $model;
    }

    public function _setForm($method)
    {
        $modulePermission = ModulePermission::get()->pluck('module_name','id')->toArray();
        $forms = [
            'module_permission_id'=>[
                    'name'=> 'module_permission_id',
                    'type'=> 'select',
                    'label'=> 'Module Name',
                    'list'=>$modulePermission,
                    'option'=> [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder'=>'Enter Module Name',
                    ],
            ],            
            'sub_module_name'=>[
                    'name'=> 'sub_module_name',
                    'type'=> 'text',
                    'label'=> 'Sub Module Name',
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
