<?php

namespace App\Providers;

use App\Models\PlayerNote;
use App\Policies\PlayerNotePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PlayerNote::class => PlayerNotePolicy::class,
    ];

}
