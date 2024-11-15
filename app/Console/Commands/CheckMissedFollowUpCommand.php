<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FollowUpMissedJob;

class CheckMissedFollowUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-missed-follow-up-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'a command to check missed follow ups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new FollowUpMissedJob());
    }
}
