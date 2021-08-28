<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assign;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function assign(Request $request)
    {
        $assigns = Assign::where('id_teacher', \Auth::id())->get();
        $data = [];
        $subjects = [];

        foreach ($assigns as $key => $assign) {
            $data[$assign->id_subject]['subject'] = $assign->subject;
            $data[$assign->id_subject]['assignsOfSubject'][] = $assign;
        }

        return view('teachers.works.assign')->with('data', $data);
    }

    public function schedule(Request $request)
    {
        
    }
}
