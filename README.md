# Laravel Scheduler Output to Url

## About this package
Laravel scheduler output to url was created for the sole purpose to have the ability
to submit the scheduled command output to a designated URL I.E. https://healthchecks.io/
via HTTP request (I.E. POST/GET etc).

## Example

````
$schedule
    ->command(SomeCommand::class)
    ->dailyAt('00:00')
    ->sendOutputToUrl('https://hc-ping.com/uuid-here');
````