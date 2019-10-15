<?php

namespace App\Http\Controllers;

use App\ClassGroup;
use App\HistoryStudent;
use App\SchoolYear;
use Yajra\DataTables\Facades\DataTables;

class HistoryStudentController extends Controller
{
    public function schoolYears()
    {
        $school_years = SchoolYear::where('name', '<', date('Y'))->get();
        return view('admin.riwayat_siswa.schoolYears', [
            'school_years' => $school_years,
        ]);
    }

    public function index($id)
    {
        $classes = ClassGroup::all();
        $students = HistoryStudent::where('school_year_id', $id)->get();
        $year = SchoolYear::find($id);
        return view('admin.riwayat_siswa.index', [
            'classes' => $classes,
            'students' => $students,
            'year' => $year,
        ]);
    }

    public function show($student_id, $year_id)
    {
        $student = HistoryStudent::find($student_id);
        $year = SchoolYear::find($year_id);

        return view('admin.riwayat_siswa.show', [
            'student' => $student,
            'year' => $year,
        ]);
    }

    public function getSchoolYearData($id)
    {
        $students = HistoryStudent::where('school_year_id', $id)->with('studentParent')->select('history_students.*');

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('name', function (HistoryStudent $student) use ($id) {
                return '<a href="' . route('admin.historyStudents.show', [$student->id, $id]) . '">' . $student->name . '</a>';
            })
            ->editColumn('student_parent.name', function (HistoryStudent $student) {
                if ($student->student_parent_id) {
                    return '<a href="' . route('admin.parents.show', $student->studentParent->id) . '">' . $student->studentParent->name . '</a>';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function historyStudentsSchoolYearClass($year_id, $class_id)
    {
        $class = ClassGroup::find($class_id);
        $year = SchoolYear::find($year_id);
        return view('admin.riwayat_siswa.class', [
            'class' => $class,
            'year' => $year,
        ]);
    }

    public function getSchoolYearClassData($year_id, $class_id)
    {
        $students = HistoryStudent::where('school_year_id', $year_id)
            ->where('class_group_id', $class_id)->with('studentParent')->select('history_students.*');

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('name', function (HistoryStudent $student) use ($year_id) {
                return '<a href="' . route('admin.historyStudents.show', [$student->id, $year_id]) . '">' . $student->name . '</a>';
            })
            ->editColumn('student_parent.name', function (HistoryStudent $student) {
                if ($student->student_parent_id) {
                    return '<a href="' . route('admin.parents.show', $student->studentParent->id) . '">' . $student->studentParent->name . '</a>';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }
}
