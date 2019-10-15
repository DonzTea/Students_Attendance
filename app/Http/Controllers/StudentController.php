<?php

namespace App\Http\Controllers;

use App\ClassGroup;
use App\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\StudentParent;
use App\Religion;
use App\Region;
use App\Family;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = ClassGroup::all();
        $students = Student::all();
        return view('admin.data_siswa.index', [
            'classes' => $classes,
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::all();
        $parents = StudentParent::all();
        $religions = Religion::all();
        $classes = ClassGroup::all();

        return view('admin.data_siswa.create', [
            'regions' => $regions,
            'parents' => $parents,
            'religions' => $religions,
            'classes' => $classes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->height == null && $request->weight == null) {
            $request->validate([
                'nis' => 'required|string|min:7|unique:students',
                'nisn' => 'required|string|min:9|unique:students',
                'name' => 'required|string|min:4',
                'gender' => 'required',
                'class_id' => 'required',
            ]);
        } else if ($request->height == null) {
            $request->validate([
                'nis' => 'required|string|min:7|unique:students',
                'nisn' => 'required|string|min:9|unique:students',
                'name' => 'required|string|min:4',
                'gender' => 'required',
                'class_id' => 'required',
                'weight' => 'integer|min:10|max:200',
            ]);
        } else if ($request->weight == null) {
            $request->validate([
                'nis' => 'required|string|min:7|unique:students',
                'nisn' => 'required|string|min:9|unique:students',
                'name' => 'required|string|min:4',
                'gender' => 'required',
                'class_id' => 'required',
                'weight' => 'integer|min:10|max:200',
            ]);
        } else {
            $request->validate([
                'nis' => 'required|string|min:7|unique:students',
                'nisn' => 'required|string|min:9|unique:students',
                'name' => 'required|string|min:4',
                'gender' => 'required',
                'class_id' => 'required',
                'height' => 'integer|min:35|max:280',
                'weight' => 'integer|min:10|max:200',
            ]);
        }

        $student = Student::create([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'name' => $request->name,
            'gender' => $request->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            'region_id' => $request->region_id,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'student_parent_id' => $request->parent_id,
            'religion_id' => $request->religion_id,
            'height' => $request->height ?: null,
            'weight' => $request->weight ?: null,
            'class_group_id' => $request->class_id,
        ]);

        $n_child = $request->n_child ?: 0;
        $siblings_count = $request->siblings_count ?: 0;
        $step_brothers_count = $request->step_brothers_count ?: 0;
        $adopted_brothers_count = $request->adopted_brothers_count ?: 0;
        $sibsTotal = $siblings_count && $step_brothers_count && $adopted_brothers_count;

        Family::create([
            'live_with' => $request->live_with,
            'economic_condition' => $request->economic_condition,
            'learning_condition' => $request->learning_condition,
            'n_child' => $n_child,
            'siblings_count' => $siblings_count,
            'step_brothers_count' => $step_brothers_count,
            'adopted_brothers_count' => $adopted_brothers_count,
            'sibs_total' => $sibsTotal,
            'used_language' => $request->used_language,
            'student_id' => $student->id,
            'student_parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', $student->name . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('admin.data_siswa.show', [
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $regions = Region::all();
        $parents = StudentParent::all();
        $religions = Religion::all();
        $classes = ClassGroup::all();

        return view('admin.data_siswa.edit', [
            'student' => $student,
            'regions' => $regions,
            'parents' => $parents,
            'religions' => $religions,
            'classes' => $classes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if ($request->nis != $student->nis && $request->nisn != $student->nisn) {
            if ($request->height == null && $request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                ]);
            } else if ($request->height == null) {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'weight' => 'integer|min:10|max:200',
                ]);
            } else if ($request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                ]);
            } else {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                    'weight' => 'integer|min:10|max:200',
                ]);
            }
        } else if ($request->nis != $student->nis) {
            if ($request->height == null && $request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                ]);
            } else if ($request->height == null) {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'weight' => 'integer|min:10|max:200',
                ]);
            } else if ($request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                ]);
            } else {
                $request->validate([
                    'nis' => 'required|string|min:7|unique:students',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                    'weight' => 'integer|min:10|max:200',
                ]);
            }
        } else if ($request->nisn != $student->nisn) {
            if ($request->height == null && $request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                ]);
            } else if ($request->height == null) {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'weight' => 'integer|min:10|max:200',
                ]);
            } else if ($request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                ]);
            } else {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9|unique:students',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                    'weight' => 'integer|min:10|max:200',
                ]);
            }
        } else {
            if ($request->height == null && $request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                ]);
            } else if ($request->height == null) {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'weight' => 'integer|min:10|max:200',
                ]);
            } else if ($request->weight == null) {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                ]);
            } else {
                $request->validate([
                    'nis' => 'required|string|min:7',
                    'nisn' => 'required|string|min:9',
                    'name' => 'required|string|min:4',
                    'gender' => 'required',
                    'class_id' => 'required',
                    'height' => 'integer|min:30|max:300',
                    'weight' => 'integer|min:10|max:200',
                ]);
            }
        }

        $student->update([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'name' => $request->name,
            'gender' => $request->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            'region_id' => $request->region_id,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'student_parent_id' => $request->parent_id,
            'religion_id' => $request->religion_id,
            'height' => $request->height ?: null,
            'weight' => $request->weight ?: null,
            'class_group_id' => $request->class_id,
        ]);

        $n_child = $request->n_child ?: 0;
        $siblings_count = $request->siblings_count ?: 0;
        $step_brothers_count = $request->step_brothers_count ?: 0;
        $adopted_brothers_count = $request->adopted_brothers_count ?: 0;
        $sibsTotal = $siblings_count && $step_brothers_count && $adopted_brothers_count;

        if ($student->family) {
            $student->family->update([
                'live_with' => $request->live_with,
                'economic_condition' => $request->economic_condition,
                'learning_condition' => $request->learning_condition,
                'n_child' => $n_child,
                'siblings_count' => $siblings_count,
                'step_brothers_count' => $step_brothers_count,
                'adopted_brothers_count' => $adopted_brothers_count,
                'sibs_total' => $sibsTotal,
                'used_language' => $request->used_language,
                'student_id' => $student->id,
                'student_parent_id' => $request->parent_id,
            ]);
        } else {
            Family::create([
                'live_with' => $request->live_with,
                'economic_condition' => $request->economic_condition,
                'learning_condition' => $request->learning_condition,
                'n_child' => $n_child,
                'siblings_count' => $siblings_count,
                'step_brothers_count' => $step_brothers_count,
                'adopted_brothers_count' => $adopted_brothers_count,
                'sibs_total' => $sibsTotal,
                'used_language' => $request->used_language,
                'student_id' => $student->id,
                'student_parent_id' => $request->parent_id,
            ]);
        }

        return redirect()->route('admin.students.index')
            ->with('success', $student->name . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->family->delete();
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', $student->name . ' berhasil dihapus.');
    }

    public function getAllData()
    {
        $students = Student::with('studentParent')->select('students.*');

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('name', function (Student $student) {
                return '<a href="' . route('admin.students.show', $student->id) . '">' . $student->name . '</a>';
            })
            ->editColumn('student_parent.name', function (Student $student) {
                if ($student->student_parent_id) {
                    return '<a href="' . route('admin.parents.show', $student->studentParent->id) . '">' . $student->studentParent->name . '</a>';
                }
            })
            ->addColumn('action', function ($student) {
                return Student::actionButton($student->id);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function getClassData($id)
    {
        $students = Student::where('class_group_id', $id)
            ->with('studentParent')
            ->select('students.*');

        return DataTables::eloquent($students)
            ->addIndexColumn()
            ->editColumn('name', function (Student $student) {
                return '<a href="' . route('admin.students.show', $student->id) . '">' . $student->name . '</a>';
            })
            ->editColumn('student_parent.name', function (Student $student) {
                if ($student->student_parent_id) {
                    return '<a href="' . route('admin.parents.show', $student->studentParent->id) . '">' . $student->studentParent->name . '</a>';
                }
            })
            ->addColumn('action', function ($student) {
                return Student::actionButton($student->id);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function studentsClass($id)
    {
        $class = ClassGroup::find($id);
        return view('admin.data_siswa.class', [
            'class' => $class,
        ]);
    }

    public function studentsClassPresence($id, $date)
    {
        $students = Student::where('class_group_id', $id)->select('students.*');

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('name', function (Student $student) {
                return '<a href="' . route('admin.students.show', $student->id) . '">' . $student->name . '</a>';
            })
            ->addColumn('masuk', function ($student) use ($date) {
                if ($student->presences()
                    ->where('date', $date)
                    ->where('info', 'Masuk')
                    ->first()
                ) {
                    return Student::presenceInput($student->id, 'Masuk', 'checked');
                } else {
                    return Student::presenceInput($student->id, 'Masuk', '');
                }
            })
            ->addColumn('sakit', function ($student) use ($date) {
                if ($student->presences()
                    ->where('date', $date)
                    ->where('info', 'Sakit')
                    ->first()
                ) {
                    return Student::presenceInput($student->id, 'Sakit', 'checked');
                } else {
                    return Student::presenceInput($student->id, 'Sakit', '');
                }
            })
            ->addColumn('izin', function ($student) use ($date) {
                if ($student->presences()
                    ->where('date', $date)
                    ->where('info', 'Izin')
                    ->first()
                ) {
                    return Student::presenceInput($student->id, 'Izin', 'checked');
                } else {
                    return Student::presenceInput($student->id, 'Izin', '');
                }
            })
            ->addColumn('alfa', function ($student) use ($date) {
                if ($student->presences()
                    ->where('date', $date)
                    ->where('info', 'Alfa')
                    ->first()
                ) {
                    return Student::presenceInput($student->id, 'Alfa', 'checked');
                } else {
                    return Student::presenceInput($student->id, 'Alfa', '');
                }
            })
            ->editColumn('gender', function (Student $student) {
                return $student->gender == 'Laki-laki' ? 'L' : 'P';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
