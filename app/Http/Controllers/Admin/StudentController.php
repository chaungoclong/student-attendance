<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rowPerPage = 10;
        $grades = Grade::all();

        if ($request->ajax()) {
            // query builder
            $query = Student::select('*');
            $rowPerPage = $request->row ?? $rowPerPage;

            // gender filter
            if ($request->has('gender') && $request->gender !== null) {
                $query->where('gender', $request->gender);
            }

            // gender filter
            if ($request->has('grade') && $request->grade !== null) {
                $query->where('id_grade', $request->grade);
            }

            // search: name, email, address, phone
            if ($request->has('search')) {
                $query->where(function($subQuery) use($request) {
                    $search = $request->search;

                    $subQuery->where('name', 'LIKE', "%$search%")
                             ->orWhere('email', 'LIKE', "%$search%")
                             ->orWhere('address', 'LIKE', "%$search%")
                             ->orWhere('phone', 'LIKE', "%$search%")
                             ->orWhere('code', 'LIKE', "%$search%");
                });
            }

            // get list of students match with key
            $students = $query->paginate($rowPerPage);

            return view('admins.students.load_index')
                    ->with(['students' => $students]);
        }

        $students = Student::paginate($rowPerPage);

        return view('admins.students.index')
                    ->with(['students' => $students, 'grades' => $grades]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherStoreFormRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        try {
            Teacher::create($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.teacher-manager.index')
                             ->with('error', 'Create failed');
        }

        return redirect()->route('admin.teacher-manager.index')
                             ->with('success', 'Create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher_manager)
    {
        return view('admins.teachers.show')->with('teacher', $teacher_manager);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherUpdateFormRequest $request, Teacher $teacher_manager)
    {
        $validated = $request->validated();

        try {
            $teacher_manager->update($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.teacher-manager.index')
                             ->with('error', 'Update failed');
        }

        return redirect()->route('admin.teacher-manager.index')
                         ->with('success', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
