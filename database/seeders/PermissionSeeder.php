<?php

namespace Database\Seeders;

use App\Models\RolePermission\ModulePermission;
use App\Models\RolePermission\SubModulePermission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module1 = ModulePermission::create(['module_name'=>'superadmin']);
        $subModule1 = SubModulePermission::create(['sub_module_name'=>'superadmin','module_permission_id'=>$module1->id]);
        Permission::create(['name' => 'all','sub_module_permission_id'=>$subModule1->id]);
        
        $module2 = ModulePermission::create(['module_name'=>'Example']);
        $subModule2 = SubModulePermission::create(['sub_module_name'=>'Example Crud','module_permission_id'=>$module2->id]);
        
        Permission::create(['name' => 'examples.list','sub_module_permission_id'=>$subModule2->id]);
        Permission::create(['name' => 'examples.create','sub_module_permission_id'=>$subModule2->id]);
        Permission::create(['name' => 'examples.read','sub_module_permission_id'=>$subModule2->id]);
        Permission::create(['name' => 'examples.update','sub_module_permission_id'=>$subModule2->id]);
        Permission::create(['name' => 'examples.destroy','sub_module_permission_id'=>$subModule2->id]);        
    }
}
