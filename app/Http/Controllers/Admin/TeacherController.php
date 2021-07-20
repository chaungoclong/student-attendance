<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherStoreFormRequest;
use App\Http\Requests\TeacherUpdateFormRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function __construct()
    {
        // ngan khong luu flash session vao cache
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

        if ($request->ajax()) {
           return $this->search($request, $rowPerPage);
        }

        $teachers = Teacher::paginate($rowPerPage);

        return view('admins.teachers.index')
                    ->with(['teachers' => $teachers]);
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
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher_manager)
    {
        return view('admins.teachers.show')->with('teacher', $teacher_manager);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
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
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }

    /**
     * [search description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function search($request, $rowPerPage)
    {
        // query builder
        $query = Teacher::select('*');
        $rowPerPage = $request->row ?? $rowPerPage;

        // gender filter
        if ($request->has('gender') && $request->gender !== null) {
            $query->where('gender', $request->gender);
        }

        // search: name, email, address, phone
        if ($request->has('search')) {
            $query->where(function($subQuery) use($request) {
                $search = $request->search;

                $subQuery->where('name', 'LIKE', "%$search%")
                         ->orWhere('email', 'LIKE', "%$search%")
                         ->orWhere('address', 'LIKE', "%$search%")
                         ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        // get list of teachers match with key
        $teachers = $query->paginate($rowPerPage);

        $html = view('admins.teachers.load_index')
                ->with(['teachers' => $teachers])
                ->render();

        return response()->json(['html' => $html], 200);
    }
}
