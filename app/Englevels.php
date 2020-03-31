<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Englevels extends Model
{
    public $timestamps = false;
    protected $fillable = ['name',];
    /**
     * The lessons that belong to the englevels.
     */
    public function lessons()
    {
        return $this->belongsToMany('App\Lessons');
    }
    public function telegramusers()
    {
        return $this->belongsToMany('App\Telegramusers');
    }
}
