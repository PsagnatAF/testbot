<?php

namespace App;

use App\BotText;
use App\Algorithms;
use App\Telegramusers;
use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Laravel\Facades\Telegram;

class Scenaries extends Model
{
    protected $scenaries = array(
        'genders'   =>  \App\Genders::class,
        'ages'      =>  \App\Ages::class,
        'englevels' =>  \App\Englevels::class,
        'genres'    =>  \App\Genres::class,
    );
    protected $query_scenaries = array(
        'genders',
        'ages',
        'englevels',
        'genres',
    );
    protected $scenario_data = array();
    protected $callback_query = array();
    protected $command = array();
    protected $user;

    public function __construct($callback_query)
    {
        $this->callback_query = $callback_query;
        $this->init();
        $this->main();
    }
    
    public function init()
    {
        foreach ($this->scenaries as $name => $class)
        {
            $alldata = $class::all()->toArray();
            $keyboard = [];
            $text = BotText::whereRole($name)->first();
            if(count($alldata) > 5)
            {
                $keyboard = $this->multilineKeyboard($alldata, $name);
            } else {
                foreach ($alldata as $data)
                {
                    $keyboard[0][] = array(
                        'text'          =>  $data['name'],
                        'callback_data' =>  $name . "." . $data['id'],
                    );
                }
            }
            $this->scenario_data[$name] = array(
                'keyboard'  =>  $keyboard,
                'text'      =>  $text->content,
            );
        }
    }

    public function main()
    {
        $this->initUser()->scenaries($this->callback_query['data'])->answerCallbackQuery();
    }

    public function answerCallbackQuery()
    {
        $call_back_query_answer = array(
            'callback_query_id' => $this->callback_query['id'],
        );
        TelegramBot::answerCallbackQuery($call_back_query_answer);
        return $this;
    }

