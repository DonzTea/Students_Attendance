<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPresence extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'history_student_id',
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

    public function historyStudent()
    {
        return $this->belongsTo('App\HistoryStudent');
    }
}
