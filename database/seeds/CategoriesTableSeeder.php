<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('categories')->insert([
        	['value' => 'Negocios', 'slug' => 'negocios'],
        	['value' => 'Novedades', 'slug' => 'novedades'],
        	['value' => 'Internacional', 'slug' => 'internacional'],
        ]);
    }
}
