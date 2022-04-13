<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Vanthao03596\LaravelPasswordHistory\Models\PasswordHistory;

class FillPasswordHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:password-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Password History';

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
     * @return int
     */
    public function handle()
    {
        User::all()->each(function ($user) {
            $passwordHistory= new PasswordHistory();
            $passwordHistory->model_type='App\User';
            $passwordHistory->model_id=$user->id;
            $passwordHistory->password=$user->password;
            $passwordHistory->changed_at=now();
            $passwordHistory->save();
        });
        return 0;
    }
}
