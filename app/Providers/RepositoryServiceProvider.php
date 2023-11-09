<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $models = [
            'User'
        ];
        foreach ($models as $model) {
            $repository = "App\Repositories\\{$model}\\{$model}Repository";
            $this->app->singleton($repository."Interface", $repository);
        }
    }
}
