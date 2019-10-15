<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentParent;
use Yajra\DataTables\Facades\DataTables;
use App\Religion;
use App\Education;
use App\Student;

class StudentParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = StudentParent::all();
        return view('admin.data_orang_tua.index', [
            'parents' => $parents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $religions = Religion::all();
        $educations = Education::all();
        $students = Student::whereNull('student_parent_id')->get();
        return view('admin.data_orang_tua.create', [
            'religions' => $religions,
            'educations' => $educations,
            'students' => $students,
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
        if ($request->age != null) {
            $request->validate([
                'name' => 'required|string|min:4',
                'age' => 'integer|min:9|max:180',
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|min:4',
            ]);
        }

        $parent = StudentParent::create([
            'name' => $request->name,
            'age' => $request->age ?: null,
            'religion_id' => $request->religion_id,
            'education_id' => $request->education_id,
            'profession' => $request->profession,
            'address' => $request->address,
        ]);

        if ($request->parent_of) {
            $children = Student::find($request->parent_of);
            foreach ($children as $child) {
                $child->update([
                    'student_parent_id' => $parent->id,
                ]);
            }
        }

        return redirect()->route('admin.parents.index')
            ->with('success', $parent->name . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentParent  $parent
     * @return \Illuminate\Http\Response
     */
    public function show(StudentParent $parent)
    {
        return view('admin.data_orang_tua.show', [
            'parent' => $parent,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentParent  $parent
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentParent $parent)
    {
        $religions = Religion::all();
        $educations = Education::all();
        $students = Student::all();
        return view('admin.data_orang_tua.edit', [
            'parent' => $parent,
            'religions' => $religions,
            'educations' => $educations,
            'students' => $students,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentParent  $parent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentParent $parent)
    {
        if ($request->age != null) {
            $request->validate([
                'name' => 'required|string|min:4',
                'age' => 'integer|min:9|max:180',
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|min:4',
            ]);
        }

        $parent->update([
            'name' => $request->name,
            'age' => $request->age ?: null,
            'religion_id' => $request->religion_id,
            'education_id' => $request->education_id,
            'profession' => $request->profession,
            'address' => $request->address,
        ]);

        if ($parent->students) {
            foreach ($parent->students as $child) {
                $child->update([
                    'student_parent_id' => null,
                ]);
            }
        }

        if ($request->parent_of) {
            $children = Student::find($request->parent_of);
            foreach ($children as $child) {
                $child->update([
                    'student_parent_id' => $parent->id,
                ]);
            }
        }

        return redirect()->route('admin.parents.index')
            ->with('success', $parent->name . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentParent  $parent
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentParent $parent)
    {
        if ($parent->students) {
            foreach ($parent->students as $child) {
                $child->update([
                    'student_parent_id' => null,
                ]);
            }
        }
        $parent->delete();

        return redirect()->route('admin.parents.index')
            ->with('success', $parent->name . ' berhasil dihapus.');
    }

    public function allParents()
    {
        $parents = StudentParent::with('religion')->with('education')->select('student_parents.*');

        return DataTables::of($parents)
            ->addIndexColumn()
            ->editColumn('name', function (StudentParent $parent) {
                return '<a href="' . route('admin.parents.show', $parent->id) . '">' . $parent->name . '</a>';
            })
            ->addColumn('action', function ($parent) {
                return StudentParent::actionButton($parent->id);
            })
            ->escapeColumns([])
            ->make(true);
    }
}
