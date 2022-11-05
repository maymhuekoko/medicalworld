<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleCustomerLists extends Controller
{
    function index(){
        return view('Sale.sale_customer_lists',compact('sale_customer_lists'));
    }
}
