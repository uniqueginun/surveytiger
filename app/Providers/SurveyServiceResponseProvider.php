<?php

namespace App\Providers;

use App\Services\Responses\DropdownService;
use App\Services\Responses\MultichoiceService;
use App\Services\Responses\RankingService;
use App\Services\Responses\RatingService;
use App\Services\Responses\SinglechoiceService;
use App\Services\Responses\SliderService;
use App\Services\Responses\TextboxService;
use Illuminate\Support\ServiceProvider;

class SurveyServiceResponseProvider extends ServiceProvider
{

    protected $serviceList = [
        MultichoiceService::class,
        SinglechoiceService::class,
        RatingService::class,
        RankingService::class,
        SliderService::class,
        TextboxService::class,
        DropdownService::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->serviceList as $service) {
            $this->app->bind("$service", function () use ($service) {
                return new $service();
            });
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
