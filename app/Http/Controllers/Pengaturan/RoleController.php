<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        $data = Role::with('permissions')->get();
        return view('pengaturan.role.index',compact('data'));
    }


    public function create()
    {
        $permissions = Permission::get();
        return view('pengaturan.role.create',compact('permissions'));
    }


    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=> 'required|unique:roles,name',
            'guard_name'=>'required',
            'permissions'=>'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create(['name'=>$request->name,'guard_name'=>$request->guard_name]);
            $role->syncPermissions($request->permissions);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();

        toastr()->success('Tambah Data Berhasil', 'Berhasil!');
        return redirect(route('pengaturan.role.index'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
