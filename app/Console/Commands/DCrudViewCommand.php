<?php

namespace App\Console\Commands;

use Str;
use File;
use Illuminate\Console\Command;
use App\Console\Services\TypeLookupService;

class DCrudViewCommand extends Command
{
    use TypeLookupService;

    protected $signature = 'dcrud:view
                            {name : The name of the Crud.}
                            {--fields= : The fields name for the form.}
                            {--view-path= : The name of the view path.}
                            {--route-name= : Route Name.}';

    protected $description = 'Create views for the Crud.';

    protected $viewDirectoryPath;


    public function __construct()
    {
        parent::__construct();

        $this->viewDirectoryPath = __DIR__ . '/stubs/';
    }


    public function handle()
    {
        $crudName  = $this->argument('name');
        $routeName = $this->option('route-name');
        $viewDirectory = config('view.paths')[0] . '/';
        if ($this->option('view-path')) {
            $userPath = $this->option('view-path');
            $path = $viewDirectory . $userPath . '/' ;
        } else {
            $path = $viewDirectory . $crudName . '/';
        }

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $fields = $this->option('fields');
        $fieldsArray = explode(',', $fields);
        $data = array();
        if ($fields) {
            $x = 0;
            foreach ($fieldsArray as $item) {
                $fieldArray = explode(':', $item);
                $data[$x]['name'] = trim($fieldArray[0]);
                $data[$x]['type'] = (isset($fieldArray[1])) ? trim($fieldArray[1]) : 'string';
                $x++;
            }
        }

        $formFieldsHtml = '';
        foreach ($data as $key => $value) {
            $formFieldsHtml .= $this->createField($value);
        }

        // For form.blade.php file
        $formFile = $this->viewDirectoryPath . 'form.blade.stub';
        $newFormFile = $path . 'form.blade.php';
        if (!File::copy($formFile, $newFormFile)) {
            echo "failed to copy $formFile...\n";
        } else {
            $this->templateFormVars($formFieldsHtml,$newFormFile);
        }

        $this->info('View created successfully.');
    }

    protected function createField($item)
    {
        $type = $this->typeLookup[$item['type']];
        $field = "
        <div class='form-group col-6'>
            @include('base-component.base-form-component.".$type."', ['forms' => \$forms->".$item['name']."])
        </div>
        ";
        return $field;
    }

    protected function templateFormVars($formFieldsHtml, $newFormFile)
    {
        File::put($newFormFile, str_replace('%%forms%%', $formFieldsHtml, File::get($newFormFile)));
    }
}
