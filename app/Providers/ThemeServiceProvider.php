<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\ThemeHelper;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Compartilhar variáveis de tema com todas as views
        View::composer('*', function ($view) {
            $view->with('themeConfig', config('theme'));
            $view->with('themeCss', ThemeHelper::generateCssVariables());
        });
    }

    public function register()
    {
        //
    }
}
