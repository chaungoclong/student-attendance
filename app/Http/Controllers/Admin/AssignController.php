<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assign\AssignStoreFormRequest;
use App\Models\Assign;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assigns = Assign::all();
        return view('admins.assigns.index', ['assigns' => $assigns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $grades = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        $data = [
            'grades' => $grades,
            'subjects' => $subjects,
            'teachers' => $teachers
        ];

        return view('admins.assigns.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $error = $this->validation($request);

        if ($error) {
           return response()->json($error, 422);
        }

        // create
        try {
            $this->storeRepeat($request);
        } catch (\Exception $e) {
            $error = [
                "code"    => 2, 
                'message' => 'some error, try again'
            ];

            return response()->json($error, 422);
        }

        // redirect after create success
        $success = ['redirect' => route('admin.assign.index')];

        return response()->json($success, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assign  $assign
     * @return \Illuminate\Http\Response
     */
    public function show(Assign $assign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assign  $assign
     * @return \Illuminate\Http\Response
     */
    public function edit(Assign $assign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assign  $assign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assign $assign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assign  $assign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assign $assign)
    {
        //
    }

    public function validation(Request $request)
    {
        $id_grades = $request->id_grade;
        $id_subjects = $request->id_subject;
        $id_teachers = $request->id_teacher;

        $errorRows = [];

        for ($i = 0; $i < count($id_grades); $i++) { 
            $count = Assign::where('id_grade', $id_grades[$i])
                           ->where('id_subject', $id_subjects[$i])
                           ->where('id_teacher', $id_teachers[$i])
                           ->count();
        

            if ($count > 0) {
                $errorRows[] = $i;
            }
        }

        $error = [];

        if (count($errorRows) > 0) {
            $error['code'] = 1;
            $error['message'] = 'already exist';
            $error['errorRows'] = $errorRows;
        }

        return $error;
    }

    public function storeRepeat(Request $request)
    {
        $id_grades = $request->id_grade;
        $id_subjects = $request->id_subject;
        $id_teachers = $request->id_teacher;

        for ($i = 0; $i < count($id_grades); $i++) { 
           $row = [
                'id_grade' => $id_grades[$i],
                'id_subject' => $id_subjects[$i],
                'id_teacher' => $id_teachers[$i],
            ];

            Assign::create($row);
        }
    }
}
