<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('admins')->insert([
        	'name' => 'Admin',
        	'email' => env('ADMIN_EMAIL'),
        	'password' => \Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }
}
