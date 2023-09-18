<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\sendMortgageDataToSap::class,
        Commands\sendSolarsDataToSap::class,
        Commands\sendHomeWarrantyDataToSap::class,
        Commands\CruSale::class,
        Commands\CaxSale::class,
        Commands\CmuSale::class,
        Commands\FixedPriceSale::class,
        Commands\EddySale::class,
        Commands\Sync_HeadCount_Hcm::class,
        Commands\UpdateQAScore::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('queue:work')->everyMinute()->withoutOverlapping();
        $schedule->command('sendSolarsDataToSap:cron')->hourly()->runInBackground();
        $schedule->command('sendHomeWarrantyDataToSap:cron')->hourly()->runInBackground();
        $schedule->command('sendMortgageDataToSap:cron')->hourly()->runInBackground();
        $schedule->command('Sync_HeadCount_Project:cron')->everyTwoHours()->runInBackground();
        $schedule->command('Sync_HeadCount_Hcm:cron')->everyTwoHours()->runInBackground();
        $schedule->command('UpdateQAScore:cron')->everyFiveMinutes()->runInBackground();
        $schedule->command('CruSale:cron')->dailyAt('13:00');
        $schedule->command('CaxSale:cron')->dailyAt('13:00');
        $schedule->command('CmuSale:cron')->dailyAt('13:00');
        $schedule->command('FixedPriceSale:cron')->dailyAt('13:00');
        $schedule->command('EddySale:cron')->dailyAt('13:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
