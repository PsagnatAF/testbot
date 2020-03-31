<?php

namespace App;

use App\BotText;
use App\Lessons;
use App\TelegramBot;
use App\Telegramusers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Algorithms extends Model
{
    public static function sendNow($chat_id)
    {
        $user = Telegramusers::whereTelegramId($chat_id)->first();
        $lesson = self::checkLessons($user);
        if($lesson)
        {
            $video_send_params = array(
                'chat_id'   =>  $chat_id,
                'video' => $lesson->videolink,
            );
            $user->lessons()->attach(['lessons_id'=>$lesson->id]);
            $res = TelegramBot::sendVideo($video_send_params);
            $edited = json_decode($res);
            self::sendDelayParams('sendDaylyDialogAt', $chat_id, $lesson->id, $edited->result->message_id);
        }
        return 'ok';
    }

    public static function getVideoId($chat_id, $realpath)
    {
        $video_send_params = array(
            'chat_id'   =>  $chat_id,
            'video'     =>  $realpath
        );
        $result = TelegramBot::send('video', $video_send_params);
        return json_decode($result)->result->video->file_id;
    }

    public static function getNewVideo($telegram_id)
    {
        $user = Telegramusers::whereTelegramId($telegram_id)->first();
        $lesson = self::checkLessons($user);
        if(!is_null($lesson))
        {
            $video_params = array(
                'chat_id'   =>  $user->telegram_id,
                'video'     =>  $lesson->videolink,
            );
            $res = TelegramBot::sendVideo($video_params);
            $user->lessons()->attach(['lessons_id'=>$lesson->id]);
        }
        return true;
    }

    public static function checkLessons($user)
    {
        $lesson = DB::table('lessons')
                        ->leftJoin('lessons_genders', 'lessons.id', '=', 'lessons_genders.lessons_id')
                        ->leftJoin('lessons_ages', 'lessons.id', '=', 'lessons_ages.lessons_id')
                        ->leftJoin('lessons_englevels', 'lessons.id', '=', 'lessons_englevels.lessons_id')
                        ->leftJoin('lessons_genres', 'lessons.id', '=', 'lessons_genres.lessons_id')
                        ->where('genders_id', $user->genders_id)
                        ->where('ages_id', $user->ages_id)
                        ->where('englevels_id', $user->englevels_id)
                        ->whereIn('genres_id', $user->genres()->pluck('id')->toArray())
                        ->whereNotIn('id', $user->lessons()->pluck('lessons_id')->toArray())
                        ->first();
        return $lesson;
    }

    public static function getUserLessons()
    {
        $telegramusers = Telegramusers::all();
        $file_name = date('d-m-Y', strtotime('now')) . '.log';
        $users = array();
        foreach($telegramusers as $user)
        {
            if(\Carbon\Carbon::parse($user->created_at)->format('Y-m-d') != date('Y-m-d'))
            {
                $lesson = self::checkLessons($user);
                if(!is_null($lesson))
                {
                    $users[$user->id] = $lesson->id;
                }
            }
        }
        if(!empty($users))
        {
            $users_json = json_encode($users);
            Storage::put('sendlog/'.$file_name, $users_json);
            return true;
        }
        return false;
    }

    public static function sendUsersLessons()
    {
        $file_name = 'sendlog/' . date('d-m-Y', strtotime('now')) . '.log';
        if(file_exists(storage_path() . "/app/" . $file_name))
        {
            $users_json = Storage::get($file_name);
            $users = json_decode($users_json);
            foreach($users as $user_id => $lesson_id)
            {
                self::daySend($user_id, $lesson_id);
            }
            return true;
        }
        return false; 
    }

    public static function daySend($user_id, $lesson_id)
    {
        $user = Telegramusers::find($user_id);
        $lesson = Lessons::find($lesson_id);
        if(!is_null($lesson) && !is_null($user))
        {
            $text = BotText::find(7);
            $keyboard = array(
                'inline_keyboard'   =>  array(
                    array(
                        array(
                            'text'  =>  'Улучшить мой английский!',
                            'callback_data' =>  'new.lesson.' . $lesson_id,
                        ),
                    ),
                ),
            );
            $send_message_params = array(
                'chat_id'       =>  $user->telegram_id,
                'text'          =>  $text->content,
                'reply_markup'  =>  json_encode($keyboard),
            );
    
            $res = TelegramBot::sendMessage($send_message_params);
            $user->lessons()->attach(['lessons_id'=>$lesson->id]);
        }
        return false;
    }

    public static function daylyVideoSend($chat_id, $lesson_id)
    {
        $lesson = Lessons::find($lesson_id);
        if(!is_null($lesson))
        {
            $video_params = array(
                'chat_id'   =>  $chat_id,
                'video'     =>  $lesson->videolink,
            );
            $res = TelegramBot::sendVideo($video_params);
            $edited = json_decode($res);
            self::sendDelayParams('sendDaylyDialogAt', $chat_id, $lesson->id, $edited->result->message_id);
            return true;
        }
        return false;
    }

    public static function daylyDialogSend($chat_id, $lesson_id)
    {
        $lesson = Lessons::find($lesson_id);
        if(!is_null($lesson))
        {
            $params = array(
                'chat_id'   =>  $chat_id,
                'text'     =>  $lesson->dialog,
            );
            $res = TelegramBot::sendMessage($params);
            $edited = json_decode($res);
            self::sendDelayParams('sendDaylyWordsAt', $chat_id, $lesson->id, $edited->result->message_id);
            return true;
        }
        return false;
    }

    public static function daylyWordsSend($chat_id, $lesson_id)
    {
        $lesson = Lessons::find($lesson_id);
        if(!is_null($lesson))
        {
            $params = array(
                'chat_id'   =>  $chat_id,
                'text'     =>  $lesson->words,
            );
            $res = TelegramBot::sendMessage($params);
            $edited = json_decode($res);
            self::sendDelayParams('sendRewardMessage', $chat_id, $lesson->id, $edited->result->message_id);
            return true;
        }
        return false;
    }

    public static function sendDaylyDialogAt($chat_id, $lesson_id, $message_id)
    {
        $lesson = Lessons::find($lesson_id);
        if(!is_null($lesson))
        {
            $keyboard = array(
                'inline_keyboard'   =>  array(
                    array(
                        array(
                            'text'  =>  'Диалог на английском',
                            'callback_data' =>  'new.dialog.' . $lesson_id,
                        ),
                    ),
                ),
            );
            $send_message_params = array(
                'chat_id'       =>  $chat_id,
                'message_id'    =>  $message_id,
                'reply_markup'  =>  json_encode($keyboard),
            );
            $res = TelegramBot::editMessageReplyMarkup($send_message_params);
            return $res;
        }
        return false;
    }

    public static function sendDaylyWordsAt($chat_id, $lesson_id, $message_id)
    {
        $lesson = Lessons::find($lesson_id);
        if(!is_null($lesson))
        {
            $keyboard = array(
                'inline_keyboard'   =>  array(
                    array(
                        array(
                            'text'  =>  'Интересные слова',
                            'callback_data' =>  'new.words.' . $lesson_id,
                        ),
                    ),
                ),
            );
            $send_message_params = array(
                'chat_id'       =>  $chat_id,
                'message_id'    =>  $message_id,
                'reply_markup'  =>  json_encode($keyboard),
            );
            $res = TelegramBot::editMessageReplyMarkup($send_message_params);
            return $res;
        }
        return false;
    }
    public static function sendRewardMessage($chat_id, $lesson_id, $message_id)
    {
        $user = Telegramusers::whereTelegramId($chat_id)->first();
        $num_text = $user->genders_id == 1 ? 8 : 9;
        $text = BotText::find($num_text);
        $send_message_params = array(
            'chat_id'   =>  (int)$chat_id,
            'text'      =>  $text->content,
        );
        $res = TelegramBot::sendMessage($send_message_params);
        return $res;
    }

    public static function sendDelayParams($method, $chat_id,$lesson_id,$message_id)
    {
        $url = App::make('url')->to('/');
        $params = [
            'method'        =>  $method,
            'chat_id'       =>  $chat_id,
            'message_id'    =>  $message_id,
            'lesson_id'     =>  $lesson_id,
        ];
        $ch = curl_init($url . '/api/lessons/delaymethod');
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $params,
        ));
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public static function test()
    {
        $user = Telegramusers::whereTelegramId('607410143')->first();
        //         $user = Telegramusers::whereTelegramId($chat_id)->first();
        $num_text = $user->genders_id;
        echo($num_text);die();
    }
}
