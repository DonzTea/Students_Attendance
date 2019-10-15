<?php

namespace App\Http\Controllers;

use App\ClassGroup;
use App\Exports\HistoryPresencesExport;
use App\HistoryTeacher;
use App\SchoolYear;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HistoryPresenceController extends Controller
{

    public function schoolYears()
    {
        $school_years = SchoolYear::where('name', '<', date('Y'))->get();
        return view('admin.riwayat_kehadiran.schoolYears', [
            'school_years' => $school_years,
        ]);
    }

    public function historyPresencesIndex($id)
    {
        $classes = ClassGroup::all();
        $year = SchoolYear::find($id);
        return view('admin.riwayat_kehadiran.index', [
            'classes' => $classes,
            'year' => $year,
        ]);
    }

    public function historyPresencesMonths($id, $class_id)
    {
        $year = SchoolYear::find($id);
        $class = ClassGroup::find($class_id);
        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        return view('admin.riwayat_kehadiran.months', [
            'year' => $year,
            'class' => $class,
            'months' => $months,
        ]);
    }

    public function historyPresencesMonth($id, $class_id, $month)
    {
        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        $month_name = $months[$month - 1];
        $month_index = substr($month, 0, 1) == '0' ?  substr($month, 1) : $month;

        $year = SchoolYear::find($id);
        $class = ClassGroup::find($class_id);
        $isDownloadable = (HistoryTeacher::where('position_id', 1)->get()->count() > 0 &&
            $year->historyTeachers()->where('homeroom_teacher_of', $class_id)->get()->count() > 0 &&
            $year->classGroups()->find($class_id)->historyStudents()
            ->where('school_year_id', $year->id)->get()->count() > 0) ? true : false;
        return view('admin.riwayat_kehadiran.show', [
            'year' => $year,
            'class' => $class,
            'month_index' => $month_index,
            'month_name' => $month_name,
            'isDownloadable' => $isDownloadable,
        ]);
    }

    public function export($id, $class_id, $month)
    {
        $year_name = SchoolYear::find($id)->name;
        $class_name = strtolower(ClassGroup::find($class_id)->name);

        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        $month_name = $months[$month - 1];
        return Excel::download(
            new HistoryPresencesExport($id, $class_id, $month),
            'kehadiran-siswa-' . $class_name . '-bulan-' . $month_name . '-tahun-pelajaran-' . $year_name . '-' . ($year_name + 1) . '.xlsx'
        );
    }
}
