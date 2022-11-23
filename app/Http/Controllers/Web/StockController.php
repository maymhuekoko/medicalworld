<?php

namespace App\Http\Controllers\Web;

use App\From;
use App\Category;
use App\SubCategory;
use App\FactoryItem;
use App\Purchase;
use App\Itemadjust;
use App\Stockcount;
use App\FabricCount;
use App\FabricEntryItem;
use App\Item;
use App\CountingUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;
use DateTime;
use App\Imports\FabricCountImport;
use App\Imports\FabricEntryImport;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    protected function getStockPanel()
    {
    	return view('Stock.stock_panel');
    }

    public function viewResetQuantity()
    {
        $items = Item::where("category_id",1)->where("sub_category_id",2)->get();
        $item_ids=[];

        foreach ($items as $item){
            array_push($item_ids,$item->id);
        }
        $counting_units = CountingUnit::whereIn('item_id',$item_ids)->get();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $shop = From::find(1);

    	return view('Sale.reset_quantity_page', compact('counting_units','shop','categories','sub_categories'));
    }


    public function viewProductFlagPage()
    {
    
        $items = Item::where("category_id",1)->where("sub_category_id",7)->get();
        $item_ids=[];

        foreach ($items as $item){
            array_push($item_ids,$item->id);
        }

        $counting_units = Item::all();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $shop = From::find(1);

    	return view('Admin.products_flag', compact('counting_units','shop','categories','sub_categories'));
    }

    public function viewProductQtyPage()
    {
    
        $items = Item::where("category_id",1)->where("sub_category_id",7)->get();
        $item_ids=[];

        foreach ($items as $item){
            array_push($item_ids,$item->id);
        }

        $counting_units = Item::all();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $shop = From::find(1);

    	return view('Admin.products_quantity', compact('counting_units','shop','categories','sub_categories'));
    }

    protected function getStockCountPage(Request $request)
    {

        $role= $request->session()->get('user')->role;
        if($role=='Sale_Person'){
            $item_from= $request->session()->get('user')->from_id;
      }
      else {
        $item_from= $request->session()->get('from');
      }
    //   $items= From::find($item_from)->items()->with('category')->with('sub_category')->with('counting_units')->get();

        $items = Item::where("category_id",1)->where("sub_category_id",2)->get();
        $item_ids=[];
        //$counting_units=[];
        foreach ($items as $item){
            array_push($item_ids,$item->id);
        }
        $counting_units = CountingUnit::whereIn('item_id',$item_ids)->get();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $shop = From::find(1);
        //$data = '';
        // if ($request->ajax()) {

        //     foreach ($items as $item) {
        //         $data.= '<tr>
        //                     <td>
        //                         <div class="col-6 form-check form-switch">
        //                             <input class="form-check-input text-center" name="assign_check" type="checkbox" value="$item->id" id="assign_check$item->id">
        //                             <label class="form-check-label" for="assign_check$item->id"></label>
        //                         </div>
        //                     </td>
        //                     <td class="text-center">'.$item->unit_code.'</td>
        //                     <td>'.$item->unit_name.'</td>
        //                     <td>
        //                         <input type="number" class="form-control w-50 stockinput text-black" data-stockinputid="stockinput'.$item->id.'" id="stockinput'.$item->id.'" data-id="'.$item->id.'"value="'.$item->current_quantity.'">
        //                     </td>
        //                     <td>
        //                         <input type="number" class="form-control w-50 priceinput text-black" data-priceinputid="priceinput'.$item->id.'" id="priceinput'.$item->id.'" data-id="'.$item->id.'"value="'.$item->order_price.'">
        //                     </td>
        //                     <td>'.$item->reorder_quantity.'</td>

        //                     <td class="text-center">
        //                         <div class="d-flex align-items-center">
        //                             <a href="#" class="btn btn-sm btn-outline-warning unitupdate mx-2"
        //                             data-unitid="'.$item->id.'" data-code="'.$item->unit_code.'" data-unitname="'.$item->unit_name.'"
        //                                 >
        //                                 <i class="fas fa-edit"></i>
        //                             </a>
        //                             <button class="btn btn-sm btn-outline-danger delete_stock" data-id="'.$item->id.'">
        //                                 <i class="fas fa-trash-alt"></i>
        //                             </button>
        //                         </div>
        //                     </td>
        //                         </tr>';
        //     }
        //     return $data;
        // }
    	return view('Stock.stock_count_page', compact('counting_units','shop','categories','sub_categories'));
    }
    
    protected function getFabricCountPage(Request $request)
    {
        $fabric_entry_items = FabricEntryItem::all();
        $categories = Category::where('type_flag',2)->get();
        $sub_categories = SubCategory::where('type_flag',2)->get();
        $factory_items = FactoryItem::where('category_id',9)->where('subcategory_id',19)->get();
        
    	return view('Stock.fabric_count_page', compact('fabric_entry_items','categories','sub_categories','factory_items'));
    }
    
    public function itemSearch(Request $request){
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        ini_set('max_execution_time',300);
//        return $request;
        $items = FactoryItem::where("category_id",$category_id)->where("subcategory_id",$subcategory_id)->get();
        
        return response()->json($items);
    }
    
    protected function storeFabricEntry(Request $request)
	{

		$validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'instock_qty' => 'required',
            'entry_flag' => 'required',
            'count_date' => 'required',
        ]);

        if ($validator->fails()) {

        	alert()->error('Validation Error!');

            return redirect()->back();
        }

        $factoryitem = FactoryItem::find($request->item_id);
        
        try {

            $item = FabricEntryItem::create([
                'factory_item_id' => $request->item_id,
                'factory_item_name' => $factoryitem->item_name,
                'instock_qty' => $request->instock_qty
            ]);
            
            if($request->entry_flag == 1){
                $entry = FabricCount::create([
                'factory_item_id' => $request->item_id,
                'factory_item_name' => $factoryitem->item_name,
                'count_date' => $request->count_date,
                'open_stock' => $request->instock_qty,
                'in_stock' => 0,
                'out_stock' => 0,
                'close_stock' => $request->instock_qty,
                'remark' => ''
            ]);
            }

        } catch (\Exception $e) {

            alert()->error('Something Wrong! When Creating Item.');

            return redirect()->back();
        }

        alert()->success('Successfully Added');

        return redirect()->route('fabric_count');
	}

    protected function itemadjust(Request $request)
    {

        $role= $request->session()->get('user')->role;
        if($role=='Sale_Person'){

            $item_from= $request->session()->get('user')->from_id;

      }
      else {
        $item_from= $request->session()->get('from');
      }
       $items= From::find($item_from)->items()->with('category')->with('sub_category')->with('counting_units')->with('counting_units.stockcount')->get();

        $shops = From::all();
    	return view('Itemadjust.create_itemadjust', compact('items','shops'));
    }

    protected function getstocklists(Request $request)
    {
        $counting_units = CountingUnit::where('current_quantity', '!=', 0)->get();
    	return view('Stock.stock_lists', compact('counting_units'));
    }

    protected function getStockPricePage()
    {
        $units = CountingUnit::with('item')->whereNull('deleted_at')->orderBy('item_id', 'asc')->get();

    	return view('Stock.stock_price_page', compact('units'));
    }

    protected function getStockReorderPage(Request $request)
    {
        
       $items = Item::where("category_id",1)->where("sub_category_id",2)->get();
        $item_ids=[];
        //$counting_units=[];
        foreach ($items as $item){
            array_push($item_ids,$item->id);
        }
        $counting_units = CountingUnit::whereIn('item_id',$item_ids)->get();
        $categories = Category::all();
        $sub_categories = SubCategory::all();

        
    	return view('Stock.reorder_page', compact('items','counting_units','categories','sub_categories'));
    }

    protected function updateStockCount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'unit_code' => 'required',
            'unit_name' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

        $id = $request->unit_id;

        try {

            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Counting Unit Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        $unit->unit_code = $request->unit_code;

        $unit->unit_name = $request->unit_name;

        $unit->save();

        alert()->success('Successfully Updated!');

        return redirect()->back();
    }

    protected function updateStockPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'purchase_price' => 'required',
            'normal_sale_price' => 'required',
            'whole_sale_price' => 'required',
            'order_price' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

        $id = $request->unit_id;

        try {

            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {

            alert()->error("Counting Unit Not Found!")->persistent("Close!");

            return redirect()->back();

        }

        $unit->purchase_price = $request->purchase_price;

        $unit->normal_sale_price = $request->normal_sale_price;

        $unit->whole_sale_price = $request->whole_sale_price;

        $unit->order_price = $request->order_price;

        $unit->save();

        alert()->success('Successfully Updated!');

        return redirect()->back();
    }
    public function stockUpdateAjax(Request $request)
    {
        $date = new DateTime('Asia/Yangon');
        $current_date = $date->format('Y-m-d');

        $countingUnit = CountingUnit::findOrFail($request->unit_id);
        $oldstock_qty = $countingUnit->current_quantity;
        $adjust_qty = abs($countingUnit->current_quantity - $request->stock_qty);
        $countingUnit->current_quantity = $request->stock_qty;
        $countingUnit->save();


        if($countingUnit){
            $itemadjust = Itemadjust::create([
                    'counting_unit_id' => $countingUnit->id,
                    'oldstock_qty' => $oldstock_qty,
                    'adjust_qty' => $adjust_qty,
                    'newstock_qty' => $request->stock_qty,
                    'from_id' => 1,
                    'user_id' => $request->session()->get('user')->id,
                    'adjust_date' => $current_date,
                    'adjust_remark' => $request->remark
                ]);
            return response()->json($countingUnit);
        }
        else{
            return response()->json(0);
        }
    }


    public function salepriceUpdateAjax(Request $request)
    {
        $countingUnit = CountingUnit::findOrFail($request->unit_id);
        $countingUnit->order_price = $request->order_price;
        $countingUnit->save();

        if($countingUnit){
            return response()->json($countingUnit);
        }
        else{
            return response()->json(0);
        }
    }

    public function resetquantityUpdateAjax(Request $request)
    {
        $countingUnit = CountingUnit::findOrFail($request->unit_id);
        $countingUnit->reset_quantity = $request->reset_quantity;
        $countingUnit->save();

        if($countingUnit){
            return response()->json($countingUnit);
        }
        else{
            return response()->json(0);
        }
    }

    public function newarrCheckOnAjax(Request $request)
    {
        $item = Item::findOrFail($request->unit_id);
        $item->new_product_flag = $request->chek_value;
        $item->save();

        if($item){
            return response()->json($item);
        }
        else{
            return response()->json(0);
        }
    }

    public function setDateAjax(Request $request) {
        $item = Item::findOrFail($request->unit_id);
        $item->arrival_date = $request->arr_date;
        $item->save();

        if($item){
            return response()->json($item);
        }
        else{
            return response()->json(0);
        }
    }

    public function setPriceAjax(Request $request) {
        $item = Item::findOrFail($request->unit_id);
        $item->discount_price = $request->dis_price;
        $item->save();

        if($item){
            return response()->json($item);
        }
        else{
            return response()->json(0);
        }
    }

    public function promoCheckOnAjax(Request $request)
    {
        $item = Item::findOrFail($request->unit_id);
        $item->promotion_product_flag = $request->chek_value;
        $item->save();

        if($item){
            return response()->json($item);
        }
        else{
            return response()->json(0);
        }
    }

    public function hotCheckOnAjax(Request $request)
    {
        $item = Item::findOrFail($request->unit_id);
        $item->hotsale_product_flag = $request->chek_value;
        $item->save();

        if($item){
            return response()->json($item);
        }
        else{
            return response()->json(0);
        }
    }

    public function setInstockAjax(Request $request)
    {
        $item = Item::findOrFail($request->unit_id);
        $item->instock = $request->qty_value;
        $item->save();

        if($item){
            return response()->json($item);
        }
        else{
            return response()->json(0);
        }
    }

    public function setPreorderAjax(Request $request)
    {
        $item = Item::findOrFail($request->unit_id);
        $item->preorder = $request->qty_value;
        $item->save();

        if($item){
            return response()->json($item);
        }
        else{
            return response()->json(0);
        }
    }

    public function uploadPhotos(Request $request) {
          
        foreach ($request->file('photos') as $imagefile) 
        {
            $photoName = $imagefile->getClientOriginalName();
            $imagefile->move(public_path('/ecommerce/items/'), $photoName);
        }

        Item::where('id', $request->unit_id)->update([
            'photo_path' => $request->photo_path,
        ]);
        
        return redirect()->back()->with('success', 'Product photos uploaded successfully!'); 
    }

    public function purchasepriceUpdateAjax(Request $request)
    {

        $countingUnit = CountingUnit::findOrFail($request->unit_id);
        $countingUnit->purchase_price = $request->purchase_price;
        $countingUnit->save();

        if($countingUnit){
            return response()->json($countingUnit);
        }
        else{
            return response()->json(0);
        }
    }

    public function purchaseUpdateAjax(Request $request)
    {
        $purchase = Purchase::findOrfail($request->purchase_id);

        $diff_qty = $request->new_qty - $request->olderqty;

        $unit = DB::table('counting_unit_purchase')->where('counting_unit_id', $request->unit_id)->where('purchase_id',$request->purchase_id)->update(['quantity' => $request->new_qty]);


        $unit_first = DB::table('counting_unit_purchase')->where('counting_unit_id', $request->unit_id)->where('purchase_id',$request->purchase_id)->first();

        // $unit->quantity = $diff_qty;

        $diff_total= ($diff_qty) * $unit_first->price;

        $purchase_new_total = $purchase->total_price + ($diff_total);

        try {

            $purchase->total_price = $purchase_new_total;
            $purchase->save();

        } catch (Exception $e) {
            return response()->json(0);
        }

        try {
            $update_stock = Stockcount::where('counting_unit_id',$request->unit_id)->where('from_id',1)->first();

        } catch (Exception $e) {
            return response()->json(0);

        }

        $balanced_qty = $update_stock->stock_qty + ($diff_qty);

        $update_stock->stock_qty= $balanced_qty;

        $update_stock->save();

        return response()->json($update_stock);

    }
    
    
    protected function saveFabricCount(Request $request){
         
        
        $items = json_decode($request->items);
        
        $entry_format_date = date('Y-m-d', strtotime($request->entry_date));
        $item_ids = [];
        
        try{
            
            
            $fabric_entries = FabricCount::where('count_date',$entry_format_date)->get();
            foreach($fabric_entries as $entry){
                array_push($item_ids,$entry->factory_item_id);
            }
            
            foreach ($items as $item) {
                if(in_array($item->id,$item_ids)){
                    $fabric_entry = FabricCount::where('factory_item_id',$item->id)->where('count_date',$entry_format_date)->first();
                    $fabric_entry->open_stock = $item->open_stock;
                    $fabric_entry->in_stock = $item->in_stock;
                    $fabric_entry->out_stock = $item->out_stock;
                    $fabric_entry->close_stock = $item->close_stock;
                    $fabric_entry->remark = $item->remark;
                    $fabric_entry->save();
                }else{
                $fabricCount= new FabricCount();
                $fabricCount->factory_item_id = $item->id;
                $fabricCount->factory_item_name = $item->item_name;
                $fabricCount->count_date = $entry_format_date;
                $fabricCount->open_stock = $item->open_stock;
                $fabricCount->in_stock = $item->in_stock;
                $fabricCount->out_stock = $item->out_stock;
                $fabricCount->close_stock = $item->close_stock;
                $fabricCount->remark = $item->remark;
                $fabricCount->save();
                }
                
            }
        //     $fabricCount = FabricCount::create([
        //     "factory_item_id" => 1,
        //     "factory_item_name" => 'test',
        //     "open_stock" => 0,
        //     "in_stock" => 0,
        //     "out_stock" => 0,
        //     "close_stock" => 0,
        //     "remark" => '',
        // ]);
        }catch (\Exception $e) {

            return response()->json([$e], 404);
//            return response()->json(['error' => 'Something Wrong! When Store Customer Order'], 404);

        }
        
         return response()->json($items);
    }
    
    protected function saveArriveFabric(Request $request){
         
        
        $items = json_decode($request->arrivedItems);
        
        $arrive_format_date = date('Y-m-d', strtotime($request->arrive_date));
        $arrive_remark = $request->arrive_remark;
        $purchase = Purchase::find($request->purchase_id);
        
        $item_ids = [];
        $entry_ids = [];
        try{
            
            $existing_entries = FabricEntryItem::all();
            foreach($existing_entries as $entry){
                array_push($entry_ids,$entry->factory_item_id);
            }
            
            
            $fabric_entries = FabricCount::where('count_date',$arrive_format_date)->get();
            foreach($fabric_entries as $entry){
                array_push($item_ids,$entry->factory_item_id);
            }
            
            foreach ($items as $item) {
                
                if(!in_array($item->id,$entry_ids)){
                    $entry_item = FabricEntryItem::create([
                        'factory_item_id' => $item->id,
                        'factory_item_name' => $item->name,
                        'instock_qty' => $item->arrive_qty
                    ]);
                }
                
                if(in_array($item->id,$item_ids)){
                    $fabric_entry = FabricCount::where('factory_item_id',$item->id)->where('count_date',$arrive_format_date)->first();
                    
                    $fabric_entry->in_stock += $item->arrive_qty;
                    
                    $fabric_entry->close_stock += $item->arrive_qty;
                    $fabric_entry->remark = $arrive_remark;
                    $fabric_entry->save();
                }else{
                $fabricCount= new FabricCount();
                $fabricCount->factory_item_id = $item->id;
                $fabricCount->factory_item_name = $item->name;
                $fabricCount->count_date = $arrive_format_date;
                $fabricCount->open_stock = 0;
                $fabricCount->in_stock = $item->arrive_qty;
                $fabricCount->out_stock = 0;
                $fabricCount->close_stock = $item->arrive_qty;
                $fabricCount->remark = $arrive_remark;
                $fabricCount->save();
                }
                
                $purchase->factory_item()->updateExistingPivot($item->id,['arrive_quantity' => $item->arrive_qty,'arrive_complete' => $item->arrive_complete]);
                
            }
        //     $fabricCount = FabricCount::create([
        //     "factory_item_id" => 1,
        //     "factory_item_name" => 'test',
        //     "open_stock" => 0,
        //     "in_stock" => 0,
        //     "out_stock" => 0,
        //     "close_stock" => 0,
        //     "remark" => '',
        // ]);
        }catch (\Exception $e) {

            return response()->json([$e], 404);
//            return response()->json(['error' => 'Something Wrong! When Store Customer Order'], 404);

        }
        
         return response()->json($items);
    }
    
    protected function search_fabric_entry(Request $request){

        
        $fabric_entries = FabricCount::where('count_date', $request->entry_date)->get();
        
        return response()->json($fabric_entries);
    }
    
    protected function get_fabricentry_item(Request $request){

        
        $fabric_entry_item = FabricCount::where('count_date', $request->entry_date)->where('factory_item_id',$request->item_id)->first();
        
        return response()->json($fabric_entry_item);
    }
    
    public function fabricCountImport(Request $request)
    {
        $counts = Excel::import(new FabricCountImport(),$request->file(('import_file')));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }
    
    public function fabricEntryImport(Request $request)
    {
        $entries = Excel::import(new FabricEntryImport(),$request->file(('import_file')));
        alert()->success('Excel Import Succeeded');
        return redirect()->back();
    }
    
    
    public function itemadjustLists(Request $request)
    {
        $date = new DateTime('Asia/Yangon');
        $current_date = $date->format('Y-m-d');

        $item_adjusts =  Itemadjust::where('adjust_date',$current_date)->get();

        return view('Itemadjust.itemadjust',compact('item_adjusts','current_date'));
    }
    
    public function search_itemadjust(Request $request)
    {
    
        $item_adjusts =  Itemadjust::whereBetween('adjust_date',[$request->from,$request->to])->with('counting_unit')->with('user')->get();

        return response()->json($item_adjusts);
    }
    
    public function itemadjustAjax(Request $request)
    {
        $userid = session()->get('user')->id;
        if($request->plusminus == 'plus'){
            $balanced_qty = (int)$request->currentqty + (int) $request->adjust_qty;
            $adjust_qty = $request->adjust_qty;
        }
        elseif($request->plusminus == 'minus'){

            $balanced_qty = (int)$request->currentqty - (int) $request->adjust_qty;
            $adjust_qty = -$request->adjust_qty;


        }
        $stock = Stockcount::updateOrCreate([
            'counting_unit_id'=> $request->unit_id,
            'from_id'=> $request->shop_id,
        ],
        [
            'stock_qty' => $balanced_qty,
        ]
        );

        $item_adjust = Itemadjust::create([
            "counting_unit_id" => $request->unit_id,
            "oldstock_qty" => $request->currentqty,
            "adjust_qty" => $adjust_qty,
            "newstock_qty" => $balanced_qty,
            "from_id" => $request->shop_id,
            "user_id" => $userid
        ]);

        if($stock){
            return response()->json($stock);
        }
        else{
            return response()->json(0);
        }
    }

    public function stockSearch(Request $request){
        $search_key = $request->stock_count_search;
        $search_items = CountingUnit::where("unit_code","LIKE","%$search_key%")->get();
        return view('Stock.stock_count_page', compact('search_items'));
    }
}
