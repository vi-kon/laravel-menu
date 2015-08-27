<?php

namespace ViKon\Menu;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class MenuServiceProvider
 *
 * @package ViKon\Menu
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class MenuServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->app->singleton(MenuManager::class, function (Application $app) {
            return new MenuManager($app);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [MenuManager::class];
    }
}