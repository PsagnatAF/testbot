<?php

namespace App\Http\Controllers;

use App\BotText;
use Illuminate\Http\Request;

class BotTextController extends Controller
{

    public $translates = array(
        'greet'     =>  '',
        'genders'   =>  '',
        'ages'      =>  '',
        'englevels' =>  '',
        'genres'    =>  '',
        'start'     =>  '',
        'newvideo'  =>  '',
        'cheers_m'  =>  '',
        'cheers_f'  =>  '',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $texts = BotText::all();
        return view('texts.index', compact('texts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        foreach($data as $role => $content)
        {
            $botText = BotText::whereRole($role)->first();
            if(!is_null($botText) && $botText->content != $content)
            {
                $botText->update(['content'=>$content]);
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BotText  $botText
     * @return \Illuminate\Http\Response
     */
    public function show(BotText $botText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BotText  $botText
     * @return \Illuminate\Http\Response
     */
    public function edit(BotText $botText)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BotText  $botText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BotText $botText)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BotText  $botText
     * @return \Illuminate\Http\Response
     */
    public function destroy(BotText $botText)
    {
        //
    }
}
