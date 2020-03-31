<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ages extends Model
{
    public $timestamps = false;
    protected $fillable = ['name',];
    /**
     * The lessons that belong to the ages.
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
