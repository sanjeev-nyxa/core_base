<?php

namespace Labs\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Labs\Modules\Contracts\RepositoryInterface;
use Labs\Modules\Laravel\LaravelFileRepository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, LaravelFileRepository::class);
    }
}
