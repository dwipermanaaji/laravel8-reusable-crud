<?php 
namespace App\Http\Controllers\BaseComponent\Services;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Http\Request;

trait GenerateDataTable
{
  private $rawColumns = ['action'];
  public $datatableColumn = [];
  
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

}
