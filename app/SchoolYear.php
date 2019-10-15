<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Relationship.
     */
    public function presence()
    {
        return $this->hasOne('App\Presence');
    }

    public function historyPresence()
    {
        return $this->hasOne('App\HistoryPresence');
    }

    public function classGroups()
    {
        return $this->belongsToMany('App\ClassGroup');
    }

    public function historyStudents()
    {
        return $this->hasMany('App\HistoryStudent');
    }

    public function historyTeachers()
    {
        return $this->hasMany('App\HistoryTeacher');
    }
}
