<?php

namespace App;

use App\Helpers\PollWriter;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class LarapollServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPollWriter();
    }

    /**
     * Boot What is needed
     */
    public function boot()
    {
        //
    }

    /**
     * Register the poll writer instance.
     *
     * @return void
     */
    protected function registerPollWriter()
    {
        $this->app->singleton('pollwritter', function ($app) {
            return new PollWriter();
        });
    }
}
