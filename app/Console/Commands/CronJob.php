<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronJobController;
use Illuminate\Console\Command;

class CronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronJob:convert_currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job run successfully.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $obj = new CronJobController();
        $obj->currencyConverter();
        $this->info('CronJob:convert_currency command run successfully!');

    }
}
