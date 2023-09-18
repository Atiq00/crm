<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $mysql_link = @mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));
        if (mysqli_connect_errno() || !DB::getSchemaBuilder()->hasTable('settings') ) {
            return;
        }

        // dd( env('DB_DATABASE') );
        
        $config = array(
            'driver'     => @(DB::table('settings')->where('key', 'mail_driver')->first()->value),
            'host'       => @(DB::table('settings')->where('key', 'mail_host')->first()->value),
            'port'       => @(DB::table('settings')->where('key', 'mail_port')->first()->value),
            'from'       => @array('address' => @(DB::table('settings')->where('key', 'mail_from_address')->first()->value), 'name' => @(DB::table('settings')->where('key', 'mail_from_name')->first()->value)),
            'encryption' => @(DB::table('settings')->where('key', 'mail_encryption')->first()->value),
            'username'   => @(DB::table('settings')->where('key', 'mail_username')->first()->value),
            'password'   => @(DB::table('settings')->where('key', 'mail_password')->first()->value),
            'sendmail'   => @'/usr/sbin/sendmail -bs',
            'pretend'    => @false,
        );
        Config::set('mail', $config);
    }
}