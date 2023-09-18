<?php

namespace App\Console\Commands;

use App\Services\SyncUserHeadcount;
use Illuminate\Console\Command;

class SyncHeadcount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:headcount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for Syncing Headcount to CRM';

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
    public function handle(SyncUserHeadcount $sync)
    {
        $sync->users();
    }
}
