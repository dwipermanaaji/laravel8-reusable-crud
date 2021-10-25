<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class DCrudMigrationCommand extends GeneratorCommand
{
    protected $signature = 'dcrud:migration
                            {name : The name of the migration.}
                            {--schema= : The name of the schema.}
                            {--pk=id : The name of the primary key.}';

    protected $description = 'Create a new migration.';


    protected $type = 'Migration';

    protected function getStub()
    {
        return  __DIR__ . '/stubs/migration.stub';
    }


    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);
        $datePrefix = date('Y_m_d_His');

        return database_path('/migrations/') . $datePrefix . '_create_' . $name . '_table.php';
    }


    protected  function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $tableName = $this->argument('name');
        $className = 'Create' . ucwords($tableName) . 'Table';
        $schema = $this->option('schema');
        $primaryKey = $this->option('pk');
        $fields = explode(',', $schema);
    
        $data = [];
        if ($schema) {
            $x = 0;
            foreach ($fields as $field) {
                $fieldArray = explode(':', $field);
                $data[$x]['name'] = trim($fieldArray[0]);
                $data[$x]['type'] = (isset($fieldArray[1])) ? trim($fieldArray[1]) : 'string';
                $x++;
            }
        }

        $schemaFields = '';
        foreach ($data as $item) {
            $schemaFields .= $this->generateSchemaField($item)."\n \t\t\t";
        }

    $schemaUp = "\tSchema::create('" . $tableName . "', function(Blueprint \$table) {
            \$table->id('" . $primaryKey . "');
            ". $schemaFields ."\$table->timestamps();
            // \$table->softDeletes();
        });";



    $schemaDown = "Schema::drop('" . $tableName . "');";
        return $this->replaceSchemaUp($stub, $schemaUp)
            ->replaceSchemaDown($stub, $schemaDown)
            ->replaceClass($stub, $className);
    }

    protected function replaceSchemaUp(&$stub, $schemaUp)
    {
        $stub = str_replace(
            '{{schema_up}}', $schemaUp, $stub
        );

        return $this;
    }

    protected function replaceSchemaDown(&$stub, $schemaDown)
    {
        $stub = str_replace(
            '{{schema_down}}', $schemaDown, $stub
        );

        return $this;
    }

    private function generateSchemaField($item)
    {
        $schemaFields = '';
        switch ($item['type']) {
            case 'char':
                $schemaFields = "\$table->char('" . $item['name'] . "');";
                break;

            case 'date':
                $schemaFields = "\$table->date('" . $item['name'] . "');";
                break;

            case 'foreign':
                $model=explode("_", $item['name']);
                $schemaFields = "\$table->foreign('" . $item['name'] . "')->references('id')->on('" . $model[0]. "s')->onDelete('cascade');";
                $schemaFields = "\$table->integer('" . $item['name'] . "')->unsigned();";
                break;

            case 'file':
                $schemaFields = "\$table->dateTime('" . $item['name'] . "', 512);";
                break;

            case 'datetime':
                $schemaFields = "\$table->dateTime('" . $item['name'] . "');";
                break;

            case 'time':
                $schemaFields = "\$table->time('" . $item['name'] . "');";
                break;

            case 'timestamp':
                $schemaFields = "\$table->timestamp('" . $item['name'] . "');";
                break;

            case 'text':
                $schemaFields = "\$table->text('" . $item['name'] . "');";
                break;

            case 'mediumtext':
                $schemaFields = "\$table->mediumText('" . $item['name'] . "');";
                break;

            case 'longtext':
                $schemaFields = "\$table->longText('" . $item['name'] . "');";
                break;

            case 'json':
                $schemaFields = "\$table->json('" . $item['name'] . "');";
                break;

            case 'jsonb':
                $schemaFields = "\$table->jsonb('" . $item['name'] . "');";
                break;

            case 'binary':
                $schemaFields = "\$table->binary('" . $item['name'] . "');";
                break;

            case 'number':
            case 'integer':
                $schemaFields = "\$table->integer('" . $item['name'] . "');";
                break;

            case 'bigint':
                $schemaFields = "\$table->bigInteger('" . $item['name'] . "');";
                break;

            case 'mediumint':
                $schemaFields = "\$table->mediumInteger('" . $item['name'] . "');";
                break;

            case 'tinyint':
                $schemaFields = "\$table->tinyInteger('" . $item['name'] . "');";
                break;

            case 'smallint':
                $schemaFields = "\$table->smallInteger('" . $item['name'] . "');";
                break;

            case 'boolean':
                $schemaFields = "\$table->boolean('" . $item['name'] . "');";
                break;

            case 'decimal':
                $schemaFields = "\$table->decimal('" . $item['name'] . "');";
                break;

            case 'double':
                $schemaFields = "\$table->double('" . $item['name'] . "');";
                break;

            case 'float':
                $schemaFields = "\$table->float('" . $item['name'] . "');";
                break;

            default:
                $schemaFields = "\$table->string('" . $item['name'] . "');";
                break;
        }
        return $schemaFields;
    } 
}
