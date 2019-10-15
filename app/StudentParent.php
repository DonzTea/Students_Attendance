<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'age',
        'religion_id',
        'education_id',
        'profession',
        'address',
        'class_group_id',
    ];

    /**
     * Relationship.
     */
    public function religion()
    {
        return $this->belongsTo('App\Religion');
    }

    public function education()
    {
        return $this->belongsTo('App\Education');
    }

    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public function historyStudents()
    {
        return $this->hasMany('App\HistoryStudent');
    }

    public function family()
    {
        return $this->hasOne('App\Family');
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

    public function getProfessionAttribute($value)
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

    public function setProfessionAttribute($value)
    {
        $value == null ? null : $this->attributes['profession'] = ucwords($value);
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
            href="' . route('admin.parents.edit', $id) . '">
            <i class="fas fa-pencil-alt"></i>
        </a>
        <form id="delete_' . $id . '" class="d-inline"
            action="' . route('admin.parents.destroy', $id) . '" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <button data-id="delete_' . $id . '" data-toggle="tooltip" title="" 
                data-original-title="Hapus" class="button_delete btn btn-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>';
    }
}
