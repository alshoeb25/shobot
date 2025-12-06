<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Organization::class => \App\Policies\OrganizationPolicy::class,
         \App\Models\BotQuestion::class => \App\Policies\BotQuestionPolicy::class,
    ];


    public function boot(): void
    {
        //
    }
}
