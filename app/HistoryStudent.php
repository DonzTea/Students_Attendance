<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryStudent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nis',
        'nisn',
        'name',
        'gender',
        'region_id',
        'birthday',
        'address',
        'student_parent_id',
        'religion_id',
        'height',
        'weight',
        'class_group_id',
        'school_year_id',
    ];

    /**
     * Relationship.
     */
    public function religion()
    {
        return $this->belongsTo('App\Religion');
    }

    public function studentParent()
    {
        return $this->belongsTo('App\StudentParent');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function classGroup()
    {
        return $this->belongsTo('App\ClassGroup');
    }

    public function schoolYear()
    {
        return $this->belongsTo('App\SchoolYear');
    }

    public function historyPresences()
    {
        return $this->hasMany('App\HistoryPresence');
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

    public function getAddressAttribute($value)
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

    public function setAddressAttribute($value)
    {
        $value == null ? null : $this->attributes['address'] = ucwords($value);
    }
}
