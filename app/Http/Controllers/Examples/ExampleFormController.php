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

    protected array $customPage = [
        'form' => 'examples.example-crud.form',
    ];

    protected array $auths = [
        'all',
    ];



    public function _setForm($method)
    {
        $forms = [
            'field2'=>[
                'name'=> "field2",
                'type'=> "text",
                'label'=> "Field 2",
                'option'=> [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Enter Field 2'
                ],
            ],
            'field3'=>[
                'name'=> "field3",
                'type'=> "text",
                'label'=> "Field 4",
                'option'=> [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Enter Field 3'
                ],
            ],
            'field4'=>[
                'name'=> "field4",
                'type'=> "text",
                'label'=> "Field 4",
                'option'=> [
                    'class' => 'form-control',
                    'required' => 'required',
                    'placeholder' => 'Enter Field 4'
                ],
            ],
        ];

        return $forms;
    }
  



    // protected $customPage = [
    //     'index' => null,
    //     'show' => null,
    //     'create' => null,
    //     'edit' => null,
    //     'form' => null,
    // ];

    // protected $customRoute = [
    //     'index' => null,
    //     'create' => null,
    //     'store' => null,
    //     'show' => null,
    //     'edit' => null,
    //     'update' => null,
    //     'destroy' => null,
    //     'dataTable' => null,
    // ];

    // public $rowsdatatableColumn = [
    //     ['data' => 'peg_nipp', 'title' => 'NIPP', 'orderable' => false, 'searchable' => true, 'width' => '150px'],
    //     ['data' => 'peg_nama', 'title' => 'Nama Pegawai', 'orderable' => false, 'searchable' => true],
    //     ['data' => 'status_pegawai.stskerja_ket', 'title' => 'Status Kerja', 'orderable' => false, 'searchable' => true, 'width' => '170px'],
    //     ['data' => 'action', 'title' => 'Opsi', 'orderable' => false, 'searchable' => false, 'width' => '130px'],
    // ];

    /**
     * fungsi _setForm membuat form create & edit
     * bisa ditambahkan switch case seperti fungsi _getRelatedData
     * atau tambahakan menonaktifkan lewa code 'field2'=>['create'=>false];
     */    
    // public function _setForm($method)
    // {
    //     $forms = [
    //         'field2'=>[
    //             'name'=> "field2",
    //             'type'=> "text",
    //             'label'=> "Field 2",
    //             'value'=> null,
    //             'option'=> [
    //                 'class' => 'form-control',
    //                 'required' => 'required',
    //             ],
    //             'list'=> null,
    //             'selected'=> null,
    //             'checked'=> null,
    //             'create'=> true,
    //             'edit'=> true,
    //             'formType'=> $method, //bisa create atau edit
    //             'route'=> true,
    //             'colForm'=> 6,
    //         ],
    //     ];
    //     return $forms;
    // }
  

        
    /**
     * fungsi _getRelatedData untuk mengirim data ke create & edit 
     */
    // public function _getRelatedData($method)
    // {
    //     $data = [];
    //     switch ($method) {
    //         case 'create':
    //             $data = ''; //memanggil model 
    //         case 'edit':
    //             $data = ''; //memanggil model
    //         break;
    //     }
    //     return $data;
    // }


    /**
     * fungsi _validateRequest untuk mengcustom validasi data
     */
    // public function _validateRequest($request, $method)
    // {
    //     switch ($method) {
    //         case 'create':
    //             $this->validate($request,[yang mau di validasi])
    //         case 'edit':
    //             $this->validate($request,[yang mau di validasi])
    //         break;
    //     }
    // }


    /**
     * fungsi _store untuk mengcustom pembuatan data ke model 
     */
    // public function _store($request)
    // {
    //    $data = Model::create($request);
    //    return $data;
    // }

    /**
     * fungsi _update untuk mengcustom pengeditan data ke model 
     */
    // public function _update($request, $id)
    // {
    //    $data = Model::find($id)->update($request);
    //    return $data;
    // }

    /**
     * fungsi _destroy untuk mengcustom penghapusan data ke model 
     */
    // public function _destroy($id)
    // {
    //    $data = Model::find($id)->delete();
    //    return $data;
    // }

    /**
     * fungsi _redirectAfterSave untuk mengcustom redirect setelah store dan update
     */
    // public function _redirectAfterSave($request, $method)
    // {
    //     $data = [];
    //     switch ($method) {
    //         case 'create':
    //             return redirect(route('nama-route'));
    //         case 'edit':
    //             return redirect(route('nama-route'));
    //         break;
    //     }
    // }

    
}
