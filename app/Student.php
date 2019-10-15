<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
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

    public function family()
    {
        return $this->hasOne('App\Family');
    }

    public function classGroup()
    {
        return $this->belongsTo('App\ClassGroup');
    }

    public function presences()
    {
        return $this->hasMany('App\Presence');
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

    /**
     * Business logic.
     */
    public static function actionButton($id)
    {
        return '
        <a data-toggle="tooltip" title="" data-original-title="Edit"
            class="btn btn-primary btn-action mr-1"
            href="' . route('admin.students.edit', $id) . '">
            <i class="fas fa-pencil-alt"></i>
        </a>
        <form id="delete_' . $id . '" class="d-inline"
            action="' . route('admin.students.destroy', $id) . '" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <button data-id="delete_' . $id . '" data-toggle="tooltip" title="" 
                data-original-title="Hapus" class="button_delete btn btn-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>';
    }

    public static function presenceInput($id, $value, $checked)
    {
        return '<div class="custom-switches-stacked">
                    <label>
                        <input type="radio" name="presence_' . $id . '" value="' . $value . '"
                            class="custom-switch-input" ' . $checked . '>
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>';
    }
}
