<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Artisan::command('app:check-missed-follow-up-command', function () {
//     $this->call('app:check-missed-follow-up-command');
// })->purpose('Check missed follow up')->every15Minutes();



Schedule::command('app:check-missed-follow-up-command')->everyFiveMinutes();