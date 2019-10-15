<?php

namespace App\Http\Controllers;

use App\ClassGroup;
use App\HistoryTeacher;
use App\SchoolYear;
use Yajra\DataTables\DataTables;

class HistoryTeacherController extends Controller
{
    public function schoolYears()
    {
        $school_years = SchoolYear::where('name', '<', date('Y'))->get();
        return view('admin.riwayat_guru.schoolYears', [
            'school_years' => $school_years,
        ]);
    }

    public function index($id)
    {
        $classes = ClassGroup::all();
        $teachers = HistoryTeacher::where('school_year_id', $id)->get();
        $year = SchoolYear::find($id);
        return view('admin.riwayat_guru.index', [
            'classes' => $classes,
            'teachers' => $teachers,
            'year' => $year,
        ]);
    }

    public function show($teacher_id, $year_id)
    {
        $teacher = HistoryTeacher::find($teacher_id);
        $year = SchoolYear::find($year_id);

        return view('admin.riwayat_guru.show', [
            'teacher' => $teacher,
            'year' => $year,
        ]);
    }

    public function getSchoolYearData($id)
    {
        $teachers = HistoryTeacher::where('school_year_id', $id)->with('position')->select('history_teachers.*');

        return DataTables::of($teachers)
            ->addIndexColumn()
            ->editColumn('name', function (HistoryTeacher $teacher) use ($id) {
                return '<a href="' . route('admin.historyTeachers.show', [$teacher->id, $id]) . '">' . $teacher->name . '</a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function historyTeachersSchoolYearClass($year_id, $class_id)
    {
        $class = ClassGroup::find($class_id);
        $year = SchoolYear::find($year_id);
        return view('admin.riwayat_guru.class', [
            'class' => $class,
            'year' => $year,
        ]);
    }

    public function getSchoolYearClassData($year_id, $class_id)
    {
        $teachers = ClassGroup::find($class_id)
            ->historyTeachers()
            ->where('school_year_id', $year_id)
            ->wherePivot('class_group_id', $class_id)
            ->with('position')
            ->select('history_teachers.*');

        return DataTables::of($teachers)
            ->addIndexColumn()
            ->editColumn('name', function (HistoryTeacher $teacher) use ($year_id) {
                return '<a href="' . route('admin.historyTeachers.show', [$teacher->id, $year_id]) . '">' . $teacher->name . '</a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
