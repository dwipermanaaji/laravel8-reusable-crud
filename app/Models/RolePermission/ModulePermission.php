<?php

namespace App\Models\RolePermission;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModulePermission extends Resource
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'module_name',
    ];

    public function sub_module_permissions()
    {
        return $this->hasMany(SubModulePermission::class);
    }
}
