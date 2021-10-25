<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class DCrudModelCommand extends GeneratorCommand
{
    protected $signature = 'crud:model
                            {name : The name of the model.}
                            {--table= : The name of the table.}
                            {--fillable= : The names of the fillable columns.}';

    protected $description = 'Create a new model.';
    protected $type = 'Model';


    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace. '\Models';
    }

    public function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $table = $this->option('table') ? : $this->argument('name');
        $fillable = $this->option('fillable');
        return $this->replaceNamespace($stub, $name)
            ->replaceTable($stub, $table)
            ->replaceFillable($stub, $fillable)
            ->replaceClass($stub, $name);        
    }

    protected function replaceTable(&$stub, $table)
    {
        $stub = str_replace(
            '{{table}}', $table, $stub
        );

        return $this;
    }

    protected function replaceFillable(&$stub, $fillable)
    {
        $stub = str_replace(
            '{{fillable}}', $fillable, $stub
        );

        return $this;
    }
}
