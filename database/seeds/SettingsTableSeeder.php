<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([[
                'key' => 'date_format',
                'value' => 'd M, Y',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'datetime_format',
                'value' => 'd M, Y',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'site_title',
                'value' => env('APP_NAME'),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'site_description',
                'value' => 'Description for your portal !',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'site_logo',
                'value' => 'default.png',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'site_favicon',
                'value' => 'favicon.png',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'RECAPTCH_TYPE',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'GOOGLE_RECAPTCHA_KEY',
                'value' => '',
                // 'value' => '6LdIWswUAAAAAMRp6xt2wBu7V59jUvZvKWf_rbJc',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'GOOGLE_RECAPTCHA_SECRET',
                'value' => '',
                // 'value' => '6LdIWswUAAAAAIsdboq_76c63PHFsOPJHNR-z-75',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'USER_REOPEN_ISSUE',
                'value' => 'yes',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'CUSTOMER_CLOSE_TICKET',
                'value' => 'yes',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'ticket_default_assigned_user_id',
                'value' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'social_media_facebook',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'social_media_instagram',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'social_media_twitter',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'social_media_youtube',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'social_media_pinterest',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'social_media_envato',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'default_lang',
                'value' => 'en',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'theme_color',
                'value' => 'rgba(89, 160, 247, 1)',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'theme_color_dark',
                'value' => 'rgba(24, 71, 128, 1)',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'popular_categories',
                'value' => '[]',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'home_featured_categories',
                'value' => '[]',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'home_categories',
                'value' => '[]',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'home_max_articles',
                'value' => '10',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'mail_driver',
                'value' => env('MAIL_DRIVER', 'sendmail'),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'mail_host',
                'value' => env('MAIL_HOST', 'smtp.mailtrap.io'),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'mail_port',
                'value' => env('MAIL_PORT', '2525'),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'mail_from_address',
                'value' => env('MAIL_FROM_ADDRESS', 'admin@gmail.com'),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'mail_from_name',
                'value' => env('MAIL_FROM_NAME', 'smtp'),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'mail_encryption',
                'value' => env('MAIL_ENCRYPTION', 'smtp'),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'MAIL_USERNAME',
                'value' => env('MAIL_USERNAME', ''),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'MAIL_PASSWORD',
                'value' => env('MAIL_PASSWORD', ''),
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'frontend_logo',
                'value' => 'frontend_logo.png',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'frontend_dark_logo',
                'value' => 'frontend_dark_logo.png',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'frontend_favicon',
                'value' => 'frontend_favicon.png',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'frontend_home_header',
                'value' => 'frontend_home_header.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'EMAIL_USER_TICKET_CREATE_CUSTOMER',
                'value' => 'yes',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'EMAIL_USER_TICKET_CREATE_AGENT',
                'value' => 'yes',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'EMAIL_TICKET_AGENT_REPLIED',
                'value' => 'yes',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'EMAIL_TICKET_CUSTOMER_REPLIED',
                'value' => 'yes',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'auto_assign_user',
                'value' => 'yes',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'key' => 'ultimatedesk_version',
                'value' => '1.4',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
