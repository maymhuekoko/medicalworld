<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductFlagController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('localization/{locale}','LocalizationController@index');

Route::get('/', 'Web\LoginController@index')->name('index');

Route::post('Authenticate', 'Web\LoginController@loginProcess')->name('loginProcess');

Route::get('LogoutProcess', 'Web\LoginController@logoutProcess')->name('logoutprocess');

Route::get('email_marketing', 'MailController@MailMarketingForm')->name('email_marketing');

Route::post('sendingemail', 'MailController@SendingMail');

Route::get('products_flag', 'Web\StockController@viewProductFlagPage')->name('products_flag');

Route::get('reset_quantity', 'Web\StockController@viewResetQuantity')->name('reset_quantity');

Route::group(['middleware' => ['UserAuth']], function () {
    Route::post('shopname/edit', 'Web\AdminController@shopnameEdit')->name('shopnameEdit');

    Route::get('ChangePassword-UI', 'Web\LoginController@getChangePasswordPage')->name('change_password_ui');
    Route::put('UpdatePassword', 'Web\LoginController@updatePassword')->name('update_pw');

    //Dashboard List
    Route::get('Inventory-Dashboard', 'Web\InventoryController@getInventoryDashboard')->name('inven_dashboard');
    Route::get('Stock-Dashboard', 'Web\StockController@getStockPanel')->name('stock_dashboard');
    Route::get('Sale-Dashboard', 'Web\SaleController@getSalePanel')->name('sale_panel');
    Route::get('Order-Dashboard', 'Web\OrderController@getOrderPanel')->name('order_panel');
    Route::get('Admin-Dashboard','Web\AdminController@getAdminDashboard')->name('admin_dashboard');

    //Ajax List
    Route::post('AjaxGetItem', 'Web\InventoryController@AjaxGetItem')->name('AjaxGetItem');
    Route::post('AjaxGetCountingUnit', 'Web\InventoryController@AjaxGetCountingUnit')->name('AjaxGetCountingUnit');
    Route::post('getunitprice', 'Web\InventoryController@getunitprice')->name('getunitprice');
    Route::post('getCountingUnitsByItemId', 'Web\SaleController@getCountingUnitsByItemId');
    Route::post('getCountingUnitsByItemCode', 'Web\SaleController@getCountingUnitsByItemCode');
    Route::post('getCustomerInfo', 'Web\AdminController@getCustomerInfo');
    Route::post('ajaxConvertResult', 'Web\InventoryController@ajaxConvertResult');
    Route::post('storeCustomerOrder', 'Web\OrderController@storeCustomerOrder')->name('storeCustomerOrder');
    Route::post('storeCustomerOrderv2', 'Web\OrderController@storeCustomerOrderv2')->name('storeCustomerOrderv2');
    Route::post('storePurchaseOrder', 'Web\OrderController@storePurchaseOrder');
    Route::post('getTotalSaleReport', 'Web\AdminController@getTotalSaleReport');
    Route::post('getWeek', 'Web\AdminController@getTotalWeek');
    Route::post('getMonth', 'Web\AdminController@getTotalMonth');
    Route::post('getOrderFullfill', 'Web\AdminController@getTotalOrderFulfill');
    Route::post('getCashCollect', 'Web\AdminController@getTotalCashCollect');
    Route::post('getSupplierRepayment', 'Web\AdminController@getTotalSupplierRepayment');
    Route::post('showSubCategory', 'Web\InventoryController@showSubCategory');
    Route::post('AjaxGetCustomerList','Web\AdminController@getSalesCustomerList')->name('AjaxGetCustomerList');
    Route::post('AjaxGetCustomerwID','Web\AdminController@getSalesCustomerWithID')->name('AjaxGetCustomerwID');

    Route::post('AjaxGetOrderCustomerwID','Web\AdminController@getOrderCustomerWithID')->name('AjaxGetOrderCustomerwID');

    Route::post('AjaxStoreCustomer','Web\AdminController@storeSalesCustomer')->name('AjaxStoreCustomer');
    
    Route::post('changePrintStatus','Web\OrderController@changePrintStatus')->name('changePrintStatus');

    Route::post('AjaxStoreOrderCustomer','Web\AdminController@storeOrderCustomer')->name('AjaxStoreOrderCustomer');

    Route::post('changeCustomerPassword', 'Web\AdminController@changeCustomerPassword');
    Route::post('customUnitOrder-store', [\App\Http\Controllers\CustomUnitOrderController::class,'store']);

    Route::post('saleCustomerDelete','SaleCustomerController@delete')->name('saleCustomerDelete');

    Route::post('orderCustomerDelete','AdminController@deleteOrderCustomer')->name('orderCustomerDelete');

    Route::get('salescustomers_list','Web\AdminController@show_sale_customer_credit_list')->name('salescustomers_list');
    Route::post('collect_salescustomer_data','Web\AdminController@collect_salescustomer_data')->name('collect_salescustomer_data');
    
    Route::get('ordercustomers_list','Web\AdminController@show_order_customer_list')->name('ordercustomers_list');
    Route::post('collect_ordercustomer_data','Web\AdminController@collect_ordercustomer_data')->name('collect_ordercustomer_data');

    //Route::get('Sale/shistory','Web\AdminController@history')->name('shistory');
    Route::get('credit/{id}','Web\AdminController@credit')->name('credit');
    Route::post('store_each_paid','Web\AdminController@store_eachPaid')->name('store_each_paid');
    Route::post('store_all_credit/{id}','Web\AdminController@store_allPaid')->name('store_all_credit');


    //Category

	Route::post('category/store', 'Web\InventoryController@storeCategory')->name('category_store');
	Route::post('category/update/{id}', 'Web\InventoryController@updateCategory')->name('category_update');
    Route::post('category/delete', 'Web\InventoryController@deleteCategory');
    Route::get('category', 'Web\InventoryController@categoryList')->name('category_list');

	//SubCategory
	Route::get('subcategory', 'Web\InventoryController@subcategoryList')->name('subcategory_list');
	Route::post('subcategory/store', 'Web\InventoryController@storeSubCategory')->name('sub_category_store');
	Route::post('subcategory/update/{id}', 'Web\InventoryController@updateSubCategory')->name('sub_category_update');


    //Item
	Route::get('item', 'Web\InventoryController@itemList')->name('item_list');
    Route::get('factoryitem', 'Web\InventoryController@factoryitemList')->name('factoryitem_list');
	Route::post('item/store', 'Web\InventoryController@storeItem')->name('item_store');
    Route::post('factoryitem/store', 'Web\InventoryController@storeFactoryItem')->name('factoryitem_store');
	Route::post('item/update/{id}', 'Web\InventoryController@updateItem')->name('item_update');
	Route::post('item/delete', 'Web\InventoryController@deleteItem');
    Route::post('search_item','Web\InventoryController@itemSearch')->name('search_item');

    //Counting Unit
	Route::get('Count-Unit/{item_id}', 'Web\InventoryController@getUnitList')->name('count_unit_list');
    Route::post('Count-Unit/store', 'Web\InventoryController@storeUnit')->name('count_unit_store');
    Route::post('Count-Unit/update/{id}', 'Web\InventoryController@updateUnit')->name('count_unit_update');
    Route::post('Count-Unit/code_update/{id}', 'Web\InventoryController@updateUnitCode')->name('count_unit_code_update');
    Route::post('Count-Unit/original_code_update/{id}', 'Web\InventoryController@updateOriginalCode')->name('original_code_update');
    Route::post('Count-Unit/delete', 'Web\InventoryController@deleteUnit');

    //Counting Unit Relation
    Route::get('Unit-Relation/{item_id}', 'Web\InventoryController@unitRelationList')->name('unit_relation_list');
    Route::post('Unit-Relation/store', 'Web\InventoryController@storeUnitRelation')->name('unit_relation_store');
    Route::post('Unit-Relation/update/{id}', 'Web\InventoryController@updateUnitRelation')->name('unit_relation_update');

    //Counting Unit Conversion
    Route::get('Unit-Convert/{unit_id}', 'Web\InventoryController@convertUnit')->name('convert_unit');
    //Route::post('Unit-Convert/store', 'Web\InventoryController@convertCountUnit')->name('convert_count_unit');

    //item adjust
    Route::get('item-adjust', 'Web\StockController@itemadjust')->name('itemadjust');

    //StockCount
    Route::get('Stock-Count/Count', 'Web\StockController@getStockCountPage')->name('stock_count');
    Route::get('Fabric-Count/Count', 'Web\StockController@getFabricCountPage')->name('fabric_count');
    Route::get('stocklists', 'Web\StockController@getstocklists')->name('stock_lists');
    Route::get('Stock-Count/Price', 'Web\StockController@getStockPricePage')->name('stock_price_page');
    Route::get('Stock-Count/Reorder', 'Web\StockController@getStockReorderPage')->name('stock_reorder_page');
    Route::post('Stock-Count/UpdateCount', 'Web\StockController@updateStockCount')->name('update_stock_count');
    Route::post('Stock-Count/UpdatePrice', 'Web\StockController@updateStockPrice')->name('update_stock_price');
    Route::get('stock-search','Web\StockController@stockSearch')->name('stock_search');
    Route::post('saveFabricCount', 'Web\StockController@saveFabricCount')->name('saveFabricCount');
    Route::post('saveArriveFabric', 'Web\StockController@saveArriveFabric')->name('saveArriveFabric');
    Route::post('fabricEntry/newsearch', 'Web\StockController@search_fabric_entry')->name('search_fabric_entry');
    Route::post('fabricEntry/itemsearch', 'Web\StockController@get_fabricentry_item')->name('get_fabricentry_item');
    Route::post('attachmentimage', 'Web\OrderController@attachimg')->name('attachimg');
    Route::post('/fabricCountImport',"Web\StockController@fabricCountImport")->name('fabricCountImport');
    
    Route::post('/fabricEntryImport',"Web\StockController@fabricEntryImport")->name('fabricEntryImport');
    
    Route::post('item_search','Web\StockController@itemSearch')->name('item_search');
    Route::post('fabricentry/store', 'Web\StockController@storeFabricEntry')->name('fabricentry_store');

    //Employee
    Route::get('Employee', 'Web\AdminController@getEmployeeList')->name('employee_list');
    Route::post('Employee/store', 'Web\AdminController@storeEmployee')->name('employee_store');
    Route::get('Employee/details/{id}', 'Web\AdminController@getEmployeeDetails')->name('employee_details');
    Route::post('employee-update', 'Web\AdminController@employeeupdate')->name('employee.update');

    //Customer
    Route::get('Customer', 'Web\AdminController@getCustomerList')->name('customer_list');
    Route::post('Customer/store', 'Web\AdminController@storeCustomer')->name('store_customer');
    Route::get('Customer/details/{id}', 'Web\AdminController@getCustomerDetails')->name('customer_details');
    Route::post('Customer/update/{id}', 'Web\AdminController@updateCustomer')->name('customer_update');
    Route::post('Customer/Change-Level', 'Web\AdminController@changeCustomerLevel')->name('change_customer_level');

    //Sale
    Route::get('Sale', 'Web\SaleController@getSalePage')->name('sale_page');
    Route::post('Sale/Voucher', 'Web\SaleController@storeVoucher');
    Route::post('Sale/Get-Voucher', 'Web\SaleController@getVucherPage')->name('get_voucher');
    Route::get('Sale/History', 'Web\SaleController@getSaleHistoryPage')->name('sale_history');
    Route::get('Sale/SummaryMain','Web\SaleController@getVoucherSummaryMain')->name('voucher_summary_main');
    Route::post('Sale/SummaryDetail','Web\SaleController@searchItemSalesByDate')->name('search_item_sales_by_date');
    Route::post('Sale/Search-History', 'Web\SaleController@searchSaleHistory')->name('search_sale_history');
    Route::post('Sale/Search-HistoryV2', 'Web\SaleController@searchSaleHistoryv2')->name('search_sale_historyv2');

    Route::post('serarch-item-adjusts', 'Web\SaleController@searchItemAdjusts')->name('search_item_adjusts');
    Route::post('voucher-delete', 'Web\SaleController@voucherDelete')->name('voucher_delete');
    Route::get('search-item-adjusts', function () {
        return redirect()->route('itemadjust-lists');
    });
    Route::post('Sale/search_sale_discount_record', 'Web\SaleController@search_sale_discount_record')->name('search_sale_discount_record');
    Route::get('Sale/Voucher-Details/{id}', 'Web\SaleController@getVoucherDetails')->name('getVoucherDetails');
    Route::get('discount_record_list','Web\SaleController@show_discount_list')->name('discount_record_list');
    Route::post('getSelectionDiscount','Web\SaleController@show_discount_type')->name('getSelectionDiscount');
    Route::post('getDateDiscount','Web\SaleController@show_discount_date')->name('getDateDiscount');
    Route::post('get_discount_main_type','Web\SaleController@ajax_get_discount_main')->name('get_discount_main_type');
    Route::post('get_foc','Web\SaleController@ajax_get_foc')->name('get_foc');
    Route::post('get_item','Web\SaleController@ajax_get_item')->name('get_item');
    Route::post('get_vou','Web\SaleController@ajax_get_vou')->name('get_vou');
    Route::post('get_date','Web\SaleController@ajax_get_date')->name('get_date');
    Route::post('unit_search','Web\SaleController@unitSearch')->name('unit_search');
    
    
    Route::post('subcategory_search','Web\SaleController@subcategorySearch')->name('subcategory_search');
    
    Route::post('purchase_category_search','Web\AdminController@purchaseCategorySearch')->name('purchase_category_search');
    
     Route::post('purchase_subcategory_search','Web\AdminController@purchaseSubcategorySearch')->name('purchase_subcategory_search');
     
      Route::post('purchase_unit_search','Web\AdminController@purchaseUnitSearch')->name('purchase_unit_search');
    
    Route::get('SaleCount/{from_date}/{to_date}/{order_type}', 'Web\SaleController@saleCount')->name('saleCount');
    
    //Order
    Route::get('NewOrder', 'Web\OrderController@newOrderPage')->name('neworder_page');
    Route::get('Order/{type}', 'Web\OrderController@getOrderPage')->name('order_page');
    Route::get('Website-Order', 'Web\OrderController@getWebsiteOrder')->name('website_order');
    Route::get('Website-PreOrder', 'Web\OrderController@getWebsitePreOrder')->name('website_preorder');
    Route::get('Website-Order-Details/{id}', 'Web\OrderController@getWebsiteOrderDetailsPage')->name('website_order_details');
    Route::post('WebsiteOrder/ChangeStatus', 'Web\OrderController@changeWebsiteOrderStatus')->name('change_website_order_status');
    Route::get('FactoryPoList', 'Web\OrderController@getFactoryPOPage')->name('factorypo_page');
    Route::get('Order-Details/{id}', 'Web\OrderController@getOrderDetailsPage')->name('order_details');
    Route::post('Order/Change', 'Web\OrderController@changeOrderStatus')->name('update_order_status');
    Route::get('Order-Print/{id}', 'Web\OrderController@getOrderVoucherPrint')->name('order_voucher_print');
    Route::get('Website-Order-Print/{id}', 'Web\OrderController@getWebsiteOrderVoucherPrint')->name('website_order_voucher_print');
    Route::post('PO/Approve', 'Web\OrderController@changePOStatus')->name('update_po_status');
    Route::get('Order/Voucher/History', 'Web\OrderController@getOrderHistoryPage')->name('order_history');
    Route::post('Order/Voucher/Search-History', 'Web\OrderController@searchOrderVoucherHistory')->name('search_order_history');
    
    Route::post('Order/Search-History', 'Web\OrderController@searchOrderHistory')->name('search_ajaxorder_history');
    
    Route::post('FactoryOrder/Search-History', 'Web\OrderController@searchFactoryOrderHistory')->name('search_factoryorder_history');

    Route::get('export-orderhistory/{from}/{to}/{id}/{data_type}/{type}', 'Web\OrderController@orderHistoryExport')->name('orderhistoryexport');
    
    Route::get('export-totalorderhistory/{from}/{to}/{id}/{order_by}/{order_type}/{data_type}/{type}', 'Web\OrderController@totalOrderHistoryExport')->name('totalorderhistoryexport');


    Route::get('Sale/Search-History', 'Web\SaleController@searchSaleHistoryget');
    
    Route::get('export-salehistory/{from}/{to}/{id}/{sales}/{data_type}/{type}', 'Web\SaleController@saleHistoryExport')->name('salehistoryexport');
    
    Route::get('export-receivehistory/{from}/{to}/{id}', 'Web\AdminController@receivableHistoryExport')->name('receivablehistoryexport');
    
    Route::get('export-payhistory/{from}/{to}/{id}', 'Web\AdminController@payableHistoryExport')->name('payablehistoryexport');
    
    Route::get('Order/orderVoucherDetails/{id}', 'Web\OrderController@orderVoucherDetails')->name('orderVoucherDetails');
    
    
     Route::post('order-delete', 'Web\OrderController@orderDelete')->name('order_delete');
    
    Route::get('Order/PO-Details/{id}', 'Web\OrderController@getPoDetails')->name('po_details');

    Route::post('getSpecId','Web\OrderController@getSpecId')->name('getSpecId');
    Route::get('addFactoryOrder/{id}',"Web\OrderController@addFactoryOrder")->name('addFactoryOrder');
//    Factory Order
    Route::get('editFactoryOrder/{id}',"Web\OrderController@editFactoryOrder")->name('editFactoryOrder');
    Route::get('incomingFactoryOrder',"Web\OrderController@incomingFactoryOrder")->name('incomingFactoryOrder');
    Route::get('changeFactoryOrder',"Web\OrderController@changeFactoryOrder")->name('changeFactoryOrder');
    
    Route::get('deliveredFactoryOrder',"Web\OrderController@deliveredFactoryOrder")->name('deliveredFactoryOrder');
    
     Route::post('getIncomingFactoryOrder',"Web\OrderController@getIncomingFactoryOrder")->name('getIncomingFactoryOrder');
     
     Route::post('getDeliveredFactoryOrder',"Web\OrderController@getDeliveredFactoryOrder")->name('getDeliveredFactoryOrder');
//    Factory Order Item
    Route::get('showFactoryOrderItem/{id}',"Web\OrderController@showFactoryOrderItem")->name('showFactoryOrderItem');
    
    Route::get('updateFactoryOrderItem/{id}',"Web\OrderController@updateFactoryOrderItem")->name('updateFactoryOrderItem');
    
    Route::post('saveFactoryItem',"Web\OrderController@saveFactoryItem")->name('saveFactoryItem');
    Route::post('editFactoryItem/{id}',"Web\OrderController@editFactoryItem")->name('editFactoryItem');
    Route::get('destroyFactoryItem/{id}',"Web\OrderController@destroyFactoryItem")->name('destroyFactoryItem');
    Route::post('deliverFactoryOrder/{id}',"Web\OrderController@deliverFactoryOrder")->name('deliverFactoryOrder');

    Route::post('saveFactoryOrder/{id}',"Web\OrderController@saveFactoryOrder")->name('saveFactoryOrder');
    Route::get('factoryOrder','Web\OrderController@factoryOrder')->name('factoryOrder');
    Route::get('factoryOrderDetail/{id}','Web\OrderController@factoryOrderDetail')->name('factoryOrderDetail');
//    New Order Price
    Route::post('newOrderItemPrice','Web\OrderController@newOrderItemPrice')->name('newOrderItemPrice');

    Route::post('mobile-print','Web\AdminController@mobileprint');
    //Purchase
    Route::get('Purchase', 'Web\AdminController@getPurchaseHistory')->name('purchase_list');
    Route::get('Purchase/Details/{id}', 'Web\AdminController@getPurchaseHistoryDetails')->name('purchase_details');
    Route::get('Purchase/Create', 'Web\AdminController@createPurchaseHistory')->name('create_purchase');
    Route::post('Purchase/Store', 'Web\AdminController@storePurchaseHistory')->name('store_purchase');
    Route::post('store_supplier', 'Web\AdminController@store_supplier')->name('store_supplier');
    Route::get('add_supplier', 'Web\AdminController@add_supplier')->name('add_supplier');
    Route::get('suppliercreditlist','Web\AdminController@show_supplier_credit_lists')->name('supplier_credit_list');
    Route::get('supcredit/{id}','Web\AdminController@supplier_credit')->name('supcredit');
    Route::post('store_each_paid_supplier','Web\AdminController@store_eachPaidSupplier')->name('store_each_paid_supplier');
    Route::post('store_all_suppliercredit/{id}','Web\AdminController@store_allSupplierPaid')->name('store_all_suppliercredit');
    Route::post('getPurchaseData','Web\AdminController@getPurchase_Info')->name('getPurchaseData');
    Route::post('getsell_end','Web\AdminController@getsell_end_info')->name('getsell_end');


    //financial
    Route::get('export-expensehistory/{from}/{to}', 'Web\AdminController@expenseHistoryExport')->name('expensehistoryexport');
    
    Route::get('export-incomehistory/{from}/{to}', 'Web\AdminController@incomeHistoryExport')->name('incomehistoryexport');
    
    Route::get('export-salehistory/{from}/{to}/{id}/{sales}/{data_type}/{type}', 'Web\SaleController@saleHistoryExport')->name('salehistoryexport');
    
    Route::get('fixasset', 'Web\AdminController@showFixasset')->name('fixasset');
    Route::get('show_capital', 'Web\AdminController@show_capitalPanel')->name('show_capital');

    Route::post('store_capital', 'Web\AdminController@store_capitalInfo')->name('store_capital');
    Route::get('addasset', 'Web\AdminController@addasset')->name('addasset');
    Route::get('Financial', 'Web\AdminController@getTotalSalenAndProfit')->name('financial');
    Route::get('Expenses', 'Web\AdminController@expenseList')->name('expenses');
    Route::post('storeExpense', 'Web\AdminController@storeExpense')->name('store_expense');
    Route::post('storeExpense', 'Web\AdminController@storeExpense')->name('store_expense');
    Route::post('updateExpense/{id}', 'Web\AdminController@updateExpense')->name('update_expense');
    Route::post('deleteExpense', 'Web\AdminController@deleteExpense')->name('delete_expense');
    Route::post('searchExpenseHistory', 'Web\AdminController@searchExpenseHistory')->name('search_expense_history');
    
    Route::post('store_asset', 'Web\AdminController@storeAsset')->name('store_asset');
    Route::post('store_sell_end', 'Web\AdminController@storeSellEnd')->name('store_sell_end');
    Route::post('store_reinvest','Web\AdminController@store_reinvest_info')->name('store_reinvest');
    Route::post('store_withdraw','Web\AdminController@store_withdraw_info')->name('store_withdraw');

    Route::get('bank_list', 'Web\AdminController@bankAccList')->name('bank_list');
    Route::post('store_bank_acc', 'Web\AdminController@store_bank_account')->name('store_bank_acc');
    Route::post('Edit_Bank_Info/{id}', 'Web\AdminController@editAccount')->name('update_account_info');
    Route::get('transaction_list/{id}', 'Web\AdminController@TransactionList')->name('transaction_list');
    Route::post('store_transaction', 'Web\AdminController@store_transaction_now')->name('store_transaction');
    
    Route::get('Incomes', 'Web\AdminController@incomeList')->name('incomes');
    Route::post('storeIncome', 'Web\AdminController@storeIncome')->name('store_income');
    Route::post('updateIncome/{id}', 'Web\AdminController@updateIncome')->name('update_income');
    Route::post('deleteIncome', 'Web\AdminController@deleteIncome')->name('delete_income');
    Route::post('getTotalSaleReport', 'Web\AdminController@getTotalSaleReport');
    Route::post('getTotalIncome', 'Web\AdminController@getTotalIncome');
    Route::post('getTotalPurchase', 'Web\AdminController@getTotalPurchase');
    Route::post('getTotalTransaction', 'Web\AdminController@getTotalTransaction');
    Route::get('admin_transactions', 'Web\AdminController@getTransactionVouchersv2')->name('admin_transaction_lists');
    Route::post('transactions/newsearch', 'Web\AdminController@search_transactions_bydatev2')->name('search_transactions_bydatev2');
    Route::get('receivable_payable', 'Web\AdminController@getReceivablePayable')->name('receivable_payable_lists');
    Route::post('receivable/newsearch', 'Web\AdminController@search_receivable_bydate')->name('search_receivable_bydate');
    Route::post('payable/newsearch', 'Web\AdminController@search_payable_bydate')->name('search_payable_bydate');
    Route::post('itemadjust/newsearch', 'Web\StockController@search_itemadjust')->name('search_itemadjust');

    //delete for sale customer from vouncher blade
    route::get('delete_saleuser/{id}','Web\SaleController@delete_saleuser')->name('delete_saleuser');

    Route::get('new-asset', 'Web\AdminController@getnewAsset')->name('get_new_asset');


    Route::get('wayPlanning', 'Web\DeliveryController@wayPlaningForm')->name('way_planing_form');

    Route::get('wayPlanningLists', 'Web\DeliveryController@wayPlaningLists')->name('way_planing_lists');

    Route::post('wayplanning/store', 'Web\DeliveryController@wayplanningstore')->name('wayplanning.store');

    Route::post('deliveryorder/receive/store', 'Web\DeliveryController@deliveryOrderReceiveStore')->name('deliveryorderreceive.store');



    Route::get('shop-lists', 'Web\DeliveryController@getshopList');

    Route::get('Admin/Shop/{id}', 'Web\DeliveryController@SalePage')->name('admin_sale_page');
    Route::post('testVoucher', 'Web\DeliveryController@storetestVoucher');
    Route::post('getItemForA5', 'Web\DeliveryController@getItemA5')->name('getItemForA5');


	Route::get('item-assign', 'Web\InventoryController@itemAssign')->name('item_assign');
	Route::post('assign-item-ajax', 'Web\InventoryController@itemAssignajax')->name('item_assign_ajax');
	Route::post('assign-itemshop', 'Web\InventoryController@itemAssignShop');

	Route::post('stockupdate-ajax', 'Web\StockController@stockUpdateAjax')->name('stockupdate-ajax');
	Route::post('salepriceupdate-ajax', 'Web\StockController@salepriceUpdateAjax')->name('salepriceupdate-ajax');
	Route::post('purchasepriceupdate-ajax', 'Web\StockController@purchasepriceUpdateAjax')->name('purchasepriceupdate-ajax');
    // Reset Quantity route ok
	Route::post('resetquantityupdate-ajax', 'Web\StockController@resetquantityUpdateAjax')->name('resetquantityupdate-ajax');
	//
	Route::post('newarrcheckon-ajax', 'Web\StockController@newarrCheckOnAjax')->name('newarrcheckon-ajax');
	Route::post('promocheckon-ajax', 'Web\StockController@promoCheckOnAjax')->name('promocheckon-ajax');
	Route::post('hotsalecheckon-ajax', 'Web\StockController@hotCheckOnAjax')->name('hotsalecheckon-ajax');
    //
    Route::post('newarrivaldate-ajax', 'Web\StockController@setDateAjax')->name('newarrivaldate-ajax');
    Route::post('discountprice-ajax', 'Web\StockController@setPriceAjax')->name('discountprice-ajax');


    Route::post('purchseupdate-ajax', 'Web\StockController@purchaseUpdateAjax')->name('purchaseupdate-ajax');
	Route::post('itemadjust-ajax', 'Web\StockController@itemadjustAjax')->name('itemadjust-ajax');
	Route::get('itemadjust-lists', 'Web\StockController@itemadjustLists')->name('itemadjust-lists');

	Route::get('fixedasset-lists', 'Web\AdminController@getFixedAssets')->name('fixedasset-lists');

    Route::get('itemrequestlists', 'Web\AdminController@itemrequestlists')->name('itemrequestlists');
    Route::post('store_itemrequest', 'Web\AdminController@store_itemrequest')->name('store_itemrequest');

    Route::get('itemrequest/details/{id}', 'Web\AdminController@getRequestHistoryDetails')->name('request_details');
    Route::get('create/itemrequest', 'Web\AdminController@newcreate_itemrequest')->name('newcreate_itemrequest');
    Route::post('requestitems/send', 'Web\AdminController@requestitemssend')->name('requestitemssend');

    Route::post('purchaseprice/update', 'Web\AdminController@purchasepriceUpdate')->name('purchasepriceupdate');
    Route::post('delete_units', 'Web\AdminController@delete_units')->name('delete_units');

    Route::post('purchase_delete', 'Web\AdminController@purchaseDelete')->name('purchase_delete');

//    Specifications
    Route::get('/specs/{type}',[\App\Http\Controllers\SpecificationController::class,'index'])->name('specs');
//    Design
    Route::post('/design',[\App\Http\Controllers\DesignController::class,'store'])->name('design.store');
    Route::post('/design-update/{id}',[\App\Http\Controllers\DesignController::class,'update'])->name('design.update');
    Route::get('/design-destroy/{id}',[\App\Http\Controllers\DesignController::class,'destroy'])->name('design.destroy');
//    Fabric
    Route::post('/fabric',[\App\Http\Controllers\FabricController::class,'store'])->name('fabric.store');
    Route::post('/fabric-update/{id}',[\App\Http\Controllers\FabricController::class,'update'])->name('fabric.update');
    Route::get('/fabric-destroy/{id}',[\App\Http\Controllers\FabricController::class,'destroy'])->name('fabric.destroy');

//    Colour
    Route::post('/colour',[\App\Http\Controllers\ColourController::class,'store'])->name('colour.store');
    Route::post('/colour-update/{id}',[\App\Http\Controllers\ColourController::class,'update'])->name('colour.update');
    Route::get('/colour-destroy/{id}',[\App\Http\Controllers\ColourController::class,'destroy'])->name('colour.destroy');
//    Size
    Route::post('/size',[\App\Http\Controllers\SizeController::class,'store'])->name('size.store');
    Route::post('/size-update/{id}',[\App\Http\Controllers\SizeController::class,'update'])->name('size.update');
    Route::get('/size-destroy/{id}',[\App\Http\Controllers\SizeController::class,'destroy'])->name('size.destroy');
//    Gender
    Route::post('/gender',[\App\Http\Controllers\GenderController::class,'store'])->name('gender.store');
    Route::post('/gender-update/{id}',[\App\Http\Controllers\GenderController::class,'update'])->name('gender.update');
    Route::get('/gender-destroy/{id}',[\App\Http\Controllers\GenderController::class,'destroy'])->name('gender.destroy');
});

