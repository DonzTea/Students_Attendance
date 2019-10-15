<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryTeacher extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'nip',
        'karpeg',
        'birthday',
        'position_id',
        'type',
        'homeroom_teacher_of',
        'school_year_id',
    ];

    /**
     * Relationship.
     */
    public function classGroups()
    {
        return $this->belongsToMany('App\ClassGroup');
    }

    public function position()
    {
        return $this->belongsTo('App\Position');
    }

    public function schoolYear()
    {
        return $this->belongsTo('App\SchoolYear');
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
