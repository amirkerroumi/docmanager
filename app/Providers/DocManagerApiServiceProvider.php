<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Services\DocManagerApiService;
use Illuminate\Support\ServiceProvider;
class DocManagerApiServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind('DocManagerApiService', function(){
            return new DocManagerApiService();
        });
    }
}
