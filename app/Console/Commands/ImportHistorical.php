<?php

namespace App\Console\Commands;

use App\Imports\CropStructure;
use App\Imports\HistoricalPrice;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportHistorical extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:historical';

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
        Excel::import(new HistoricalPrice, 'Prices_db.xls');
        $this->output->success('Import successful');
    }
}
