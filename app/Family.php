<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'live_with',
        'economic_condition',
        'learning_condition',
        'n_child',
        'siblings_count',
        'step_brothers_count',
        'adopted_brothers_count',
        'sibs_total',
        'used_language',
        'student_id',
        'student_parent_id',
    ];

    /**
     * Relationship.
     */
    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function studentParent()
    {
        return $this->belongsTo('App\StudentParent');
    }
}
