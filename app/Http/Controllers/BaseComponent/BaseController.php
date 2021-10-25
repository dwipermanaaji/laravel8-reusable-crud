<?php
namespace App\Http\Controllers\BaseComponent;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Crypt;

class BaseController extends Controller {
  use GenerateView, GenerateRoute;


  protected $devMode = true;

  //folder name
  protected $f_model = null;
  protected $model = null;

  //Penamaan di view
  protected $title = null;
  protected $description = null;
  protected $breadcrumbs = array();

  //segment
  protected $segments = [];
  protected $segment = null;

  protected $structures = [];

  private $rawColumns = ['action'];

  public $datatableRows = [];
  
  public function __construct()
  {
    $this->setModel();
    $this->setView();
    $this->setRoute(); 

  }


  protected function setModel(Resource $model)
  {
    if($this->f_model == null)
      $this->_handleDBTransactionError('f_model can not be empty');

    if(file_exists(app_path('Models/'.$this->f_model.'.php'))){
      $this->model = app("App\Models\\".$this->f_model);
    }else{
      if($model->checkTableExists($this->segment)) {
          $this->model = $model;
          $this->model->setTable($this->segment);
          
    $this->model->setTable('Examples');


      }      
    }
      // $this->_handleDBTransactionError(app_path('Models/'.$this->f_model.'.php Not Found'));
    
    $this->model->setTable('Examples');

    if($this->model) {
      $this->structures = $this->model->getStructure();
    }
  }

  public function dataTable(Request $request)
  {
    $primaryKey = $this->model->getKeyName();
    $model = $this->model;
    if (method_exists($this, '_dataTableWith')) {
        $model = $this->_dataTableWith($model);
    }
    $model = $model->newQuery();
    $dataTables =  DataTables::eloquent($model);
    $dataTables->addColumn('action', function ($data) use ($primaryKey, $request) {
      $btn = "
        <a href='".route($this->routes['edit'],$data->id)."' class='btn btn-light-warning btn-sm btn-icon' title='Edit $this->title'>
            <i class='fas fa-pencil-alt'></i>
        </a>
        <button type='button' onclick='return deletePengaduan($data->id)' class='btn btn-light-danger btn-sm btn-icon' title='Hapus $this->title'>
            <i class='fas fa-trash-alt'></i>
        </button>
        <form id='form-delete-$data->id' action='".route($this->routes['destroy'],$data->id)."' method='POST' style='display: none;'>
            ".csrf_field()."
            ". method_field('DELETE') . "
        </form> 
      ";
      return $btn;
    });

    if (method_exists($this, '_dataColumn')) {
        $dataTables = $this->_dataColumn($dataTables, $request);
    }
    $dataTables->rawColumns($this->rawColumns);
    return $dataTables->addIndexColumn()->toJson();
  }

  public function index()
  {
    try {
      $info = $this->info();
        return view($this->views['index'])->with(['info' => $info]);
    } catch (\Exception $e) {
        $this->_handleDBTransactionError($e);
    }    
  }

  public function _handleDBTransactionError($e)
  {
      if ($this->devMode) {
          return dd($e);
      }

      DB::rollback();
      toastr()->success('Hapus Data Berhasil', 'Berhasil!');
      return redirect()->back()->withInput(request()->input());
  }

  public function info()
  {
    $info['title'] = $this->title;
    $info['description'] = $this->description;
    $info['breadcrumbs'] = $this->breadcrumbs;
    $info['routes'] = $this->routes;
    $info['datatableRows'] = $this->datatableRows;

    return (object)$info;
  }

}