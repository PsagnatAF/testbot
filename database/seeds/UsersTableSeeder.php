<?php

use Illuminate\Database\Seeder;

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
            'name' => 'admin93',
            'email' => 'corname1@ukr.net',
            'password' => bcrypt('Ms92_NgaLp$$'),
        ]);
    }
}
