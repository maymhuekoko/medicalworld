<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class CountingUnitApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
           "data" => "hello"
            ],200);
    }

//    Excel
//    Export
    // public function export(){
    //     return Excel::download(new SizesExport(),'size.xlsx');
    // }

//    Import
    // public function import(Request $request){
    //     $sizes = Excel::import(new SizesImport(),$request->file('import_file'));
    //     alert()->success('Excel Import Succeeded');
    //     return redirect()->back();
    // }

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
            "size_name"=> "required|min:2",
        ]);
        $size = new Size();
        $size->size_name = $request->size_name;
        $size->size_description = $request->size_description;
        $size->gender_id = $request->gender_id;
        $size->save();
        alert()->success('Successfully Added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Size $size,$id)
    {
        $size = Size::find($id);
        $size->size_name = $request->size_name;
        $size->size_description = $request->size_description;
        $size->gender_id = $request->gender_id;
        $size->save();
        alert()->success('Successfully Updated!');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size,$id)
    {
        $size = Size::find($id);
        $size->delete();
        alert()->success('Successfully Deleted');
        return redirect()->back();
    }
}