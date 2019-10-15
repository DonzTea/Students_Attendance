<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Relationship.
     */
    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public function historyStudents()
    {
        return $this->hasMany('App\HistoryStudent');
    }
}
