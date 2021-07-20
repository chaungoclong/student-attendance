<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreFormRequest;
use App\Http\Requests\StudentUpdateFormRequest;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        // khong luu session flash vao cache
        $this->middleware('preventCache');
    }
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
            return $this->search($request, $rowPerPage);
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
        $grades = Grade::all();
        return view('admins.students.create')->with('grades', $grades);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreFormRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        // $validated['password'] = Hash::make($validated['password']);

        try {
            Student::create($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.student-manager.index')
                             ->with('error', 'Create failed');
        }

        return redirect()->route('admin.student-manager.index')
                             ->with('success', 'Create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student_manager)
    {
        $grades = Grade::all();
        return view('admins.students.show')
            ->with(['student' => $student_manager, 'grades' => $grades]);
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
    public function update(StudentUpdateFormRequest $request, Student $student_manager)
    {
        $validated = $request->validated();

        try {
            $student_manager->update($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.student-manager.index')
                             ->with('error', 'Update failed');
        }

        return redirect()->route('admin.student-manager.index')
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

    public function search($request, $rowPerPage)
    {
        // query builder
        $query = Student::select('*');
        $rowPerPage = $request->row ?? $rowPerPage;

        // gender filter
        if ($request->has('gender') && $request->gender !== null) {
            $query->where('gender', $request->gender);
        }

        // grade filter
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

        $html = view('admins.students.load_index')
                ->with(['students' => $students])
                ->render();

        return response()->json(['html' => $html], 200);
    }
}
