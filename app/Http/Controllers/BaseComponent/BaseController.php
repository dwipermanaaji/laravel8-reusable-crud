<?php
namespace App\Http\Controllers\BaseComponent;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

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

  public function __construct()
  {
    $this->setModel();
    $this->setView();
    $this->setRoute(); 
  }


  protected function setModel()
  {
    if($this->f_model == null)
      $this->_handleDBTransactionError('f_model can not be empty');

    if(!file_exists(app_path('Models/'.$this->f_model.'.php')))
      $this->_handleDBTransactionError(app_path('Models/'.$this->f_model.'.php Not Found'));
    
    $this->model = app("App\Models\\".$this->f_model);
  }

  public function index()
  {
    dd($this);
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
}