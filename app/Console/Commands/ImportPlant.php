<?php

namespace App\Console\Commands;

use App\Imports\PlantProduction;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportPlant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:plant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->title('Starting import');
        Excel::import(new PlantProduction(), 'Crops_DB_2.xls');
        $this->output->success('Import successful');
    }
}
