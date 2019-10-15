<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassGroupHistoryTeacher extends Model
{
    protected $table = 'class_group_history_teacher';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_group_id', 'history_teacher_id',
    ];
}
