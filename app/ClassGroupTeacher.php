<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassGroupTeacher extends Model
{
    protected $table = 'class_group_teacher';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_group_id', 'teacher_id',
    ];
}
