<?php
namespace App\Http\Controllers\BaseComponent;

use App\Http\Controllers\BaseComponent\Services\FormKey;
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

  //datatable
  private $rawColumns = ['action'];
  public $datatableColumn = [];
  
  public function __construct()
  {
    $this->setModel();
    $this->setView();
    $this->setRoute(); 
    $this->initialSetDataTableColumn();
  }

  protected function initialSetDataTableColumn()
  {
    foreach($this->structures as $value){
      $column = [
          'data' => $value, 
          'title' => Str::headline($value), 
          'orderable' => true,  
          'searchable' => true
      ];
      array_push($this->datatableColumn,$column);
    }
    $action = ['data' => 'action', 'title' => 'Opsi', 'orderable' => false, 'searchable' => false, 'width' => '130px'];
    array_push($this->datatableColumn,$action);
  }


  protected function setModel()
  {

    if($this->f_model == null)
      $this->_handleDBTransactionError('f_model can not be empty');

    
    if(file_exists(app_path('Models/'.$this->f_model.'.php'))){
      $this->model = app("App\Models\\".$this->f_model);
    }else{
      $this->_handleDBTransactionError(app_path('Models/'.$this->f_model.'.php Not Found'));
    }
    

    if($this->model) {
      $this->structures = $this->model->getStructure();
    }
  }


  public function _setForm($method)
  {
    $forms = [];
    foreach($this->structures as $value){
      $column = [
        'name' => $value,
        'label' => Str::headline($value),
        'option' => [
            'class' => 'form-control',
            'required' => 'required'
        ],
      ];
      array_push($forms,$column);
    }
    return $forms;
  }


  public function setForm($forms, $method)
  {
    $data = [];
    if(isset($forms)){
      foreach ($forms as $key => $value) {
        $data[$value['name']] = new FormKey();
        $data[$value['name']]->name = isset($value['name']) ? $value['name'] : null;
        $data[$value['name']]->type = isset($value['type']) ? $value['type'] : 'text';
        $data[$value['name']]->label = isset($value['label']) ? $value['label'] : $value['name'];
        $data[$value['name']]->value = isset($value['value']) ? $value['value'] : null;
        $data[$value['name']]->option = isset($value['option']) ? $value['option'] : null;
        $data[$value['name']]->list = isset($value['list']) ? $value['list'] : null;
        $data[$value['name']]->selected = isset($value['selected']) ? $value['selected'] : null;
        $data[$value['name']]->checked = isset($value['checked']) ? $value['checked'] : null;
        $data[$value['name']]->create = isset($value['create']) ? $value['create'] : true;
        $data[$value['name']]->edit = isset($value['edit']) ? $value['edit'] : true;
        $data[$value['name']]->route = isset($value['route']) ? $value['route'] : true;
        $data[$value['name']]->formType = $method;
      }
    }else{
      return false;
    }
    $obj = (object)$data;
    return $obj;
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

  public function create()
  {

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
    $info['datatableColumn'] = $this->datatableColumn;
    $info['views'] = $this->views;
    

    return (object)$info;
  }

}