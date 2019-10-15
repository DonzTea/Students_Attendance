<?php

namespace App\Rules;

use App\Teacher;
use Illuminate\Contracts\Validation\Rule;

class SingleHomeroomTeacher implements Rule
{
    protected $teacher_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($teacher_id = null)
    {
        $this->teacher_id = $teacher_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Teacher::where('homeroom_teacher_of', $value)->first() == null ||
            Teacher::where('homeroom_teacher_of', $value)->first()->id == $this->teacher_id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kelas :input sudah memiliki Wali Kelas. Hapus status wali kelas sebelumnya untuk menjadi wali kelas ini.';
    }
}
