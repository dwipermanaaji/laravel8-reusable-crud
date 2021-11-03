<?php
namespace App\Http\Controllers\BaseComponent;

use App\Http\Controllers\BaseComponent\Services\FormKey;
use App\Http\Controllers\BaseComponent\Services\GenerateDataTable;
use App\Http\Controllers\BaseComponent\Services\GenerateForm;
use App\Http\Controllers\BaseComponent\Services\GenerateInfo;
use App\Http\Controllers\BaseComponent\Services\GenerateModel;
use App\Http\Controllers\BaseComponent\Services\GenerateRoute;
use App\Http\Controllers\BaseComponent\Services\GenerateView;
use App\Http\Controllers\BaseComponent\Services\HandleError;
use App\Http\Controllers\BaseComponent\Services\CheckPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BaseController extends Controller {
  use GenerateView, 
  GenerateRoute,
  GenerateModel,
  GenerateForm,
  GenerateDataTable,
  HandleError,
  GenerateInfo,
  CheckPermission;
  
  protected bool $devMode = true;

  //Penamaan di view
  protected $title = null;
  protected $description = null;
  protected $breadcrumbs = array();

  //segment
  protected $segments = [];
  protected $segment = null;

  public bool $softDelete = false;


  public function __construct()
  {
    $this->setModel();
    $this->setView();
    $this->setRoute(); 
    $this->initialSetDataTableColumn();
  }



  public function index()
  {
    $this->checkPermissions('index');
    try {
      $info = $this->info();
      return view($this->views['index'])->with(['info' => $info]);
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }
  }

  public function create()
  {
    $this->checkPermissions('create');

    try {
      $info = $this->info();
      $data = [];
      if (method_exists($this, '_getRelatedData')) {
       $data = $this->_getRelatedData('create');
      }

      $forms = null;
      if (method_exists($this, '_setForm')) {
          $forms = $this->_setForm('create');
          $forms = $this->setForm($forms, 'create');
      }
      return view($this->views['create'], compact('info', 'data','forms'));
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }    
  }

  public function store(Request $request)
  {
    $this->checkPermissions('store');
    if (method_exists($this, '_validateRequest')){
        $validate = $this->_validateRequest($request, 'create');
    }else{
      if (method_exists($this, '_setForm')) {
        $forms = $this->_setForm('create');
        $forms = $this->setForm($forms, 'create');
        $validate = $this->validateRequest($forms, $request);
      }      
    } 
  
    $requestData = $request->all();
    try {
      DB::beginTransaction();
      $savedObj = (method_exists($this, '_store')) ? $this->_store($request) :  $this->model->create($requestData);
      DB::commit();

      if (method_exists($this, '_redirectAfterSave') && $savedObj)
        return $this->_redirectAfterSave($request, $savedObj, 'create');
    
      toastr()->success('Tambah Data Berhasil', 'Berhasil!');
      return redirect(route($this->routes['index']));
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }    
  }

  public function show(Request $request, $id)
  {
    $this->checkPermissions('show');
      dd('Show Maintenance');
  }

  public function edit($id)
  {
    $this->checkPermissions('edit');
    try {
      $info = $this->info();
      $obj = (method_exists($this, '_edit')) ? $this->_edit($id) : $this->model->findOrFail($id);
      $primaryKey = $obj->getKeyName();


      $data = [];
      if (method_exists($this, '_getRelatedData')) {
       $data = $this->_getRelatedData('create');
      }

      $forms = null;
      if (method_exists($this, '_setForm')) {
          $forms = $this->_setForm('create');
          $forms = $this->setForm($forms, 'create');
      }
      return view($this->views['edit'], compact('info', 'data','forms','obj','primaryKey'));
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }    
  }

  public function update(Request $request, $id)
  {
    $this->checkPermissions('update');

    if (method_exists($this, '_validateRequest')){
      $validate = $this->_validateRequest($request, 'create');
    }
    $requestData = $request->all();
    try {
      DB::beginTransaction();
      if (method_exists($this, '_update')) {
          $savedObj = $this->_update($request, $id);
      } else {
          $savedObj = $this->model->findOrFail($id);
          $savedObj->update($requestData);
      }
      DB::commit();

      if (method_exists($this, '_redirectAfterSave') && $savedObj){
        return $this->_redirectAfterSave($request, $savedObj, 'edit');
      }
    
      toastr()->success('Update Data Berhasil', 'Berhasil!');
      return redirect(route($this->routes['index']));
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }   

  }

  public function destroy(Request $request, $id)
  {
    $this->checkPermissions('destroy');
    try {
        DB::beginTransaction();

        if (method_exists($this, '_destroy')) {
            $obj = $this->_destroy($id);
        } else {
            $obj = $this->model->findOrFail($id);
            $obj->delete();
        }
        DB::commit();

        toastr()->success('Hapus Data Berhasil', 'Berhasil!');
        return redirect(route($this->routes['index']));
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }
  }
  public function trash()
  {
    if(!$this->softDelete)
      abort(404);

    $this->checkPermissions('trash');
    try {
      $info = $this->info();
      return view($this->views['trash'])->with(['info' => $info]);
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }
  }

  public function restore($id)
  {
    if(!$this->softDelete)
      abort(404);

    $this->checkPermissions('restore');
    try {
        DB::beginTransaction();

        if (method_exists($this, '_restore')) {
            $obj = $this->_restore($id);
        } else {
            $obj = $this->model->withTrashed()->findOrFail($id);
            $obj->restore();
        }
        DB::commit();

        toastr()->success('Data Berhasil dikembalikan', 'Berhasil!');
        return redirect(route($this->routes['index']));
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }
  }

  public function delete($id)
  {
    if(!$this->softDelete)
      abort(404);

    $this->checkPermissions('delete');
    try {
        DB::beginTransaction();

        if (method_exists($this, '_delete')) {
            $obj = $this->_delete($id);
        } else {
            $obj = $this->model->withTrashed()->findOrFail($id);
            $obj->forceDelete();
        }
        DB::commit();

        toastr()->success('Data Berhasil dihapus Permanen', 'Berhasil!');
        return redirect(route($this->routes['trash']));
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }
  }
}