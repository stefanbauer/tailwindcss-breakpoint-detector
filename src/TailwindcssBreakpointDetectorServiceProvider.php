<?php

namespace StefanBauer\TailwindcssBreakpointDetector;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use StefanBauer\TailwindcssBreakpointDetector\Middleware\InjectDetector;

class TailwindcssBreakpointDetectorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tailwindcss-breakpoint-detector');

        /** @var \Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app[Kernel::class];
        $kernel->prependMiddleware(InjectDetector::class);
    }

    public function register()
    {
    }
}
