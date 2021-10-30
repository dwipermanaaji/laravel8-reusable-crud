<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Str;

class DCrudControllerCommand extends GeneratorCommand
{

    protected $signature = 'dcrud:controller
                            {name : The name of the controler.}
                            {--model-name= : The name of the Model.}
                            {--route= : The name of the route name.}
                            {--fields= : Fields name for the form & model.}
                            {--view-path= : The name of the view path.}
                            {--example}
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
        $route = $this->option('route');
        $viewPath = $this->option('view-path');
        $fields = $this->option('fields');
        $fields = explode(',', $fields);
        $example = $this->option('example');

        $data = [];
        $forms = '';
        $rowsdatatableColumn = "";
        if ($fields[0] != '') {
            $x = 0;
            foreach ($fields as $field) {
                $fieldArray = explode(':', $field);
                $data[$x]['name'] = trim($fieldArray[0]);
                $data[$x]['type'] = (isset($fieldArray[1])) ? trim($fieldArray[1]) : 'text';
                $x++;
            }


            $rowsdatatableColumn = "\t\t";
            foreach ($data as $item) {
                $dataTable = "['data' => '".$item['name']."', 'title' => '".Str::headline($item['name'])."', 'orderable' => true, 'searchable' => true],\n\t\t\t";
                $rowsdatatableColumn .= $dataTable;
            }

            foreach ($data as $key => $item) {
                $form = "'".$item['name']."'=>[
                    'name'=> '".$item['name']."',
                    'type'=> 'text',
                    'label'=> '".Str::headline($item['name'])."',
                    'option'=> [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder'=>'Enter ".Str::headline($item['name'])."',
                    ],
                ],";
                if($key != 0){
                    $form .= "\n\t\t\t";
                }
                $forms .= $form;
            }
            
        }




    $customPage = '';
    if($viewPath!=null){
    $customPage = "
    protected \$customPage = [
        'index' => '".$viewPath.".index',
        'show' => '".$viewPath.".show',
        'create' => '".$viewPath.".create',
        'edit' => '".$viewPath.".edit',
        'form' => '".$viewPath.".form',
    ];";
    }


        return $this->replaceNamespace($stub, $name)
            ->replaceModelName($stub, $modelName)
            ->replaceModelTitle($stub, Str::headline(class_basename($modelName)))
            ->replaceRoute($stub, $route)
            ->replaceRowsdatatableColumn($stub, $rowsdatatableColumn)
            ->replaceForms($stub, $forms)
            ->replaceCustomPage($stub, $customPage)
            ->replaceExample($stub, $example)
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
    protected function replaceRoute(&$stub, $route)
    {
        $stub = str_replace(
            '{{route}}', $route, $stub
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
}
