<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gender = ['мужской', 'женский'];
        foreach($gender as $g)
        {
            DB::table('genders')->insert([
                'name' => $g,
            ]);
        }
    }
}
