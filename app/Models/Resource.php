<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Resource extends Model
{



    public function getStructure() {
        $columnModel = (array)Schema::getColumnListing($this->getTable());
        $withoutColumnModel = ['id',$this->getKeyName(),'deleted_at','created_at','updated_at'];
        $fillable = array_diff( $columnModel, $withoutColumnModel);
        return $fillable;
    }


    public function checkTableExists($table_name) {
        return Schema::hasTable($table_name);
    }
}
