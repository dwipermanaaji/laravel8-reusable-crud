<?php

namespace App\Http\Controllers\Pengaturan\RolePermission;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseComponent\BaseController;
use App\Models\RolePermission\SubModulePermission;
use App\Models\RolePermission\Permission;

use Illuminate\Http\Request;

class PermissionController  extends BaseController
{
    protected $f_model = 'RolePermission\Permission';
    protected $title = 'Permission';
    protected $route = 'pengaturan.permission';    
    

    public $datatableColumn = [
        ['data' => 'sub_module_permission.sub_module_name', 'title' => 'Sub Module Name', 'orderable' => true, 'searchable' => true],
        ['data' => 'name', 'title' => 'Permission Name', 'orderable' => true, 'searchable' => true],
        ['data' => 'guard_name', 'title' => 'Guard Name', 'orderable' => true, 'searchable' => true],
        ['data' => 'action', 'title' => 'Opsi', 'orderable' => false, 'searchable' => false, 'width' => '130px'],
    ];


    public function _dataTableWith($model)
    {
        $model = $model->with('sub_module_permission');
        return $model;
    }

    public function _setForm($method)
    {
        $modulePermission = SubModulePermission::get()->pluck('sub_module_name','id')->toArray();
        $forms = [
            'sub_module_permission_id'=>[
                    'name'=> 'sub_module_permission_id',
                    'type'=> 'select',
                    'label'=> 'Module Name',
                    'list'=>$modulePermission,
                    'option'=> [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder'=>'Enter Module Name',
                    ],
            ],            
            'name'=>[
                    'name'=> 'name',
                    'type'=> 'text',
                    'label'=> 'Permission Name',
                    'option'=> [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder'=>'Enter Module Name',
                    ],
            ],
        ];
        return $forms;
    }

    public function _store($request)
    {
        $permission = Permission::create([
            'sub_module_permission_id'=>$request->sub_module_permission_id,
            'name'=>$request->name,
            'guard_name'=>'web',
        ]);
        return $permission;
    }

    public function destroy(Request $request, $id)
    {
        dd('belum');
    }
    
}
