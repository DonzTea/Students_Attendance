<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\ClassGroup;
use App\Position;
use App\Rules\SingleHeadmaster;
use App\Rules\SingleHomeroomTeacher;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::all();
        $classes = ClassGroup::all();
        return view('admin.data_guru.index', [
            'teachers' => $teachers,
            'classes' => $classes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = ClassGroup::all();
        $positions = Position::all();
        return view('admin.data_guru.create', [
            'classes' => $classes,
            'positions' => $positions,
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
        $request->validate([
            'name' => 'required|string|min:4',
            'gender' => 'required|string',
            'nip' => 'required|string|unique:teachers',
            'position_id' => [
                'required',
                'integer',
                new SingleHeadmaster(),
            ],
            'homeroom_teacher_of' => [
                new SingleHomeroomTeacher(),
            ],
        ]);

        $teacher = Teacher::create([
            'name' => $request->name,
            'gender' => $request->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            'nip' => $request->nip,
            'karpeg' => $request->karpeg,
            'birthday' => $request->birthday,
            'position_id' => $request->position_id,
            'type' => $request->type_1 . ' / ' . $request->type_2,
            'homeroom_teacher_of' => $request->homeroom_teacher_of ?: null,
        ]);

        if ($request->teached) {
            $class = ClassGroup::find($request->teached);
            $teacher->classGroups()->attach($class);
        }

        return redirect()->route('admin.teachers.index')
            ->with('success', ucfirst(strtolower($teacher->position->name)) . ' baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return view('admin.data_guru.show', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $classes = ClassGroup::all();
        $positions = Position::all();
        return view('admin.data_guru.edit', [
            'teacher' => $teacher,
            'classes' => $classes,
            'positions' => $positions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        if ($request->nip != $teacher->nip) {
            $request->validate([
                'name' => 'required|string|min:4',
                'gender' => 'required|string',
                'nip' => 'required|string|unique:teachers',
                'position_id' => [
                    'required',
                    'integer',
                    new SingleHeadmaster(),
                ],
                'homeroom_teacher_of' => [
                    new SingleHomeroomTeacher($teacher->id),
                ],
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|min:4',
                'gender' => 'required|string',
                'nip' => 'required|string',
                'position_id' => [
                    'required',
                    'integer',
                    new SingleHeadmaster(),
                ],
                'homeroom_teacher_of' => [
                    new SingleHomeroomTeacher($teacher->id),
                ],
            ]);
        }

        $teacher->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'gender' => $request->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            'karpeg' => $request->karpeg,
            'birthday' => $request->birthday,
            'position_id' => $request->position_id,
            'type' => $request->type_1 . ' / ' . $request->type_2,
            'homeroom_teacher_of' => $request->homeroom_teacher_of ?: null,
        ]);

        if ($request->teached) {
            $class = ClassGroup::find($request->teached);
            $teacher->classGroups()->sync($class);
        }

        return redirect()->route('admin.teachers.index')
            ->with('success', $teacher->gender == 'Laki-laki' ?
                'Data bapak ' . ucwords($teacher->name) . ' berhasil diperbarui.'
                : 'Data ibu ' . ucwords($teacher->name) . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->classGroups()->detach();
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', $teacher->gender == 'Laki-laki' ?
                'Data bapak ' . ucwords($teacher->name) . ' berhasil dihapus.'
                : 'Data ibu ' . ucwords($teacher->name) . ' berhasil dihapus.');
    }

    public function getAllData()
    {
        $teachers = Teacher::with('position')->select('teachers.*');

        return Datatables::of($teachers)
            ->addIndexColumn()
            ->editColumn('name', function (Teacher $teacher) {
                return '<a href="' . route('admin.teachers.show', $teacher->id) . '">' . $teacher->name . '</a>';
            })
            ->addColumn('action', function ($teacher) {
                return Teacher::actionButton($teacher->id);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function getClassData($id)
    {
        $teachers = ClassGroup::find($id)->teachers()
            ->wherePivot('class_group_id', $id)
            ->with('position')
            ->select('teachers.*');

        return DataTables::of($teachers)
            ->addIndexColumn()
            ->editColumn('name', function (Teacher $teacher) {
                return '<a href="' . route('admin.teachers.show', $teacher->id) . '">' . $teacher->name . '</a>';
            })
            ->addColumn('action', function ($teacher) {
                return Teacher::actionButton($teacher->id);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function teachersClass($id)
    {
        $class = ClassGroup::find($id);
        return view('admin.data_guru.class', [
            'class' => $class,
        ]);
    }
}
