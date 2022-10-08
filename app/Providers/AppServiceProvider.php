<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\pt_BR\Address;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            $factory = Factory::create('pt_BR');
            $factory->addProvider(Address::class);

            return $factory;
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
