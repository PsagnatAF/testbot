<?php

namespace App;

use CURLFile;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;


class TelegramBot extends Model
{
    const API_URL = 'https://api.telegram.org/bot';    

    public static function post(String $url, Array $params)
    {
        $api_url = self::API_URL . Config::get('telegram.bot_token') .'/'. $url . '?';
        $ch = curl_init($api_url . http_build_query($params));
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
        ));
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function send(String $method, Array $params)
    {
        $api_url = self::API_URL . Config::get('telegram.bot_token') .'/send'. ucfirst($method);
        $post_fields = array(
            'chat_id' => $params['chat_id'],
        );
        $post_fields[$method] = new CURLFile($params[$method]);
        $ch = curl_init($api_url);
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "Content-Type:multipart/form-data"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $post_fields,
        ));
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


    /**
     * @param array
     * @param.callback_query_id - String - required
     * @param.text - String
     * @param.show_alert - Boolean
     * @param.url - String
     * @param.cache_time - Integer
     */
    public static function answerCallbackQuery(array $params = [])
    {
        $url = 'answerCallbackQuery';
        $required = ['callback_query_id' => 'string'];
        if(!self::validate($required, $params)) return 'Error';
        return self::post($url, $params);
    }
    /**
     * @param array
     * @param.chat_id - Integer - required
     * @param.text - String
     * @param.reply_markup - Json-serialized object
     */
    public static function sendMessage(array $params = [])
    {
        $url = 'sendMessage';
        $required = ['chat_id'=>'integer'];
        if(!self::validate($required, $params)) return 'Error';
        return self::post($url, $params);
    }
    /**
     * @param array
     * @param.chat_id - Integer - required
     * @param.message_id - Integer - required
     * @param.text - String
     * @param.reply_markup - Json-serialized object
     */
    public static function editMessageText(array $params = [])
    {
        $url = 'editMessageText';
        $required = ['chat_id'=>'integer', 'message_id'=>'integer'];
        if(!self::validate($required, $params)) return 'Error';
        return self::post($url, $params);
    }
    /**
     * @param array
     * @param.chat_id - Integer - required
     * @param.message_id - Integer - required
     */
    public static function deleteMessage(array $params = [])
    {
        $url = 'deleteMessage';
        $required = ['chat_id'=>'integer', 'message_id'=>'integer'];
        if(!self::validate($required, $params)) return 'Error';
        return self::post($url, $params);
    }
    /**
     * @param array
     * @param.chat_id - Integer - required
     * @param.message_id - Integer - required
     * @param.inline_message_id - String
     * @param.reply_markup - String
     */
    public static function editMessageReplyMarkup(array $params = [])
    {
        $url = 'editMessageReplyMarkup';
        // $required = ['chat_id'=>'integer', 'message_id'=>'integer'];
        // if(!self::validate($required, $params)) return 'Error';
        return self::post($url, $params);
    }
     /**
     * @param array
     * @param.chat_id - Integer - required
     * @param.video - Integer - required
     */
    public static function sendVideo(array $params = [])
    {
        $url = 'sendVideo';
        $required = ['chat_id'=>'integer'];
        if(!self::validate($required, $params)) return 'Error';
        return self::post($url, $params);
    }
    public static function validate($required, $params)
    {
        $bool = true;
        foreach($required as $key => $req)
        {
            if(in_array($key, array_keys($params)) && gettype($params[$key]) === $req) continue;
            $bool = false;
            break;
        }
        return $bool;
    }
}
