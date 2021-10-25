<?php

namespace App\Http\Controllers\BaseComponent\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait HandleError
{
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