<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    const CATEGORIES = array(
        'genders'   =>  \App\Genders::class,
        'ages'      =>  \App\Ages::class,
        'englevels' =>  \App\Englevels::class,
        'genres'    =>  \App\Genres::class,
    );

    const TRANSLATES = array(
        'genders'   =>  'Пол',
        'ages'      =>  'Возраст',
        'englevels' =>  'Уровень английского',
        'genres'    =>  'Жанры фильмов',
    );


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = [];
        foreach(self::CATEGORIES as $key => $class)
        {
            $categories[$key] = $class::all();
        }
        $translates = self::TRANSLATES;
        return view('categories.index', compact('categories', 'translates'));
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
        $categories = array_keys(self::CATEGORIES);
        foreach($data as $name => $category)
        {
            if(in_array($name, $categories))
            {
                $classname = self::CATEGORIES[$name];
                $classData = $classname::all()->toArray();
                $dbdata = array_combine(array_column($classData, 'id'), array_column($classData, 'name'));
                $diff = array_diff(array_keys($dbdata),array_keys($category));
                if(!empty($diff))
                {
                    foreach($diff as $id)
                    {
                        $item = $classname::find($id);
                        $item->delete();
                    }
                }
                foreach($category as $index => $cat)
                {
                    if(is_null($cat))
                    {
                        $newcat = $classname::find($index);
                        if(!is_null($newcat))
                        {
                            $newcat->delete();
                        }
                        break;
                    }
                    if(isset($dbdata[$index]) && $dbdata[$index] != $cat)
                    {
                        $newcat = $classname::find($index);
                        $newcat->update(['name'=>$cat]);
                    } elseif(!isset($dbdata[$index])) {
                        $newcat = $classname::create(['name' => $cat]);
                    } 
                }
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
