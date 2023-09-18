<?php

use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'General',
            'assigned_user_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
