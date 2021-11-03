<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\RolePermission\ModulePermission;
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
        $modulePermissions = ModulePermission::with(['sub_module_permissions','sub_module_permissions.permissions'])->get();
        return view('pengaturan.role.create',compact('modulePermissions'));
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
            DB::rollBack();
            toastr()->error('Tambah Data Gagal', 'Gagal!');
            return redirect()->back()->withInput($request->input());
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
        try {
            $data = Role::with('permissions')->findOrFail($id);
        } catch (\Exception $e) {
            toastr()->error('Data Tidak Ada', 'Gagal!');
            return redirect()->back()->withInput(request()->input());
        }
        $modulePermissions = ModulePermission::with(['sub_module_permissions','sub_module_permissions.permissions'])->get();
        return view('pengaturan.role.edit',compact('data','modulePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=> 'required|unique:roles,name,'.$id,
            'guard_name'=>'required',
            'permissions'=>'nullable|array',
        ]);
        try {
            $data = Role::with('permissions')->findOrFail($id);
        } catch (\Exception $e) {
            toastr()->error('Data Tidak Ada', 'Gagal!');
            return redirect()->back()->withInput(request()->input());
        }
        DB::beginTransaction();
        try {
            $data->update(['name'=>$request->name,'guard_name'=>$request->guard_name]);
            $data->syncPermissions($request->permissions);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Tambah Data Gagal', 'Gagal!');
            return redirect()->back()->withInput($request->input());
        }
        DB::commit();
        toastr()->success('Update Data Berhasil', 'Berhasil!');
        return redirect(route('pengaturan.role.index'));
    }

    public function destroy($id)
    {
        try {
            $data = Role::with('permissions')->findOrFail($id);
        } catch (\Exception $e) {
            toastr()->error('Data Tidak Ada', 'Gagal!');
            return redirect()->back()->withInput(request()->input());
        }

        if($data->users()->count() > 0){
            toastr()->error('Data tidak bisa dihapus', 'Gagal!');
            return redirect()->back()->withInput(request()->input());
        }

        DB::beginTransaction();
        try {
            $data->delete();
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Hapus Data Gagal', 'Gagal!');
            return redirect()->back()->withInput(request()->input());
        }
        DB::commit();
        toastr()->success('Hapus Data Berhasil', 'Berhasil!');
        return redirect(route('pengaturan.role.index'));
    }
}
