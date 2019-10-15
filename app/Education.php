<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
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
