<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Relationship
     */
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher');
    }

    public function historyTeachers()
    {
        return $this->belongsToMany('App\HistoryTeacher');
    }

    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public function historyStudents()
    {
        return $this->hasMany('App\HistoryStudent');
    }

    public function presences()
    {
        return $this->hasMany('App\Presence');
    }

    public function schoolYears()
    {
        return $this->belongsToMany('App\SchoolYear');
    }
}
