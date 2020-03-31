<?php

namespace App\Http\Controllers;

use App\Ages;
use App\Genres;
use App\Genders;
use App\Lessons;
use App\Englevels;
use App\Algorithms;
use Illuminate\Http\Request;
use App\Http\Requests\LessonRequest;
use Illuminate\Support\Facades\Storage;

class LessonsController extends Controller
{
    const RESEND_CHAT_ID = 607410143;

    protected $relations = array(
        'genders',
        'ages',
        'englevels',
        'genres',
    );

    const FIELD_NAMES = array(
        'name'      =>  'Название',
        'genders'   =>  'Пол',
        'ages'      =>  'Возраст',
        'englevels' =>  'Уровень',
        'genres'    =>  'Жанры',
        'dialog'    =>  'Диалог',
        'words'     =>  'Слова',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lessons::all();
        return view('lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genders = Genders::all();
        $ages = Ages::all();
        $englevels = Englevels::all();
        $genres = Genres::all();
        $field_names = self::FIELD_NAMES;
        return view('lessons.create', compact('genders', 'ages', 'englevels', 'genres', 'field_names'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        $validated = $request->validated();
        $data = $request->all();
        if(!is_null($request->file('video')) && !($request->file('video')->getError()) )
        {
            $videofile = $request->file('video');
            $path = Storage::putFile('public/video', $videofile);
            $data['link'] = $videofile->hashName();
            $realpath = storage_path('app/' . $path);
            $videolink = Algorithms::getVideoId(self::RESEND_CHAT_ID, $realpath);
            $data['videolink'] = $videolink;
        } else {
            $data['link'] = '';
        }
        if(is_null($data['dialog'])) $data['dialog'] = '';
        if(is_null($data['words'])) $data['words'] = '';
        $lesson = new Lessons($data);
        $lesson->save();
        foreach($this->relations as $relation)
        {
            if(isset($data[$relation])){
                $atachable = [];
                foreach($data[$relation] as $val)
                {
                    $atachable[] = [$relation . '_id'=>$val];
                }
                $lesson->$relation()->attach($atachable);
            }
        }
        return redirect('lessons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lessons  $lessons
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lessons::find($id);
        $genders = Genders::all();
        $ages = Ages::all();
        $englevels = Englevels::all();
        $genres = Genres::all();
        $field_names = self::FIELD_NAMES;
        if(!is_null($lesson))
        {
            $videolink = !empty($lesson->link) ? secure_asset('storage/video/'. $lesson->link) : "#";
            return view('lessons.show', compact('lesson', 'genders', 'ages', 'englevels', 'genres', 'videolink', 'field_names'));
        } else {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lessons  $lessons
     * @return \Illuminate\Http\Response
     */
    public function edit(Lessons $lessons)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lessons  $lessons
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $request->all();
        $lesson = Lessons::find($id);
        if(!is_null($request->file('video')) && !($request->file('video')->getError()) )
        {
            $videofile = $request->file('video');
            $path = Storage::putFile('public/video', $videofile);
            $data['link'] = $videofile->hashName();
            $realpath = storage_path('app/' . $path);
            $videolink = Algorithms::getVideoId(self::RESEND_CHAT_ID, $realpath);
            $data['videolink'] = $videolink;
        }
        if(is_null($data['dialog'])) $data['dialog'] = '';
        if(is_null($data['words'])) $data['words'] = '';
        if(!is_null($lesson))
        {
            $lesson->update($data);
            foreach($this->relations as $relation)
            {
                $lesson->$relation()->detach();
                if(isset($data[$relation])){
                    $atachable = [];
                    foreach($data[$relation] as $val)
                    {
                        $atachable[] = [$relation . '_id'=>$val];
                    }
                    $lesson->$relation()->attach($atachable);
                }
            }
        }     
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lessons  $lessons
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lessons $lessons)
    {
        //
    }

}
