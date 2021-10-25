<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Resource extends Model
{
    protected $structures = [];
    public $datatableRows = [
        ['data' => 'id', 'title' => 'id', 'orderable' => true, 'searchable' => true],
        ['data' => 'field2', 'title' => 'Field 1', 'orderable' => true, 'searchable' => true],
        ['data' => 'field3', 'title' => 'Field 3', 'orderable' => true, 'searchable' => true],
        ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'width'=>'130px'],
    ];

    public function getStructure() {
        $columnModel = Schema::getColumnListing($this->getTable());
 
    }

}
