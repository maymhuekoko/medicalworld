<?php

namespace App\Http\Controllers;

use App\Exports\GenderExport;
use App\Gender;
use App\Imports\GenderImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    //    Excel
//    Export
    public function export(){
        return Excel::download(new GenderExport(),'gender.xlsx');
    }

//    Import
    public function import(Request $request){
        $genders = Excel::import(new GenderImport(),$request->file('import_file'));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
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
            "gender_name"=> "required|min:2",
        ]);
        $gender = new Gender();
        $gender->gender_name = $request->gender_name;
        $gender->gender_description = $request->gender_description;
        $gender->save();
        alert()->success('Successfully Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function show(Gender $gender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gender $gender,$id)
    {
        $gender= Gender::find($id);
        $gender->gender_name = $request->gender_name;
        $gender->gender_description = $request->gender_description;
        $gender->save();
        alert()->success('Successfully Updated!');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gender $gender,$id)
    {
        $gender= Gender::find($id);
        $gender->delete();
        return redirect()->back();
    }
}
