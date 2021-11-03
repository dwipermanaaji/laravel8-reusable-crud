<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use Str;

class DCrudCommand extends Command
{

    protected $signature = 'dcrud:generate
        {name : The name of the Crud.}
        {--fields= : Fields name for the form & model.}
        {--view-path= : The name of the view path.}
        {--controller-namespace= : Namespace of the controller.}
        {--model-namespace= : Namespace of the controller.}
        {--pk=id : The name of the primary key.}
        {--route : Include Crud route to routes.php.}
        {--example : Include exmaple code with comment}
        {--form : Include form.blade.php in folder views }
        {--auth-name= : auth_name}
    ';

    protected $description = 'Command description';
    protected $routeName = '';
    protected $controller = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $className = class_basename($this->argument('name'));
        $modelName = Str::singular($name);
        $migrationName = Str::plural(Str::lower($className));
        $tableName = $migrationName;
        $viewName = Str::replace('\\-', '\\', Str::kebab($name));;
        $routeName = Str::kebab($className);

        $example = $this->option('example');
        $form = $this->option('form');
        $authName = $this->option('auth-name');
        


        $primaryKey = $this->option('pk');
        $fields = $this->option('fields');


        $fieldsArray = explode(',', $fields);
        foreach ($fieldsArray as $item) {
            $fillableArray[] = preg_replace("/(.*?):(.*)/", "$1", trim($item));
        }

        $commaSeparetedString = implode("', '", $fillableArray);
        $fillable = "['" . $commaSeparetedString . "']";
        $viewPath = $this->option('view-path') ;


        $folderView =  Str::replace('\\-', '.', Str::kebab($name));
        if($this->option('view-path') != null){
            $folderView = $this->option('view-path') .'.'. Str::kebab($className);
        }


        $controllerNamespace = ($this->option('controller-namespace'));
        $controllerNamespace = ($controllerNamespace != null) ? $controllerNamespace .'\\'. $className . 'Controller' : $name . 'Controller';
        $modelNamespace = $this->option('model-namespace');
        $this->call('dcrud:controller', [
                    'name' => $controllerNamespace ,
                    '--view-path'=>$viewPath, 
                    '--fields'=>$fields,
                    '--model-name' => $modelName, 
                    '--route-name'=>$routeName, 
                    '--example'=>$example, 
                    '--form'=>$form,
                    '--folder-view'=>$folderView,
                    '--auth-name'=>$authName,
                ]);
        $this->call('crud:model', ['name' => $modelName, '--fillable' => $fillable, '--table' => $tableName]);
        $this->call('dcrud:migration', ['name' => $migrationName, '--schema' => $fields, '--pk' => $primaryKey]);
       
        if($form){
            $this->call('dcrud:view', [
                'name' => $viewName, 
                '--fields' => $fields, 
                '--view-path' => $viewPath,
                '--route-name'=>$routeName,
            ]);
        }

        $this->callSilent('optimize');
        $routeFile = base_path('routes/web.php'); 
        if(file_exists($routeFile) && ($this->option('route'))){
            $this->controller = $controllerNamespace;
            $this->routeName = $routeName;
            
            $isAdded = File::append($routeFile,
                "\nRoute::group(['middleware' => ['auth:sanctum', 'verified']], function () {"
                . "\n\t" . implode("\n\t", $this->addRoutes())
                . "\n\t" . implode("\n\t", $this->addRouteDataTable())
                . "\n});"
            );
            $this->callSilent('route:clear');
        }

    }
    protected function addRoutes() {
        return ["Route::resource('" . $this->routeName. "', 'App\Http\Controllers\\" . $this->controller . "');"];
    }    
    protected function addRouteDataTable()
    {
        return ["Route::get('datatable/" . $this->routeName. "',['App\Http\Controllers\\" . $this->controller . "','dataTable'])->name('".$this->routeName.".datatable');"];
    }
}
