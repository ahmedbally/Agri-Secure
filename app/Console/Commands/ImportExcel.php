<?php

namespace App\Console\Commands;

use App\Imports\CityCropImport;
use App\Imports\CityCropSheets;
use Illuminate\Console\Command;

class ImportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

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

        (new CityCropImport())->withOutput($this->output)->import('rice.xlsx');
        $this->output->success('Import successful');
    }
}
