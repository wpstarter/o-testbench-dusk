<?php

namespace Orchestra\Testbench\Dusk\Foundation;

use WpStarter\Support\ServiceProvider;

class TestbenchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\DuskCommand::class,
                Console\PurgeCommand::class,
            ]);
        }
    }
}
