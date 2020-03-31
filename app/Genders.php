<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genders extends Model
{
    public $table = "genders";
    public $timestamps = false;
    protected $fillable = ['name',];
    /**
     * The lessons that belong to the gender.
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