    public function scenaries($data_choise)
    {
        $this->command = explode(".",$data_choise);
        if($data_choise == 'greet.start')
        {
            $index = -1;
        } elseif ($data_choise == 'next.genres') {
            $this->lastEditMessage();
            return $this;
        } elseif ($data_choise == 'exit.exit') {
            $this->deleteMessage();
            $videosend = Algorithms::sendNow($this->callback_query['message']['chat']['id']);
            return $this;
        } elseif($this->command[0] == 'new') {
            if($this->command[1] == 'lesson' && isset($this->command[2]))
            {
                $this->deleteMessage();
                $videosend = Algorithms::daylyVideoSend($this->callback_query['message']['chat']['id'], $this->command[2]);
            } else if ($this->command[1] == 'dialog' && isset($this->command[2])) {
                $keyboard = [[]];
                $this->editMessageReplyMarkup($keyboard);
                $dialogsend = Algorithms::daylyDialogSend($this->callback_query['message']['chat']['id'], $this->command[2]);
            } else if ($this->command[1] == 'words' && isset($this->command[2])) {
                $keyboard = [];
                $this->editMessageReplyMarkup($keyboard);
                $wordssend = Algorithms::daylyWordsSend($this->callback_query['message']['chat']['id'], $this->command[2]);
            }
            return $this;
        } else {
            $this->saveUserData();
            if(in_array($this->command[0], ['genres']))
            {
                $this->multiselectKeyboardChoice($data_choise);
                return $this;
            } else {
                $index = array_search($this->command[0], $this->query_scenaries);
            }
        }
        if(array_key_exists($index + 1, $this->query_scenaries))
        {
            $this->editMessageText($index + 1);
        }
        return $this;
    }
    public function editMessageReplyMarkup($keyboard)
    {
        $reply_markup = ['inline_keyboard' => $keyboard];
        $edit_message_params = array(
            'chat_id'       =>  $this->callback_query['message']['chat']['id'],
            'message_id'    =>  $this->callback_query['message']['message_id'],
            'reply_markup'  =>  json_encode($reply_markup),
        );
        return TelegramBot::editMessageReplyMarkup($edit_message_params);
    }
    public function editMessageText($index)
    {
        $scenario_name = $this->query_scenaries[$index];
        $text = $this->scenario_data[$scenario_name]['text'];
        $reply_markup = ['inline_keyboard' => $this->scenario_data[$scenario_name]['keyboard']];
        $edit_message_params = array(
            'chat_id'       =>  $this->callback_query['message']['chat']['id'],
            'message_id'    =>  $this->callback_query['message']['message_id'],
            'text'          =>  $text,
            'reply_markup'  =>  json_encode($reply_markup),
        );
        return TelegramBot::editMessageText($edit_message_params);
    }
    public function lastEditMessage()
    {
        $text = BotText::find(6)->content;
        $start_mess = $this->user->genders_id == 1 ? 'Я готов!' : 'Я готова!';
        $reply_markup = [
            'inline_keyboard'   =>  [
                [
                    [
                        'text'  =>  $start_mess,
                        'callback_data' => 'exit.exit',
                    ]
                ]
            ]
        ];
        $edit_message_params = array(
            'chat_id'       =>  $this->callback_query['message']['chat']['id'],
            'message_id'    =>  $this->callback_query['message']['message_id'],
            'text'          =>  $text,
            'reply_markup'  =>  json_encode($reply_markup),
        );
        return TelegramBot::editMessageText($edit_message_params);
    }
    public function deleteMessage()
    {
        $delete_message_params = array(
            'chat_id'       =>  $this->callback_query['message']['chat']['id'],
            'message_id'    =>  $this->callback_query['message']['message_id'],
        );
        return TelegramBot::deleteMessage($delete_message_params);
    }
    public function startMessage()
    {
        $start_text = BotText::find(6)->content;
        $start_mess = $this->user->genders()->first()->id == 1 ? 'Я готов!' : 'Я готова!';
        $reply_markup = [
            'inline_keyboard'   =>  [
                [
                    [
                        'text'  =>  $start_mess,
                        'callback_data' => 'exit.exit',
                    ]
                ]
            ]
        ];
        $start_message_params = array(
            'chat_id'       =>  $this->callback_query['message']['chat']['id'],
            'message_id'    =>  $this->callback_query['message']['message_id'],
            'text'          =>  $start_text,
            'reply_markup'  =>  json_encode($reply_markup)
        );
        TelegramBot::sendMessage($start_message_params);
        return true;
    }
    public function saveUserData()
    {
        if(!empty($this->command))
        {            
            $user = $this->user;
            if($this->command[0] == 'genres')
            {
                $attachable[] = [$this->command[0]."_id"=>$this->command[1]];
                $user->genres()->attach($attachable);
            } else {
                $user->update([$this->command[0] . "_id" =>$this->command[1]]);
            }

        }
        return true;
    }
    public function initUser()
    {
        $callback_user = $this->callback_query['from'];
        $user = Telegramusers::whereTelegramId($callback_user['id'])->first();
        if(is_null($user))
        {
            $user = new Telegramusers;
            $user->telegram_id = $callback_user['id'];
            $user->name = $callback_user['first_name'];
            $user->save();
        }
        $this->user = $user;
        return $this;
    }
    public function multilineKeyboard(Array $alldata, String $name, $editable = false)
    {
        $keyboard = [];
        $count_rows = (int)(count($alldata) / 3);
        $rows = count($alldata) % 3 ? $count_rows + 1: $count_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $buttons = array_slice($alldata, 0, 3);
            foreach($buttons as $key => $button)
            {
                $keyboard[$i][] = array(
                    'text'          =>  $editable ? $button['text'] : $button['name'],
                    'callback_data' =>  $editable ? $button['callback_data'] : $name . "." . $button['id'],
                );
                array_shift($alldata);
            }
        }
        return $keyboard;
    }
    public function multiselectKeyboardChoice($data_choise)
    {
        $com = $this->command[0];
        $count = count($this->user->$com()->get());
        $keyboard_data = $this->prepareKeyboardData($data_choise, $com);
        $keyboard = $this->multilineKeyboard($keyboard_data, $com, true);
        if((int)$count > 2)
        {
            $next = [
                [
                    'text' => 'Далее',
                    'callback_data' => 'next.'.$com,
                ]
            ];
            array_push($keyboard, $next);
        }
        return $this->editMessageReplyMarkup($keyboard);
    }

    public function prepareKeyboardData($data_choise, $com)
    {
        $reply_markup = $this->callback_query['message']['reply_markup']['inline_keyboard'];
        $keyboard_data = [];
        foreach ($reply_markup as $reply)
        {
            foreach($reply as $button)
            {
                if($button['callback_data'] != $data_choise && $button['callback_data'] != 'next.'.$com)
                {
                    $keyboard_data[] = $button;
                }
            }
        }
        return $keyboard_data;
    }
}
