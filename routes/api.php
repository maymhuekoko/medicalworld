<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\MailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('Login', 'Api\LoginController@loginProcess');
Route::get('countingunitapi', 'Api\CountingUnitApiController@index');
Route::get('unitbyid_api/{id}', 'Api\CountingUnitApiController@getUnitById');
Route::get('subcategory_api', 'Api\SubcategoryApiController@index');
Route::get('subcategory_api/{id}', 'Api\SubcategoryApiController@getSubcategoryById');
Route::get('category_api', 'Api\CategoryApiController@index');

Route::get('item_api', 'Api\ItemApiController@index');
Route::get('newitem_api', 'Api\ItemApiController@getNewArrivalItems');
Route::get('promotionitem_api', 'Api\ItemApiController@getPromotionItems');
Route::get('hotsaleitem_api', 'Api\ItemApiController@getHotSaleItems');
Route::post('productlineitems_api', 'Api\ItemApiController@getItemByProductLine');
Route::get('website_user_index', 'Api\WebsiteUserApiController@index');
Route::post('website_user_store', 'Api\WebsiteUserApiController@store');
Route::get('ecommerce_order_index', 'Api\EcommerceOrderApiController@index');
Route::get('design_api/{id}', 'Api\EcommerceOrderApiController@getdesignname');
Route::get('ecommerce_order_type/{name}', 'Api\EcommerceOrderApiController@type');
Route::get('ecommerce_order_type/{name}/{gender}', 'Api\EcommerceOrderApiController@typegender');
Route::get('ecommerce_order_type/{name}/{gender}/{fabric}', 'Api\EcommerceOrderApiController@typefabric');
Route::get('ecommerce_order_type/{name}/{gender}/{fabric}/{colour}', 'Api\EcommerceOrderApiController@typecolour');
Route::get('ecommerce_order_detail/{id}', 'Api\EcommerceOrderApiController@detail');
Route::post('ecommerce_order_store', 'Api\EcommerceOrderApiController@store');
Route::post('showprice', 'Api\EcommerceOrderApiController@showprice')->name('showprice');
Route::post('ecommerce_preorder_store', 'Api\EcommerceOrderApiController@preorderstore');
Route::get('township', 'Api\EcommerceOrderApiController@township');
Route::get('township_charges/{id}', 'Api\EcommerceOrderApiController@township_charges');
Route::post('send/invoice_email', 'Api\EcommerceOrderApiController@invoice_mail')->name('invoice_email');

Route::post('contact_message', 'Api\ContactMessageController@contact_message')->name('contact_message');

Route::group(['middleware' => ['auth:api','CustomerPermissionAPI']], function () {

	Route::post('Logout', 'Api\LoginController@logoutProcess');

	Route::post('updatePassword', 'Api\LoginController@updatePassword');

	Route::post('editProfile', 'Api\CustomerController@editProfile');

	Route::post('getItemListbyCategory', 'Api\CustomerController@getItemListbyCategory');

	Route::post('getCountingUnit', 'Api\CustomerController@getCountingUnit');

	Route::post('storeOrder', 'Api\CustomerController@storeOrder');

	Route::post('getOrderList', 'Api\CustomerController@getOrderList');

	Route::post('getOrderDetails', 'Api\CustomerController@getOrderDetails');

	Route::post('changeOrder', 'Api\CustomerController@changeOrder');

	Route::post('acceptOrder', 'Api\CustomerController@acceptOrder');

	Route::post('delivery/sendlocation', 'Api\DeliveryController@deliverySendlocation');

	Route::post('delivery/getlocation', 'Api\DeliveryController@deliveryGetlocation');

});




