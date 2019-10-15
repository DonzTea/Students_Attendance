<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
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
    public function teachers()
    {
        return $this->hasMany('App\Teacher');
    }

    public function historyTeachers()
    {
        return $this->hasMany('App\HistoryTeacher');
    }
}
