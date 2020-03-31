<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    public $timestamps = false;
    protected $fillable = ['name',];

    /**
     * The lessons that belong to the genres.
     */
    public function lessons()
    {
        return $this->belongsToMany('App\Lessons');
    }
    /**
     * The telegram_users that belong to the genres.
     */
    public function telegramusers()
    {
        return $this->belongsToMany('App\Telegramusers');
    }
}
