<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with('roles')->get();
        return view('pengaturan.user.index',compact('data'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('pengaturan.user.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:5',
            'roles'=> 'required|array',
        ],[
            'roles.required'=>'*Minimal harus memilih 1 Role'
        ]);        
        DB::beginTransaction();
        try {
            $requestData = $request->all();
            $requestData['password'] = Hash::make($request->password);
            $data = User::create($requestData);
            $data->syncRoles($request->roles);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Tambah Data Gagal', 'Gagal!');
            return redirect()->back()->withInput($request->input());
        }
        DB::commit();

        toastr()->success('Tambah Data Berhasil', 'Berhasil!');
        return redirect(route('pengaturan.user.index'));
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        try {
            $data = User::with('roles')->findOrFail($id);
        } catch (\Exception $e) {
            toastr()->error('Data Tidak Ada', 'Gagal!');
            return redirect()->back()->withInput(request()->input());
        }
        $roles = Role::get();
        return view('pengaturan.user.edit',compact('data','roles'));
    }


    public function update(Request $request, $id)
    {
        try {
            $data = User::findOrFail($id);
        } catch (\Exception $e) {
            toastr()->error('Data Tidak Ada', 'Gagal!');
            return redirect()->back()->withInput(request()->input());
        }

        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'nullable|confirmed|min:5',
            'roles'=> 'required|array',
        ],[
            'roles.required'=>'*Minimal harus memilih 1 Role'
        ]);
        $requestData = $request->all();
        if($requestData['password']==null){
            unset($requestData['password']);
            unset($requestData['password_confirmation']);
        }else{
            $requestData['password'] = Hash::make($request->password);
        }

        DB::beginTransaction();
        try {
            $data->update($requestData);
            $data->syncRoles($request->roles);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Update Data Gagal', 'Gagal!');
            return redirect()->back()->withInput($request->input());
        }
        DB::commit();

        toastr()->success('Update Data Berhasil', 'Berhasil!');
        return redirect(route('pengaturan.user.index'));        
    }

    public function destroy($id)
    {
        try {
            $data = User::findOrFail($id);
        } catch (\Exception $e) {
            toastr()->error('Data Tidak Ada', 'Gagal!');
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
        return redirect(route('pengaturan.user.index'));        

    }
}
