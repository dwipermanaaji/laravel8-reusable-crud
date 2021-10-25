<?php 
namespace App\Http\Controllers\BaseComponent\Services;

trait GenerateModel
{
  protected $f_model = null;
  protected $model = null;
  protected $structures = [];

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

}
