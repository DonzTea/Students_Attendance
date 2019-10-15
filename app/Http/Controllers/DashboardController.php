<?php

namespace App\Http\Controllers;

use App\ClassGroup;
use App\HistoryPresence;
use App\HistoryStudent;
use App\HistoryTeacher;
use App\SchoolYear;
use App\Student;
use App\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $school_year = SchoolYear::where('name', (date('Y') - 1))->first();
        $has_last_year = $school_year != null;
        $has_last_year_history = false;
        if ($has_last_year) {
            if (
                HistoryStudent::where(
                    'school_year_id',
                    $school_year->id
                )->first() != null ||
                HistoryTeacher::where(
                    'school_year_id',
                    $school_year->id
                )->first() != null ||
                HistoryPresence::where(
                    'school_year_id',
                    $school_year->id
                )->first() != null
            ) {
                $has_last_year_history = true;
            }
        }

        $teachers = Teacher::all();
        $students = Student::all();
        $month = $this->getMonth(date('m'));
        $classes = ClassGroup::all();
        return view('admin.dashboard.index', [
            'has_last_year' => $has_last_year,
            'has_last_year_history' => $has_last_year_history,
            'teachers' => $teachers,
            'students' => $students,
            'month' => $month,
            'classes' => $classes,
        ]);
    }

    private function getMonth($month_index)
    {
        switch ($month_index) {
            case '01':
                return 'Januari';
                break;
            case '02':
                return 'Februari';
                break;
            case '03':
                return 'Maret';
                break;
            case '04':
                return 'April';
                break;
            case '05':
                return 'Mei';
                break;
            case '06':
                return 'Juni';
                break;
            case '07':
                return 'Juli';
                break;
            case '08':
                return 'Agustus';
                break;
            case '09':
                return 'September';
                break;
            case '10':
                return 'Oktober';
                break;
            case '11':
                return 'November';
                break;
            default:
                return 'Desember';
                break;
        }
    }

    public function addNewSchoolYear()
    {
        if (Student::all()->count() > 0) {
            foreach (Student::all() as $student) {
                // Record students history
                $history_student = HistoryStudent::create([
                    'nis' => $student->nis ?: null,
                    'nisn' => $student->nisn ?: null,
                    'name' => $student->name ?: null,
                    'gender' => $student->gender ?: null,
                    'region_id' => $student->region_id ?: null,
                    'birthday' => $student->birthday ?: null,
                    'address' => $student->address ?: null,
                    'student_parent_id' => $student->student_parent_id ?: null,
                    'religion_id' => $student->religion_id ?: null,
                    'height' => $student->height ?: null,
                    'weight' => $student->weight ?: null,
                    'class_group_id' => $student->class_group_id ?: null,
                    'school_year_id' => (SchoolYear::where('name', (date('Y') - 1))->first()->id),
                ]);

                if ($student->presences()->get()->count() > 0) {
                    foreach ($student->presences()->get() as $presence) {
                        // Record students presence
                        HistoryPresence::create([
                            'history_student_id' => $history_student->id,
                            'date' => $presence->date ?: null,
                            'info' => $presence->info ?: null,
                            'class_group_id' => $history_student->class_group_id,
                            'school_year_id' => $history_student->school_year_id,
                        ]);

                        // Delete presence
                        $presence->delete();
                    }
                }

                // Update students data
                if ($student->class_group_id < 6) {
                    $student->update([
                        'class_group_id' => $student->class_group_id ? ($student->class_group_id + 1) : null,
                    ]);
                } else if ($student->class_group_id >= 6) {
                    $student->delete();
                }
            }
        }

        if (Teacher::all()->count() > 0) {
            // Record teachers history
            foreach (Teacher::all() as $teacher) {
                $history_teacher = HistoryTeacher::create([
                    'name' => $teacher->name ?: null,
                    'gender' => $teacher->gender ?: null,
                    'nip' => $teacher->nip ?: null,
                    'karpeg' => $teacher->karpeg ?: null,
                    'birthday' => $teacher->birthday ?: null,
                    'position_id' => $teacher->position_id ?: null,
                    'type' => $teacher->type ?: null,
                    'homeroom_teacher_of' => $teacher->homeroom_teacher_of ?: null,
                    'school_year_id' => SchoolYear::where('name', (date('Y') - 1))->first()->id,
                ]);

                if ($teacher->classGroups()->count() > 0) {
                    foreach ($teacher->classGroups as $class) {
                        $class = ClassGroup::find($class->id);
                        $history_teacher->classGroups()->attach($class);
                    }
                }
            }
        }

        // Add new school year
        $newSchoolYear = SchoolYear::create([
            'name' => date('Y'),
        ]);

        // Records class data by year
        foreach (ClassGroup::all() as $class) {
            $class->schoolYears()->attach($newSchoolYear->id);
        }

        return redirect()->back()->with(
            'success',
            'Berhasil memasuki tahun pelajaran baru, data yang terlibat telah berubah.'
        );
    }
}
