<?php

namespace App\Console\Commands;

use App\Console\Services\TypeLookupService;
use Illuminate\Console\GeneratorCommand;
use Spatie\Permission\Models\Permission;
use Str;
use DB;

class DCrudControllerCommand extends GeneratorCommand
{
    use TypeLookupService;

    protected $signature = 'dcrud:controller
                            {name : The name of the controler.}
                            {--model-name= : The name of the Model.}
                            {--route-name= : The name of the route name.}
                            {--fields= : Fields name for the form & model.}
                            {--view-path= : The name of the view path.}
                            {--folder-view= : Folder Views.}
                            {--example}
                            {--form}
                            {--auth-name= :auth_name}
                            ';

    protected $description = 'Create a new resource controller.';
    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }


    public function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $modelName = $this->option('model-name');
        $routeName = $this->option('route-name');
        $viewPath = $this->option('view-path');
        $fields = $this->option('fields');
        $fields = explode(',', $fields);
        $example = $this->option('example');
        $form = $this->option('form');
        $folderView = $this->option('folder-view');
        $authName = Str::kebab($this->option('auth-name'));
        

        $data = [];
        $forms = '';
        $rowsdatatableColumn = "";
        if ($fields[0] != '') {
            $x = 0;
            foreach ($fields as $field) {
                $fieldArray = explode(':', $field);
                $data[$x]['name'] = trim($fieldArray[0]);
                $data[$x]['type'] = (isset($fieldArray[1])) ? trim($fieldArray[1]) : 'string';
                $x++;
            }


            $rowsdatatableColumn = "\t\t";
            foreach ($data as $item) {
                $dataTable = "['data' => '".$item['name']."', 'title' => '".Str::headline($item['name'])."', 'orderable' => true, 'searchable' => true],\n\t\t\t";
                $rowsdatatableColumn .= $dataTable;
            }

            foreach ($data as $key => $item) {
                $formField = "'".$item['name']."'=>[
                    'name'=> '".$item['name']."',
                    'type'=> '".$this->typeLookup[$item['type']]."',
                    'label'=> '".Str::headline($item['name'])."',
                    'option'=> [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder'=>'Enter ".Str::headline($item['name'])."',
                    ],
                ],";
                if($key != 0){
                    $formField .= "\n\t\t\t";
                }
                $forms .= $formField;
            }
            
        }


    $customPage = '';
    if($form){
    $customPage = "
    protected \$customPage = [
        'form' => '".$folderView.".form',
    ];
    ";
    }

    if($viewPath != null){
    $viewPath = Str::replace('\\', '.', Str::kebab($viewPath));
    $customPage = "
    protected \$customPage = [
        'form' => '".$viewPath.".form',
    ];
    ";
    }


    $replaceAuthName = '';
    if($authName != null){
        Permission::firstOrCreate(['name' => $authName.'.list']);
        Permission::firstOrCreate(['name' => $authName.'.create']);
        Permission::firstOrCreate(['name' => $authName.'.read']);
        Permission::firstOrCreate(['name' => $authName.'.update']);
        Permission::firstOrCreate(['name' => $authName.'.destroy']);

        $this->info("Permission '".$authName."' created");

        $replaceAuthName = "protected \$auth_name = '".$authName."';";   
    }


        return $this->replaceNamespace($stub, $name)
            ->replaceModelName($stub, $modelName)
            ->replaceModelTitle($stub, Str::headline(class_basename($modelName)))
            ->replaceRoute($stub, $routeName)
            ->replaceRowsdatatableColumn($stub, $rowsdatatableColumn)
            ->replaceForms($stub, $forms)
            ->replaceCustomPage($stub, $customPage)
            ->replaceExample($stub, $example)
            ->replaceAuthName($stub, $replaceAuthName)
            ->replaceClass($stub, $name);
    }



    protected function replaceModelName(&$stub, $modelName)
    {
        $stub = str_replace(
            '{{modelName}}', $modelName, $stub
        );

        return $this;
    }

    
    protected function replaceModelTitle(&$stub, $title)
    {
        $stub = str_replace(
            '{{title}}', $title, $stub
        );
        return $this;
    }
    protected function replaceRoute(&$stub, $routeName)
    {
        $stub = str_replace(
            '{{route-name}}', $routeName, $stub
        );

        return $this;
    }
    protected function replaceRowsdatatableColumn(&$stub, $rowsdatatableColumn)
    {
        $stub = str_replace(
            '{{rowsdatatableColumn}}', $rowsdatatableColumn, $stub
        );

        return $this;
    }
    protected function replaceForms(&$stub, $forms)
    {
        $stub = str_replace(
            '{{forms}}', $forms, $stub
        );
        return $this;
    }
    protected function replaceCustomPage(&$stub, $customPage)
    {
        $stub = str_replace(
            '{{customPage}}', $customPage, $stub
        );
        return $this;
    }

    protected function replaceExample(&$stub, $example = false)
    {
        $exampleCode = "";
        if($example){
            $exampleCode = $this->files->get(__DIR__ . '/stubs/exampleController.stub');
        }
        $stub = str_replace(
            '{{example}}', $exampleCode, $stub
        );
        return $this;   
    }
    protected function replaceAuthName(&$stub, $replaceAuthName = '')
    {
        $stub = str_replace(
            '{{auth_name}}', $replaceAuthName, $stub
        );
        return $this;   
    }    
}
