<?php

namespace App\Http\Controllers\BaseComponent\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormKey
{
    public $name = null;
    public $type = 'text';
    public $label = null;
    public $value = null;
    public $option = null;
    public $list = [];
    public $selected = null;
    public $checked = null;
    public $create = true;
    public $edit = true;
    public $formType = null;
    public $route = null;
    public $colForm = 6;
    public $validate = null;    
}
