<?php

namespace App\Http\Controllers\Api;

use App\Lessons;
use App\Algorithms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonsController extends Controller
{
    public function deletevideo(Request $request)
    {
        if(!is_null($request->input('lesson_id')) && !empty($request->input('lesson_id')) && $lesson = Lessons::find($request->input('lesson_id')))
        {
            if($lesson->update(['link'=>'', 'videolink' => null]))
            {
                return response()->json(['result'=>'success']);
            };
        }
        
    }
    public function delaymethod(Request $request)
    {
        $method = $request->input('method');
        $chat_id = $request->input('chat_id');
        $message_id = $request->input('message_id');
        $lesson_id = $request->input('lesson_id');
        $validate_arr = array($message_id, $lesson_id, $chat_id);
        if(in_array($method, get_class_methods('App\Algorithms')) && count($validate_arr) === count(array_filter($validate_arr)))
        {
            sleep(30);
            $res = Algorithms::$method($chat_id, $lesson_id, $message_id);
            return response()->json($res);
        }
        return response()->json(['status'=>'error']);
    }          

}
