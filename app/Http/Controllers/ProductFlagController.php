<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ProductFlagController extends Controller
{
    
    public function ViewProductFlagPage() {
        $getallItem = Item::all();
        return view('Admin.products_flag')->with('allproducts',$getallItem);
    }

    public function ChangeFlag(Request $request) {

        if($request->has('new_arr')){
            Item::where('item_name', $request->item)->update([
                'new_product_flag' => 1,
                'arrival_date' => $request->arr_date,
            ]);
        }else{
            Item::where('item_name', $request->item)->update([
                'new_product_flag' => 0,
                'arrival_date' => null,
            ]);
        }

        if($request->has('promo')){
            Item::where('item_name', $request->item)->update([
                'promotion_product_flag' => 1,
                'discount_price' => $request->dis_price,
            ]);
        }else{
            Item::where('item_name', $request->item)->update([
                'promotion_product_flag' => 0,
                'discount_price' => 0,
            ]);
        }

        if($request->has('hot_sale')){
            Item::where('item_name', $request->item)->update([
                'hot_sale_flag' => 1,
            ]);
        }else{
            Item::where('item_name', $request->item)->update([
                'hot_sale_flag' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Flag changed successfully.');
    }

}
