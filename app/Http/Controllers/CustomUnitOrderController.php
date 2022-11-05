<?php

namespace App\Http\Controllers;

use App\CustomUnitOrder;
use Illuminate\Http\Request;

class CustomUnitOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $items = json_decode($request->item);
//        dd($items);

        $grand = json_decode($request->grand_total);
        $total_quantity = $grand->total_qty;
        $total_amount = $grand->sub_total;
        $selling_price = $items[0]->selling_price;
        foreach ($items as $item) {
            $order= new CustomUnitOrder();
            $order->item_name = $item->item_name;
            $order->design_id = $item->design_id;
            $order->fabric_id = $item->fabric_id;
            $order->colour_id = $item->color_id;
            $order->size_id = $item->size_id;
            $order->gender_id = $item->gender_id;
            $order->selling_price = $selling_price;
            $order->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomUnitOrder  $customUnitOrder
     * @return \Illuminate\Http\Response
     */
    public function show(CustomUnitOrder $customUnitOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomUnitOrder  $customUnitOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomUnitOrder $customUnitOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomUnitOrder  $customUnitOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomUnitOrder $customUnitOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomUnitOrder  $customUnitOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomUnitOrder $customUnitOrder)
    {
        //
    }
}
