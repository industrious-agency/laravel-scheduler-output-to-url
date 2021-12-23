<?php

namespace Industrious\SchedulerOutputToUrl;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;

class SchedulerOutputToUrlServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $app = $this->app;

        Event::macro('sendOutputToUrl', function (string $url, string $method = 'POST') use ($app) {
            /** @var Event $this */

            if (! $this->isDue($app)) {
                return;
            }

            $this->thenWithOutput(function (Stringable $output) use ($url, $method) {
                if ($output->isEmpty()) {
                    return;
                }

                $options = $method === 'POST' ? [
                    'body' => $output,
                ] : [];

                Http::send($method, $url, $options)
                    ->onError(function (Response $request) {
                        Log::error($request->toException()->getMessage());
                    });
            }, true);
        });
    }
}