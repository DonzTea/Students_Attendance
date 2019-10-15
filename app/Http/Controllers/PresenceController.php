<?php

namespace App\Http\Controllers;

use App\ClassGroup;
use App\Exports\PresencesExport;
use App\Presence;
use App\SchoolYear;
use App\Teacher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PresenceController extends Controller
{
    public function index()
    {
        $classes = ClassGroup::all();
        return view('admin.data_kehadiran.index', [
            'classes' => $classes,
        ]);
    }

    public function createOrEdit($id, $date)
    {
        $class = ClassGroup::find($id);
        return view('admin.data_kehadiran.createOrEdit', [
            'class' => $class,
            'date' => $date,
        ]);
    }

    public function store(Request $request, $id, $date)
    {
        $year = SchoolYear::latest()->first();
        foreach (ClassGroup::find($id)->students as $student) {
            if ($request->{'presence_' . $student->id}) {
                Presence::create([
                    'student_id' => $student->id,
                    'date' => $date,
                    'info' => $request->{'presence_' . $student->id},
                    'class_group_id' => $id,
                    'school_year_id' => $year->id,
                ]);
            }
        }

        return redirect()->route('admin.presences.show', [
            'id' => $id,
            'month' => date('m'),
        ])->with(
            'success',
            'Data kehadiran ' . ClassGroup::find($id)->name . ' tanggal ' . $date . ' berhasil ditambahkan.'
        );
    }

    public function update(Request $request, $id, $date)
    {
        foreach (ClassGroup::find($id)->students as $student) {
            if ($request->{'presence_' . $student->id}) {
                $presence = ClassGroup::find($id)
                    ->students()->find($student->id)
                    ->presences()->where('date', $date)->first();
                if ($presence !== null) {
                    $presence->update([
                        'info' => $request->{'presence_' . $student->id},
                    ]);
                } else {
                    $year = SchoolYear::where('name', substr($date, 6, 4))->first();
                    Presence::create([
                        'student_id' => $student->id,
                        'date' => $date,
                        'info' => $request->{'presence_' . $student->id},
                        'class_group_id' => $id,
                        'school_year_id' => $year->id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.presences.show', [
            'id' => $id,
            'month' => date('m'),
        ])->with(
            'success',
            'Data kehadiran ' . ClassGroup::find($id)->name . ' tanggal ' . $date . ' berhasil diperbarui.'
        );
    }

    public function destroy($id, $date)
    {
        foreach (ClassGroup::find($id)->students as $student) {
            $presence = $student->presences()->where('date', $date)->first();
            if ($presence !== null) {
                $presence->delete();
            }
        }

        return redirect()->route('admin.presences.show', [
            'id' => $id,
            'month' => date('m'),
        ])->with(
            'success',
            'Data kehadiran ' . ClassGroup::find($id)->name . ' tanggal ' . $date . ' berhasil dihapus.'
        );
    }

    public function show($id, $month)
    {
        $class = ClassGroup::find($id);
        $isDownloadable = (Teacher::where('position_id', 1)->get()->count() > 0 &&
            Teacher::where('homeroom_teacher_of', $id)->get()->count() > 0 &&
            $class->students()->get()->count() > 0) ? true : false;
        $monthList = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        $currentMonth = $this->getMonth($month);
        return view('admin.data_kehadiran.show', [
            'class' => $class,
            'month' => $month,
            'isDownloadable' => $isDownloadable,
            'monthList' => $monthList,
            'currentMonth' => $currentMonth,
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

    public function export($id, $date)
    {
        $month = substr($date, 3, 2);
        $class_name = strtolower(ClassGroup::find($id)->name);
        $month_name = strtolower($this->getMonth($month));
        return Excel::download(
            new PresencesExport($id, $month),
            'kehadiran-siswa-' . $class_name . '-bulan-' . $month_name . '-tahun-pelajaran-' . date('Y') . '-' . (date('Y') + 1) . '.xlsx'
        );
    }
}
