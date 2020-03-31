<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                GenderTableSeeder::class,
                UsersTableSeeder::class,
                AgesTableSeeder::class,
                EnglevelsTableSeeder::class,
                GenresTableSeeder::class,
                BotTextSeeder::class,
            ]);

        // $this->call(UsersTableSeeder::class);
    }
}
