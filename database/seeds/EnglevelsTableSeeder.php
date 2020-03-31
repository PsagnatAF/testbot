<?php

use Illuminate\Database\Seeder;

class EnglevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = ['Начальный', 'Средний', 'Выше среднего', 'Профессионал'];
        foreach($levels as $level)
        {
            DB::table('englevels')->insert([
                'name' => $level,
            ]);
        }
    }
}
