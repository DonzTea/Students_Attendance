<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
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

    /**
     * Business logic.
     */
    public static function actionButton($id)
    {
        return '
        <a data-toggle="tooltip" title="" data-original-title="Edit"
            class="btn btn-primary btn-action mr-1"
            href="' . route('admin.teachers.edit', $id) . '">
            <i class="fas fa-pencil-alt"></i>
        </a>
        <form id="delete_' . $id . '" class="d-inline"
            action="' . route('admin.teachers.destroy', $id) . '" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <button data-id="delete_' . $id . '" data-toggle="tooltip" title="" 
                data-original-title="Hapus" class="button_delete btn btn-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>';
    }
}
