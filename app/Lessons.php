<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lessons extends Model
{
    protected $fillable = ['name', 'link', 'videolink', 'dialog', 'words'];
    /**
     * The genders that belong to the lesson.
     */
    public function genders()
    {
        return $this->belongsToMany('App\Genders', 'lessons_genders');
    }
    /**
     * The ages that belong to the lesson.
     */
    public function ages()
    {
        return $this->belongsToMany('App\Ages', 'lessons_ages');
    }
    /**
     * The englevels that belong to the lesson.
     */
    public function englevels()
    {
        return $this->belongsToMany('App\Englevels', 'lessons_englevels');
    }
    /**
     * The genres that belong to the lesson.
     */
    public function genres()
    {
        return $this->belongsToMany('App\Genres', 'lessons_genres');
    }

    public function telegramusers()
    {
        return $this->belongsToMany('App\Telegramusers', 'telegramusers_lessons')->withTimestamps();
    }
}
