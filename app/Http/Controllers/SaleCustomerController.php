<?php

namespace App\Http\Controllers;

use App\SalesCustomer;
use Illuminate\Http\Request;

class SaleCustomerController extends Controller
{
    public function delete(Request $request){
      $id=$request->salecustomer_id;
     $deletesalecustomer= SalesCustomer::findOrFail($id)->delete();
     
     //$result=SalesCustomer::all();

    // return response()->json($result);
    
    return response()->json($deletesalecustomer);

      //dd($id);
    }
    
}
