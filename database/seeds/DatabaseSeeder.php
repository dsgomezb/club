<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);

        //Plan
        \DB::table('plans')->insert(['price' => 450]);

        //factories para test
        if (in_array(env('APP_ENV'), ['local', 'test'])) {
            \App\User::create([
                'username' => 'Usuario',
                'email' => 'user@mail.com',
                'password' => \Hash::make(env('ADMIN_PASSWORD')),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'is_approved' => 1
            ]);

            factory(\App\User::class, 40)->create()->each(function ($user) {
                $user->posts()->saveMany(factory(\App\Post::class, rand(1,3))->create()->each(function($post){
                    factory(\App\Calification::class,rand(1,9))->create([
                        'post_id'=>$post->id,
                    ]);
                }));

                $user->updateRanking();
                $user->payments()->save(factory(\App\Payment::class)->make());
            });

        }
    }
}
