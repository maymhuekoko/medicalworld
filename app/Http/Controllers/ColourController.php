<?php

namespace App\Http\Controllers;

use App\Colour;
use App\Exports\ColourExport;
use App\Imports\ColourImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ColourController extends Controller
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
        return Excel::download(new ColourExport(),'colour.xlsx');
    }

//    Import
    public function import(Request $request){
        $colours = Excel::import(new ColourImport(),$request->file('import_file'));
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
//        return $request;
        $request->validate([
            "colour_name"=> "required|min:2",
        ]);
        $colour = new Colour();
        $colour->colour_name = $request->colour_name;
        $colour->colour_description = $request->colour_description;
        $colour->fabric_id = $request->fabric_id;
        $colour->save();
        alert()->success('Successfully Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function show(Colour $colour)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Colour $colour,$id)
    {
        $colour= Colour::find($id);
        $colour->colour_name = $request->colour_name;
        $colour->colour_description = $request->colour_description;
        $colour->fabric_id = $request->fabric_id;
        $colour->save();
        alert()->success('Successfully Updated!');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colour $colour,$id)
    {
        $colour = Colour::find($id);
        $colour->delete();
        alert()->success('Successfully Deleted');
        return redirect()->back();
    }
}
