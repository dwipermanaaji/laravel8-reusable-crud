<?php

namespace App\Models\RolePermission;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubModulePermission extends Resource
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'module_permission_id',
        'sub_module_name',
    ];   

    public function module_permission()
    {
        return $this->belongsTo(ModulePermission::class,'module_permission_id','id');
    }

    
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

}
