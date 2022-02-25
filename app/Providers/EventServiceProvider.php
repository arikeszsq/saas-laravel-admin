<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use \SocialiteProviders\Facebook\FacebookExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SocialiteWasCalled::class => [
            FacebookExtendSocialite::class.'@handle',
        ],
        UserRegistered::class => [
            SendEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
