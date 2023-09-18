<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'image' => '1.jpg',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('users')->insert([
            'name' => 'Agent',
            'email' => 'agent@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('agent123'),
            'image' => '1.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
