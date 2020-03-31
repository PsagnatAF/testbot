<?php

namespace App\Http\Controllers;

use App\Telegramusers;
use Illuminate\Http\Request;

class TelegramusersController extends Controller
{
    protected $categories = array(
        'genders'   =>  'Пол',
        'ages'      =>  'Возраст',
        'englevels' =>  'Уровень',
        'genres'    =>  'Жанры',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $telegramusers = Telegramusers::all();
        return view('telegramusers.index', compact('telegramusers'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Telegramusers  $telegramusers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $telegramuser = Telegramusers::find($id);
        if($telegramuser)
        {
            $categories = $this->categories;
            return view('telegramusers.show', compact('telegramuser', 'categories'));
        } else {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Telegramusers  $telegramusers
     * @return \Illuminate\Http\Response
     */
    public function edit(Telegramusers $telegramusers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Telegramusers  $telegramusers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Telegramusers $telegramusers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Telegramusers  $telegramusers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Telegramusers $telegramusers)
    {
        //
    }
}
