<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
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
    public function parents()
    {
        return $this->hasMany('App\StudentParent');
    }

    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public function historyStudents()
    {
        return $this->hasMany('App\HistoryStudent');
    }

    /**
     * Accessor.
     */
    public function getNameAttribute($value)
    {
        if ($value) {
            return ucwords($value);
        }
    }

    /**
     * Mutators.
     */
    public function setNameAttribute($value)
    {
        $value == null ? null : $this->attributes['name'] = ucwords($value);
    }
}
