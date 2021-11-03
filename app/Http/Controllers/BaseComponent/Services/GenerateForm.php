<?php 
namespace App\Http\Controllers\BaseComponent\Services;
use Illuminate\Support\Str;

trait GenerateForm
{

  protected $validateMessage = [];

  public function _setForm($method)
  {
    $forms = [];
    $structures = isset($this->structures) ? $this->structures : [];
    foreach($structures as $value){
      $column = [
        'name' => $value,
        'label' => Str::headline($value),
        'option' => [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder'=>'Enter '.Str::headline($value)
        ],
      ];
      array_push($forms,$column);
    }
    return $forms;
  }


  protected function setForm($forms, $method)
  {
    $data = [];
    if(isset($forms)){
      foreach ($forms as $key => $value) {
        $data[$value['name']] = new FormKey();
        $data[$value['name']]->name = isset($value['name']) ? $value['name'] : null;
        $data[$value['name']]->type = isset($value['type']) ? $value['type'] : 'text';
        $data[$value['name']]->label = isset($value['label']) ? $value['label'] : Str::headline($value['name']);
        $data[$value['name']]->value = isset($value['value']) ? $value['value'] : null;
        $data[$value['name']]->option = isset($value['option']) ? $value['option'] : null;
        $data[$value['name']]->list = isset($value['list']) ? $value['list'] : [];
        $data[$value['name']]->selected = isset($value['selected']) ? $value['selected'] : null;
        $data[$value['name']]->checked = isset($value['checked']) ? $value['checked'] : null;
        $data[$value['name']]->create = isset($value['create']) ? $value['create'] : true;
        $data[$value['name']]->edit = isset($value['edit']) ? $value['edit'] : true;
        $data[$value['name']]->route = isset($value['route']) ? $value['route'] : true;
        $data[$value['name']]->colForm = isset($value['colForm']) ? $value['colForm'] : 6;
        
        $data[$value['name']]->formType = $method;

        $validate = $this->getValidateDefault($value);
        $data[$value['name']]->validate = isset($value['validate']) ? $value['validate'] : $validate;
        
      }
    }else{
      return false;
    }

    $obj = (object)$data;
    return $obj;
  }

  private function getValidateDefault($value)
  {
    $validate = [];
    if(isset($value['option']['required'])){
      $validate = array_merge($validate, ['required']);
    }

    if($value['type'] == 'text'){
      $validate = array_merge($validate, ['string','max:255']);
    }

    if($value['type'] == 'email'){
      $validate = array_merge($validate, ['string','email']);
    }


    if($value['type'] == 'file'){
      $validate = array_merge($validate, [
                    'mimes:jpg,bmp,png,ppt,pptx,doc,docx,pdf,xls,xlsx,m4v,avi,flv,mp4,mov',
                    'file',
                    'image'
                  ]);
    }

    $validate = implode("|",$validate);
    return $validate;
  }

  protected function validateRequest($forms, $request)
  {
    $validate = [];
    $validateMessage = [];
    foreach ($forms as $key => $value) {
      $validate[$key] = $value->validate;
      $validateMessage = array_merge($validateMessage, $this->validateMessage);
    }

    return $this->validate($request,$validate,$validateMessage);
  }

}
