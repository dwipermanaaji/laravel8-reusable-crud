<?php

namespace App\Http\Controllers\Examples;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseComponent\BaseController;

class ExampleFormController extends BaseController
{
    protected $f_model = 'Example';
    protected $title = 'Examples';
    protected $route = 'examples-crud';    


    public $datatableRows = [
        ['data' => 'id', 'title' => 'id', 'orderable' => true, 'searchable' => true],
        ['data' => 'field2', 'title' => 'Field 1', 'orderable' => true, 'searchable' => true],
        ['data' => 'field3', 'title' => 'Field 3', 'orderable' => true, 'searchable' => true],
        ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'width'=>'130px'],
    ];

}
