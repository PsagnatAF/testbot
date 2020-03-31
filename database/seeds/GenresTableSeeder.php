<?php

use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ['боевик', 'детектив', 'драма', 'история', 'комедия', 'криминал', 'мелодрама', 'мультфильм', 'приключения', 'триллер', 'ужасы', 'фантастика', 'фэнтези'];
        foreach($genres as $genre)
        {
            DB::table('genres')->insert([
                'name' => $genre,
            ]);
        }
    }
}
