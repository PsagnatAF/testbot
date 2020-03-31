<?php

use Illuminate\Database\Seeder;

class BotTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $texts = [
            'greet'     =>  'Привет! Рады видеть тебя. Это канал об изучении английского.',
            'genders'   =>  'Выбери пол.',
            'ages'      =>  'Укажи возраст.',
            'englevels' =>  'Уровень английского.',
            'genres'    =>  'Любимые жанры сериалов. Минимум три',
            'start'     =>  'Отлично! Теперь давай попробуем разобрать первое видео.',
            'newvideo'  =>  'Доступно новое видео!',
            'cheers_m'  =>  'Ты отлично позанимался сегодня! Следующее видео придет завтра. Не забывай пересматривать видео и повторять слова.',
            'cheers_f'  =>  'Ты отлично позанималась сегодня! Следующее видео придет завтра. Не забывай пересматривать видео и повторять слова.',
        ];
        foreach($texts as $key => $text)
        {
            DB::table('bot_texts')->insert([
                'role' => $key,
                'content'   =>  $text,
            ]);
        }
    }
}
