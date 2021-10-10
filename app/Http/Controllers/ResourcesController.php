<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseComponent\BaseController;
use App\Models\Resources;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ResourcesController extends BaseController
{

    public function __construct(Request $request)
    {
        try {
            $this->segment = $request->segment(1);

            $this->f_model = Str::studly($this->segment);  
            $this->title = Str::studly($this->segment); 
            $this->route = $this->segment;             
        } catch (Exception $e) {
            $this->_handleDBTransactionError($e);
        }

        parent::__construct();
    }

}
