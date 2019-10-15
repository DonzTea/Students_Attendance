<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'date',
        'info',
        'class_group_id',
        'school_year_id',
    ];

    /**
     * Relationship.
     */
    public function schoolYear()
    {
        return $this->belongsTo('App\SchoolYear');
    }

    public function classGroup()
    {
        return $this->belongsTo('App\ClassGroup');
    }

    public function student()
    {
        return $this->belongsTo('App\Student');
    }
}
