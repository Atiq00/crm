<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
             UsersTableSeeder::class,
             SettingsTableSeeder::class,
             PermissionsSeeder::class,
            PrioritiesSeeder::class,
            DepartmentsSeeder::class,
            EmailTemplatesSeeder::class
        ]);

    }
}
