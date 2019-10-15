<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassGroupSchoolYear extends Model
{
    protected $table = 'class_group_school_year';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_group_id',
        'school_year_id',
    ];
}
