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

    protected $customPage = [
        'form' => 'examples.example-crud.form'
    ];
}
