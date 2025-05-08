<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\TestJob as TestJobJob;

class TestJob extends Command
{
    protected $signature = 'test-job';


    protected $description = 'Command description';


    public function handle()
    {
        TestJobJob::dispatch();
        $this->info('Test job dispatched successfully');


    }
}
