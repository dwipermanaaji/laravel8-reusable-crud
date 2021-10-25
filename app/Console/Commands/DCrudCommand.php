<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DCrudCommand extends Command
{

    protected $signature = 'dcrud:generate
    {name : The name of the Crud.}
    
    ';

    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return 0;
    }
}
