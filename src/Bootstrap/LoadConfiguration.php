<?php

namespace Orchestra\Testbench\Dusk\Bootstrap;

use WpStarter\Config\Repository;
use WpStarter\Contracts\Config\Repository as RepositoryContract;
use WpStarter\Contracts\Foundation\Application;
use Symfony\Component\Finder\Finder;

class LoadConfiguration
{
    /**
     * Bootstrap the given application.
     *
     * @param  \WpStarter\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $items = [];

        $app->instance('config', $config = new Repository($items));

        $this->loadConfigurationFiles($app, $config);

        mb_internal_encoding('UTF-8');
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  \WpStarter\Contracts\Foundation\Application  $app
     * @param  \WpStarter\Contracts\Config\Repository  $config
     * @return void
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $config)
    {
        foreach ($this->getConfigurationFiles($app) as $key => $path) {
            $config->set($key, require $path);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \WpStarter\Contracts\Foundation\Application  $app
     * @return \Generator
     */
    protected function getConfigurationFiles(Application $app)
    {
        if (! is_dir($path = $app->basePath('config'))) {
            $path = realpath(__DIR__.'/../../laravel/config');
        }

        foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
            yield basename($file->getRealPath(), '.php') => $file->getRealPath();
        }
    }
}
