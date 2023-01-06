<?php

namespace App\Http\Controllers\Web;

use App\From;
use App\Imports\CategoryImport;
use App\Imports\CountingUnitImport;
use App\Imports\ItemsImport;
use App\Imports\FactoryItemImport;
use App\Imports\SubcategoryImport;
use App\Exports\ItemExport;
use App\Exports\SubCategoryExport;
use App\Exports\FactoryItemExport;
use App\Item;
use Exception;
use App\Category;
use App\Stockcount;
use App\SubCategory;
use App\CountingUnit;
use App\UnitRelation;
use App\UnitConversion;
use App\FactoryItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    // Item Excel Import
    public function import(Request $request){
        $items = Excel::import(new ItemsImport(),$request->file('import_file'));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new ItemExport(),'item_export.xlsx');
    }

//    Counting Unit Excel Import
    public function countingUnitImport(Request $request){
        $countUnits =Excel::import(new CountingUnitImport(),$request->file('import_file'));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }

//    Category Excel Import
    public function categoryImport(Request $request){
        $categories = Excel::import(new CategoryImport(),$request->file('import_file'));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }

//    SubCategory Excel Import
    public function subCategoryImport(Request $request){
        $subCategories = Excel::import(new SubcategoryImport(),$request->file('import_file'));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }

    public function subcategoryExport()
    {
        return Excel::download(new SubCategoryExport(),'subcategory_export.xlsx');
    }

    public function factoryItemimport(Request $request)
    {
        $factoryitems = Excel::import(new FactoryItemImport(),$request->file(('import_file')));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }

     public function factoryItemExport()
    {
        return Excel::download(new FactoryItemExport(),'factoryItem_export.xlsx');
    }

	protected function getInventoryDashboard()
	{
		return view('Inventory.inv_dashboard');
	}

	protected function categoryList()
	{
		$category_lists =  Category::whereNull("deleted_at")->get();

		return view('Inventory.category_list', compact('category_lists'));
	}

	protected function storeCategory(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'category_code' => 'required',
            'category_name' => 'required',
            'type_flag' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user_code = $request->session()->get('user')->user_code;

        try {

            $category = Category::create([
                'category_name' => $request->category_name,
                'category_code' => $request->category_code,
                'created_by' => $user_code,
                'type_flag' => $request->type_flag,
            ]);

            //$category->category_code = sprintf('%03s',$request->category_code);

           // $category->save();

        } catch (\Exception $e) {

            alert()->error('Something Wrong! When Creating Category.');

            return redirect()->back();
        }


    	alert()->success('Successfully Added');

        return redirect()->route('category_list');
	}

	protected function updateCategory($id, Request $request)
	{
		try {

        	$category = Category::findOrFail($id);

   		} catch (\Exception $e) {

        	alert()->error("Category Not Found!")->persistent("Close!");

            return redirect()->back();

    	}

        $category->category_code = $request->category_code;

        $category->category_name = $request->category_name;

        $category->save();

        alert()->success('Successfully Updated!');

        return redirect()->route('category_list');
	}

	protected function deleteCategory(Request $request)
	{
		$id = $request->category_id;

        $category = Category::find($id);

        $items = Item::where('category_id', $id)->get();

        foreach ($items as $item) {

            foreach ($item->counting_units as $unit) {

                $unit->delete();
            }
        }

        $items = Item::where('category_id', $id)->delete();

        $category->delete();

        return response()->json($category);
	}

	protected function subcategoryList()
	{
		$categories = Category::all();

		$sub_categories = SubCategory::all();

		return view('Inventory.subcategory_list', compact('categories','sub_categories'));
	}

	protected function storeSubCategory(request $request){

	    $validator = Validator::make($request->all(), [
            'sub_category_code' => 'required',
            'sub_category_name' => 'required',
            'category' => 'required',
            'inlineRadioOptions' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }


            $sub_category = SubCategory::create([
                'name' => $request->sub_category_name,
                'category_id' => $request->category,
                'type_flag' => $request->inlineRadioOptions,
            ]);

            $sub_category->subcategory_code = sprintf('%03s',$request->sub_category_code);

            $sub_category->save();

    	    alert()->success('Successfully Added');

        return redirect()->route('subcategory_list');
	}

	protected function updateSubCategory(request $request, $id){

	   try {

        	$sub_category = SubCategory::findOrFail($id);

   		} catch (\Exception $e) {

        	alert()->error("Category Not Found!")->persistent("Close!");

            return redirect()->back();

    	}

        $sub_category->subcategory_code = $request->sub_category_code;

        $sub_category->name = $request->sub_category_name;

        $sub_category->save();

        alert()->success('Successfully Updated!');

        return redirect()->route('subcategory_list');

	}

	protected function showSubCategory(request $request){

	    $category_id = $request->category_id;

	    $subcategory = SubCategory::where('category_id', $category_id)->get();

	    return response()->json($subcategory);
	}

	protected function itemList()
	{
        $item_lists =  Item::whereNull("deleted_at")->orderBy('category_id', 'ASC')->get();

       // $units=CountingUnit::whereNull("deleted_at")->orderBy('id', 'ASC')->get();

		$categories =  Category::whereNull("deleted_at")->get();


		$sub_categories = SubCategory::all();

		$counting_units = CountingUnit::where('current_quantity', '!=', 0)->get();

		return view('Inventory.item_list', compact('item_lists','categories','sub_categories','counting_units'));
	}

    protected function factoryitemList()
	{
        $item_lists =  FactoryItem::whereNull("deleted_at")->orderBy('category_id', 'ASC')->get();

        //$units=CountingUnit::whereNull("deleted_at")->orderBy('id', 'ASC')->get();

		$categories =  Category::whereNull("deleted_at")->where('type_flag',2)->get();


		$sub_categories = SubCategory::where('type_flag',2)->get();

		return view('Inventory.factoryitem_list', compact('item_lists','categories','sub_categories'));
	}

	protected function storeItem(Request $request)
	{

		$validator = Validator::make($request->all(), [
            'item_code' => 'required',
            'item_name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);

        if ($validator->fails()) {

        	alert()->error('Validation Error!');

            return redirect()->back();
        }

        $user_code = $request->session()->get('user')->user_code;

        if (isset($request->customer_console)) {

        	$customer_console = 0;   //Customer ko pya mar
        }else{

        	$customer_console = 1;	//Customer ko ma pya
        }

        if ($request->hasfile('photo_path')) {

			$image = $request->file('photo_path');

			$name = $image->getClientOriginalName();

			$photo_path =  time()."-".$name;

			$image->move(public_path() . '/photo/Item', $photo_path);
		}
		else{

			$photo_path = "default.jpg";

		}

        // try {

            $item = Item::create([
                'item_code' => $request->item_code,
                'item_name' => $request->item_name,
                'created_by' => $user_code,
                'photo_path' => $photo_path,
                'customer_console' => $customer_console,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
            ]);

        // } catch (\Exception $e) {

        //     alert()->error('Something Wrong! When Creating Item.');

        //     return redirect()->back();
        // }

        alert()->success('Successfully Added');

        return redirect()->route('item_list');
	}

    protected function storeFactoryItem(Request $request)
	{

		$validator = Validator::make($request->all(), [
            'item_code' => 'required',
            'item_name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'purchase_price' => 'required',
            'instock_qty' => 'required',
        ]);

        if ($validator->fails()) {

        	alert()->error('Validation Error!');

            return redirect()->back();
        }

        $user_code = $request->session()->get('user')->user_code;

        // if (isset($request->customer_console)) {

        // 	$customer_console = 0;   //Customer ko pya mar
        // }else{

        // 	$customer_console = 1;	//Customer ko ma pya
        // }

        // if ($request->hasfile('photo_path')) {

		// 	$image = $request->file('photo_path');

		// 	$name = $image->getClientOriginalName();

		// 	$photo_path =  time()."-".$name;

		// 	$image->move(public_path() . '/photo/Item', $photo_path);
		// }
		// else{

		// 	$photo_path = "default.jpg";

		// }

        try {

            $item = FactoryItem::create([
                'item_code' => $request->item_code,
                'item_name' => $request->item_name,
                'created_by' => $user_code,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->sub_category_id,
                'purchase_price' => $request->purchase_price,
                'instock_qty' => $request->instock_qty
            ]);
            // if($item !=null){
            //     $item->froms()->attach(1);
            // }

        } catch (\Exception $e) {

            alert()->error('Something Wrong! When Creating Item.');

            return redirect()->back();
        }

        alert()->success('Successfully Added');

        return redirect()->route('factoryitem_list');
	}

    protected function updateItem($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_code' => 'required',
            'item_name' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong!');

            return redirect()->back();
        }

        try {

            $item = Item::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Item Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        if ($request->hasfile('photo_path')) {

            $image = $request->file('photo_path');

            $name = $image->getClientOriginalName();

            $photo_path =  time()."-".$name;

            $image->move(public_path() . '/photo/Item', $photo_path);
        }else{

            $photo_path = $item->photo_path;
        }


        $item->item_code = $request->item_code;

        $item->item_name = $request->item_name;

        $item->category_id = $request->category_id;

        $item->sub_category_id = $request->sub_category_id;

        $item->photo_path = $photo_path;

        $item->save();

        alert()->success('Successfully Updated!');

        return redirect()->back();
    }

    protected function deleteItem(Request $request)
    {
        $id = $request->item_id;

        $item = Item::find($id);

        $counting_units = CountingUnit::where('item_id', $item->id)->get();

        foreach ($counting_units as $unit) {

            $unit->delete();
        }

        $item->delete();

        return response()->json($item);
    }

	protected function getUnitList($item_id)
    {

		$units = CountingUnit::where('item_id', $item_id)->whereNull("deleted_at")->get();

        try {

        	$item = Item::findOrFail($item_id);

   		} catch (\Exception $e) {

        	alert()->error("Item Not Found!")->persistent("Close!");

            return redirect()->back();
    	}

    	return view('Inventory.unit_list', compact('units','item'));
	}

	protected function storeUnit(Request $request)
    {
//        return $request;
		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'current_qty' => 'required',
            'reorder_qty' => 'required',
            'purchase_price' => 'required',
            'order_price' => 'required',
            'item_id'=>'required',
            'design_id'=>'required',
            'fabric_id'=>'required',
            'colour_id'=>'required',
            'size_id'=>'required',
            'gender_id'=>'required'
        ]);

        $counting_unit = new CountingUnit;
        $counting_unit->unit_name = $request->name;
        $counting_unit->current_quantity = $request->current_qty;
        $counting_unit->reorder_quantity = $request->reorder_qty;
        $counting_unit->purchase_price = $request->purchase_price;
        $counting_unit->order_price = $request->order_price;
        $counting_unit->item_id = $request->item_id;
        $counting_unit->order_fixed_flash= $request->order_fixed ?? 0;
        $counting_unit->order_fixed_percent= $request->order_fixed ? $request->order_percent : 0;
        $counting_unit->design_id=$request->design_id;
        $counting_unit->fabric_id=$request->fabric_id;
        $counting_unit->colour_id=$request->colour_id;
        $counting_unit->size_id=$request->size_id;
        $counting_unit->gender_id=$request->gender_id;
        $counting_unit->save();

        if ($counting_unit !== null){
            $stock = Stockcount::updateOrCreate([
                'counting_unit_id'=> $counting_unit->id,
                'from_id'=> 1,
                'stock_qty'=>$request->current_qty,
            ]);
        }

//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
//        try {
//
//            $counting_unit = CountingUnit::create([
//                'unit_name' => $request->name,
//                'current_quantity' => $request->current_qty,
//                'reorder_quantity' => $request->reorder_qty,
//                'normal_sale_price' => $request->normal_price,
//                'whole_sale_price' => $request->whole_price,
//                'purchase_price' => $request->purchase_price,
//                'order_price' => $request->order_price,
//                'item_id' => $request->item_id,
//                "order_fixed_flash"=> $request->order_fixed ?? 0,
//                "order_fixed_percent"=> $request->order_fixed ? $request->order_percent : 0,
//                "design_id"=>$request->design_id,
//                "fabric_id"=>$request->fabric_id,
//                "colour_id"=>$request->colour_id,
//                "size_id"=>$request->size_id,
//                'gender_id'=>$request->gender_id
//            ]);
//
//        }
//        catch (\Exception $e) {
//
////            alert()->error('Something Wrong! When Creating Counting Unit.');
//            alert()->error($e);
//
//            return redirect()->back();
//        }

        alert()->success('Successfully Stored!');

        return redirect()->back();
	}

    protected function updateUnit($id,Request $request)
    {
        try {

            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Counting Unit Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        $unit->unit_name = $request->name;
		$unit->current_quantity= $request->current_quantity;
		$unit->reorder_quantity= $request->reorder_quantity;
// 		$unit->normal_sale_price= $request->normal_price;
// 		$unit->whole_sale_price = $request->whole_price;
		$unit->order_price= $request->order_price;
		$unit->purchase_price= $request->purchase_price;
		$unit->order_fixed_flash= $request->order_fixed ?? 0;
        $unit->order_fixed_percent= $request->order_fixed ? $request->order_percent : 0;
        // if(isset($request->normal_fixed_flash)){
        //     $unit->normal_fixed_flash = $request->normal_fixed_flash;
        //     $unit->normal_fixed_percent = $request->normal_fixed_percent;
        // }
        // else{
        //     $unit->normal_fixed_flash = 0;
        //     $unit->normal_fixed_percent = 0;
        // }
        // if(isset($request->whole_fixed_flash)){
        //     $unit->whole_fixed_flash = $request->whole_fixed_flash;
        //     $unit->whole_fixed_percent = $request->whole_fixed_percent;
        // }
        // else{
        //     $unit->whole_fixed_flash = 0;
        //     $unit->whole_fixed_percent = 0;
        // }
        // if(isset($request->order_fixed_flash)){
        //     $unit->order_fixed_flash = $request->order_fixed_flash;
        //     $unit->order_fixed_percent = $request->order_fixed_percent;
        // }
        // else{
        //     $unit->order_fixed_flash = 0;
        //     $unit->order_fixed_percent = 0;

        // }

        $unit->save();

        alert()->success('Successfully Stored!');

        return redirect()->back();
    }

    protected function updateUnitCode($id, Request $request)
    {

        try {

            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Counting Unit Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        $unit->unit_code = $request->code;

        $unit->save();

        alert()->success('Successfully Stored!');

        return redirect()->back();
    }

    public function itemAssign(Request $request)
    {
        $from = session()->get('from');
        $item_lists =  Item::whereNull("deleted_at")->orderBy('category_id', 'ASC')->with('froms')->get();
        $shops= From::all();
		return view('Inventory.item_assign', compact('item_lists','shops'));
    }
    public function itemAssignShop(Request $request)
    {
        $item_lists =  Item::whereNull("deleted_at")->orderBy('category_id', 'ASC')->with('category')->with("sub_category")->with('froms')->get();
        $shops= From::all();
		return response()->json($item_lists) ;
    }
    protected function updateOriginalCode($id, Request $request)
    {
        try {

            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Counting Unit Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        $unit->original_code = $request->code;

        $unit->save();

        alert()->success('Successfully Stored!');

        return redirect()->back();
    }

    public function itemAssignajax(Request $request)
    {
        try{
            $from = From::find($request->from_id);
            $from->items()->sync($request->item_array);
        }
        catch(Exception $exception){
            return response()->json(0);
        }
        $item_array = $request->item_array;
        for($i=0;$i<count($request->item_array);$i++){
            $counting_u= Item::find($item_array[$i])->counting_units;
            foreach($counting_u as $key=>$count){
                $stock = Stockcount::updateOrCreate([
                    'counting_unit_id'=> $count->id,
                    'from_id'=> $request->from_id,
                ]);
            }
        }

        return response()->json(1);
    }
    protected function deleteUnit(Request $request)
    {
        $id = $request->unit_id;

        $unit = CountingUnit::find($id);

        $unit->delete();

        return response()->json($unit);
    }

    protected function unitRelationList($item_id)
    {

        $unit_relation = UnitRelation::where('item_id', $item_id)->get();

        $item = Item::find($item_id);

        $counting_units = CountingUnit::where('item_id', $item_id)->get();

        return view('Inventory.unit_relation', compact('unit_relation','item','counting_units'));

    }

    protected function storeUnitRelation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_unit' => 'required|numeric',
            'to_unit' => 'required|numeric',
            'qty' => 'required|numeric',
        ]);

        if($validator->fails()){

            alert()->error('အချက်အလက် များ မှားယွင်း နေပါသည်။');

            return redirect()->route('unit_relation_list', $request->item_id);
        }

        $unit_relation = UnitRelation::where('item_id', request('item_id'))
            ->where('from_unit', request('from_unit'))
            ->where('to_unit', request('to_unit'))
            ->first();

        $unit_relation_rev = UnitRelation::where('item_id', request('item_id'))
            ->where('from_unit', request('to_unit'))
            ->where('to_unit', request('from_unit'))
            ->first();

        if(!empty($unit_relation) || !empty($unit_relation_rev)){

            alert()->error('This Relation has already Exist!');

            return redirect()->route('unit_relation_list', $request->item_id);

        }else{

            try {

                $unit_relation = UnitRelation::create([
                        "item_id" => $request->item_id,
                        "from_unit" => $request->from_unit,
                        "to_unit" => $request->to_unit,
                        "quantity" => $request->qty,
                ]);

            } catch (\Exception $e) {

                alert()->error('Something Wrong! When Unit Realation.');

                return redirect()->back();
            }

            alert()->success('Successfully Added!');

            return redirect()->route('unit_relation_list', $request->item_id);
        }
    }

    protected function updateUnitRelation($id, Request $request)
    {
        try {

            $category = Category::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Category Not Found!")->persistent("Close!");

            return redirect()->back();

        }
    }

    protected function deleteUnitRelation(Request $request)
    {
        dd("Hello");
    }

    protected function convertUnit($unit_id)
    {

        $unit = UnitRelation::find($unit_id);
        dd($unit);
        return view ('Inventory.unit_convert', compact('unit'));
    }

    protected function ajaxConvertResult(Request $request)
    {

        $unit_id = $request->unit_id;

        $from = $request->from;

        $to = $request->to;

        $qty = $request->qty;

        $unit = UnitRelation::find($unit_id);

        $result_qty_one = $qty * $unit->quantity;

        $from_unit_balance = $unit->to_unit_detail->current_quantity - $qty;

        $to_unit_balance = $unit->from_unit_detail->current_quantity + $result_qty_one;

        $to_unit = CountingUnit::find($request->to);

        $to_unit->current_quantity = $to_unit_balance;

        $to_unit->save();

        $from_unit = CountingUnit::find($request->from);

        $from_unit->current_quantity = $from_unit_balance;

        $from_unit->save();

        $unit_conversion_log = UnitConversion::create([
            "item_id" => $unit->item_id,
            "from_unit_id" => $request->from,
            "from_unit_quantity" => $from_unit_balance,
            "to_unit_id" => $request->to,
            "to_unit_quantity" => $to_unit_balance,
        ]);

        return response()->json([
            'from_unit_quantity' => $from_unit_balance,
            'from_unit' => $from_unit->unit_name,
            'to_unit_quantity' => $to_unit_balance,
            'to_unit' => $to_unit->unit_name,
        ]);

    }

    protected function convertCountUnit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'unit_id' => 'required',
            'result_qty' => 'required',
            'result_unit' => 'required',
            'from_unit_id' => 'required',
            'from_unit_qty' => 'required',
            'to_unit_id' => 'required',
            'to_unit_qty' => 'required',
        ]);

        if($validator->fails()){

            alert()->error('အချက်အလက် များ မှားယွင်း နေပါသည်။');

            return redirect()->back();
        }

        $to_unit = CountingUnit::find($request->to_unit_id);

        $to_unit->current_quantity = $request->to_unit_qty;

        $to_unit->save();

        $from_unit = CountingUnit::find($request->from_unit_id);

        $from_unit->current_quantity = $request->from_unit_qty;

        $from_unit->save();

        $unit_conversion_log = UnitConversion::create([
            "item_id" => $request->item_id,
            "from_unit_id" => $request->from_unit_id,
            "from_unit_quantity" => $request->from_unit_qty,
            "to_unit_id" => $request->to_unit_id,
            "to_unit_quantity" => $request->to_unit_qty,
        ]);


        alert()->success("Successfully Converted!");

        return redirect()->route('count_unit_list', ['item_id' => $request->item_id]);
    }

    protected function AjaxGetItem(Request $request){

        $shop_id = $request->shop_id;

       $items= From::find($shop_id)->items()->with('category')->with('sub_category')->with('counting_units')->with('counting_units.stockcount')->get();

        return response()->json($items);
    }

    protected function AjaxGetCountingUnit(Request $request){

        $unit_id = $request->unit_id;
        $shop_id = $request->shop_id;

        $counting_unit = CountingUnit::where("id",$unit_id)->first();
        return response()->json($counting_unit);
    }
    protected function getunitprice(Request $request){

        $unit_id = $request->unit_id;
        $counting_unit = CountingUnit::findOrfail($request->unit_id);
        return response()->json($counting_unit);
    }

    public function itemSearch(Request $request){
//        dd($request->category_id);

        return response()->json($request->category_id);
    }




}
