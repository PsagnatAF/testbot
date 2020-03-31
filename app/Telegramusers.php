<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telegramusers extends Model
{
    protected $fillable = ['telegram_id', 'name', 'genders_id', 'ages_id', 'englevels_id'];
    public $table = "telegramusers";

    public function genres()
    {
        return $this->belongsToMany('App\Genres', 'telegramusers_genres');
    }
    public function genders()
    {
        return $this->hasMany('App\Genders', 'id', 'genders_id');
    }
    public function ages()
    {
        return $this->hasMany('App\Ages', 'id', 'ages_id');
    }
    public function englevels()
    {
        return $this->hasMany('App\Englevels', 'id', 'englevels_id');
    }
    public function lessons()
    {
        return $this->belongsToMany('App\Lessons', 'telegramusers_lessons')->withTimestamps();
    }
}
