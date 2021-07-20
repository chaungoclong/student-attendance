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
    public function index(Request $request)
    {
        $rowPerPage = 10;

        if ($request->ajax()) {
            return $this->search($request, $rowPerPage);
        }

        $assigns = Assign::paginate($rowPerPage);
        $grades = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        $data = [
            'assigns' => $assigns,
            'grades' => $grades,
            'subjects' => $subjects,
            'teachers' => $teachers
        ];

        return view('admins.assigns.index', $data);
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

    public function search($request, $rowPerPage)
    {
        // query builder
        $query = Assign::select('*');
        $rowPerPage = $request->row ?? $rowPerPage;

        // grade filter
        if ($request->has('grade') && $request->grade !== null) {
            $query->where('id_grade', $request->grade);
        }

         // subject filter
        if ($request->has('subject') && $request->subject !== null) {
            $query->where('id_subject', $request->subject);
        }

         // teacher filter
        if ($request->has('teacher') && $request->teacher !== null) {
            $query->where('id_teacher', $request->teacher);
        }

        // get list of assign match with key
        $assigns = $query->paginate($rowPerPage);

        $html = view('admins.assigns.load_index')
                ->with(['assigns' => $assigns])
                ->render();

        return response()->json(['html' => $html], 200);
    }
}