//Excel Export & Import
Route::get('/excel', function () {
    return view('Admin.execel');
});
Route::post('execelImport', 'Web\AdminController@execelImport')->name('execelImport');
//Design Excel
Route::post('/designImport',"\App\Http\Controllers\DesignController@import")->name('designImport');
Route::get('/designExport',"\App\Http\Controllers\DesignController@export")->name('designExport');
//Fabric Excel
Route::post('/fabricImport',"\App\Http\Controllers\FabricController@import")->name('fabricImport');
Route::get('/fabricExport',"\App\Http\Controllers\FabricController@export")->name('fabricExport');
//Colour
Route::post('/colourImport',"\App\Http\Controllers\ColourController@import")->name('colourImport');
Route::get('/colourExport',"\App\Http\Controllers\ColourController@export")->name('colourExport');
//Size Excel
Route::post('sizeImport',"\App\Http\Controllers\SizeController@import")->name('sizeImport');
Route::get('/sizeExport',"\App\Http\Controllers\SizeController@export")->name('sizeExport');
//Gender Excel
Route::post('/genderImport',"\App\Http\Controllers\GenderController@import")->name('genderImport');
Route::get('/genderExport',"\App\Http\Controllers\GenderController@export")->name('genderExport');
//Item Excel
Route::get('/itemExport',"\App\Http\Controllers\Web\InventoryController@export")->name('itemExport');
Route::post('/itemImport',"\App\Http\Controllers\Web\InventoryController@import")->name('itemImport');
Route::post('/factoryItemImport',"\App\Http\Controllers\FactoryItemController@import")->name('factoryItemImport');
//Counting Unit Excel
Route::post('/countingUnitImport',"\App\Http\Controllers\Web\InventoryController@countingUnitImport")->name('countingUnitImport');
//Category Excel
Route::post('/categoryImport',"\App\Http\Controllers\Web\InventoryController@categoryImport")->name('categoryImport');
//SubCategory Excel
Route::post('/subCategoryImport',"\App\Http\Controllers\Web\InventoryController@subCategoryImport")->name('subCategoryImport');
Route::get('/subCategoryExport',"\App\Http\Controllers\Web\InventoryController@subcategoryExport")->name('subCategoryExport');

//Factory Item Export
Route::get('/factoryItemExport',"\App\Http\Controllers\Web\InventoryController@factoryItemExport")->name('factoryItemExport');
