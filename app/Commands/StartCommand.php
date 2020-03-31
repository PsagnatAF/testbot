<?php

namespace App\Commands;

use App\BotText;
use App\Telegramusers;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $chat_id = $this->update->getMessage()->getChat()->getId();
        $user = Telegramusers::whereTelegramId($chat_id)->first();
        // if(!is_null($user))
        // {
        //     $this->replyWithMessage([
        //         'text' => 'Вы уже зарегистрированы. Ожидайте новых уроков.',
        //     ]);
        // } else {
            $text = BotText::whereRole('greet')->first();
            $inline_keyboard[] = [
                [
                    'text' => 'Понятно!',
                    'callback_data' => 'greet.start',
                ]
            ];
            $reply_markup = Telegram::replyKeyboardMarkup([
                'inline_keyboard' => $inline_keyboard,
                'resize_keyboard' => true
            ]);
            $this->replyWithMessage([
                'text' => $text->content,
                'reply_markup' => $reply_markup,
            ]);
        // }
        

    }
}