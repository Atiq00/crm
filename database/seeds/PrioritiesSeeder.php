<?php

use Illuminate\Database\Seeder;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            [
                'name' => 'low',
                'color' => 'rgba(91, 92, 94, 1)',
                'color_text' => 'rgba(255, 255, 255, 1)',
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'name' => 'medium',
                'color' => 'rgba(33, 127, 243, 1)',
                'color_text' => 'rgba(255, 255, 255, 1)',
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'name' => 'high',
                'color' => 'rgba(245, 54, 92, 1)',
                'color_text' => 'rgba(255, 255, 255, 1)',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
