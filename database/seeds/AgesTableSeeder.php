<?php

use Illuminate\Database\Seeder;

class AgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ages = ['до 20 лет', '20-30 лет', '30-40 лет', '40-50 лет', 'старше 50 лет'];
        foreach($ages as $age)
        {
            DB::table('ages')->insert([
                'name' => $age,
            ]);
        }
    }
}
