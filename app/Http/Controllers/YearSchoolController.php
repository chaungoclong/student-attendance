<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\YearSchoolRequest;
use App\Models\YearSchool;

class YearSchoolController extends Controller
{
    protected $message;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $yearSchools = YearSchool::paginate(8);

        return view('yearschools.index')->with('yearSchools', $yearSchools);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(YearSchoolRequest $request)
    {
        //
        $yearSchool = new YearSchool();
        $yearSchool->name = $request->yearschool;
        try{
            $yearSchool->save();
            $this->message['content'] = "Create Success";
            $this->message['status'] = 1;
        } catch(Exception $e) {
            $this->message['content'] = "Create Error";
            $this->message['status'] = 0;
        }

        return redirect()->route('yearschool.index')->with('message', $this->message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $yearSchool = YearSchool::find($id);

        return view('yearschools.edit')->with('yearschool', $yearSchool);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(YearSchoolRequest $request, $id)
    {
        //
        $yearSchool = YearSchool::find($id);
        $yearSchool->name = $request->yearschool;
        try{
            $yearSchool->save();
            $this->message['content'] = "Update Success";
            $this->message['status'] = 1;
        } catch(Exception $e) {
            $this->message['content'] = "Update Error";
            $this->message['status'] = 0;
        }

        return redirect()->route('yearschool.index')->with('message', $this->message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            YearSchool::destroy($id);
            $this->message['content'] = "Delete Success";
            $this->message['status'] = 1;
        } catch (Exception $e) {
            $this->message['content'] = "Detele Error";
            $this->message['status'] = 0;
        }

        return redirect()->route('yearschool.index')->with('message', $this->message);
    }
}
