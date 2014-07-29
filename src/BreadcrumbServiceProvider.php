<?php namespace Nurmanhabib\Breadcrumb;

use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('breadcrumb', function()
        {
            return new Breadcrumb;
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Fondation\AliasLoader::getInstance();
            $loader->alias('Breadcrumb', 'Nurmanhabib\Breadcrumb\Facades\Breadcrumb');
        });
    }

}