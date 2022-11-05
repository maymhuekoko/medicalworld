@extends('master')

@section('title', 'Order Page')

@section('place')
    <style>
        .editprice {
            cursor: pointer
        }

        .discount {
            cursor: pointer
        }

        .form-control:disabled, .form-control[readonly] {
            opacity: 1;
        }

        .form-control:disabled {
            background-color: #FFFFFF !important;
            opacity: 1 !important;
            color: black !important;
        }
    </style>

@endsection

@section('content')
    @php
        $from_id = session()->get('from');
    @endphp

<!--    --><?php
//    $items = '<span id="lenn"></span>';
//
//    ?>


    <div class="row mb-3">
        <input type="hidden" id="fid" value="{{ $from_id }}">

        <div class="col-md-2">
            <form action="{{ route('get_voucher') }}" method="post" id="vourcher_page">
                @csrf
                <input type="hidden" id="item" name="item">

                <input type="hidden" id="grand" name="grand">

                <input type="hidden" name="right_now_customer" id="right_now_customer">

                <input type="hidden" id="discount" name="discount">

                <input type="hidden" id="foc_flag" name="foc_flag">

                <input type="hidden" id="has_dis" name="has_dis">

            </form>
        </div>
    </div>
    <!--Begin Sale Page -->
    <div class="row">
        <div class="col-md-7 pr-0">
            <div class="row mt-1 mb-2">

            </div>
        </div>
        <div class="col-md-5 mt-1 pl-0">
            <div class="col-md-10 mb-1">
                <select id="showroom" class="form-control" style="font-size: 14px">
                    <option value="online">Online Shop</option>
                    <option value="agent">Online Shop Agent</option>
                    <option value="yangon">Yangon Family Hospital Uniform</option>
                    <option value="mandalay">Mandalay Family Hospital Uniform</option>
                    <option value="office">Office Family Hospital Uniform</option>
                </select>
            </div>
        </div>
        <div class="col-md-7 pr-0">
            {{-- refresh here --}}
            <div class="col-12 pr-0" style="">
                <div class="card" style="border-radius: 0px;min-height:100vh">
                    <div class="card-title d-flex align-items-center my-2">
                        <a href="" class="text-success px-2" onclick="deleteItems()"><i class="fas fa-sync"></i> Refresh
                            Here &nbsp</a>
                        <button onclick="addOrder()" class="btn btn-primary">Add</button>
                    </div>
                    <div class="card-body salepageheight">
                        <h5 class=" now_customer text-warning">Customer <span id="now_customer_no"></span></h5>
                        <input type="hidden" name="now_customer" value="0" id="now_customer">

                        <div class="row ">
                            <div class="table-responsive">
                                <table class="table text-black table-bordered order-table" style="width:1700px; max-width:none;">
                                    <thead class="">
                                    <tr class="text-center">
                                        <th style="width: 300px" class="text-black">@lang('lang.item') @lang('lang.name')</th>
                                        <th style="width: 300px" class="text-black">Specs</th>
                                        <th style="width: 300px" class="text-black">@lang('lang.quantity')</th>
                                        <th style="width: 300px" class="text-black">@lang('lang.price')</th>
                                        <th style="width: 300px" class="text-black">Discount</th>
                                        <th style="width: 300px" class="text-black">Sub Total</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody id="order">
                                    {{--                                Order table-row ထည့်ရန်--}}
                                    <div class="modal fade showDiscount" id="itemDiscount" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success d-flex justify-content-between align-items-center">
                                                    <h4 class="modal-title text-white font-weight-bold">Item Discount</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                            id="#close_modal">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3 d-flex flex-column">
                                                        <label for="" class="font-weight-bold text-secondary ">Current Amount</label>
                                                        <input type="text" class="form-control w-75" disabled value="0" id="item_current_amount">
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-around mb-5" id="form-radio">
                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input " id="item_dis_amount" type="radio" name="inlineRadioOptions" value="amount" onclick="amount_radio(this.value)">
                                                            <label class="form-check-label" for="item_dis_amount">Amount</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input " id="item_dis_percent" type="radio" name="inlineRadioOptions" value="percent" onclick="amount_radio(this.value)">
                                                            <label class="form-check-label" for="item_dis_percent">Percent( % )</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input " id="item_foc" type="radio" name="inlineRadioOptions" value="foc" onclick="amount_radio(this.value)">
                                                            <label class="form-check-label" for="item_foc">Foc</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <input type="hidden" id="discount_id" value="">
                                                    <input type="hidden" id="discount_type" >
                                                    
                                                    <div class="mb-3 d-none" id="item_dis_amount_form">
                                                        <label for="" class="font-weight-bold text-secondary ">Enter Discount Amount</label>
                                                        <input type="number" class="form-control w-75 itemDisAmount" id="item_discount_amount">
                                                    </div>
                                                    <div class="mb-3 d-none" id="item_dis_percent_form">
                                                        <label for="" class="font-weight-bold text-secondary ">Enter Discount Percent ( % )</label>
                                                        <input type="number" class="form-control w-75 itemDisPercent" id="item_discount_percent">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="font-weight-bold text-secondary d-block">Discount Value</label>
                                                        <input type="text" class="form-control w-75" disabled value="" id="discount_value">
                                                    </div>
                                                    <input type="hidden" class="itemFoc" name="foc" value="foc" id="item_dis_foc">

                                                    <div class="mb-3">
                                                        <label for="" class="font-weight-bold text-secondary d-block">Total Amount </label>
                                                        <input type="text" class="form-control w-75" disabled value="" id="total_amount">
                                                    </div>

                                                    <div class="mb-3">
                                                        <button class="btn btn-outline-success btn-rounded itemDiscountBtn" id="itemDiscountSave">Discount</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr class="text-center">

                                    </tr>
                                    </tbody>
                                    <tfoot>

                                    <tr class="text-right">
                                        <td class="text-black" colspan="5">@lang('lang.total') @lang('lang.quantity')
                                        </td>
                                        <td class="text-black" colspan="2" id="total_quantity">0</td>
                                    </tr>
                                    <tr class="text-right">
                                        <td class="text-black" colspan="5">@lang('lang.total')</td>
                                        <td class="text-black" colspan="2" id="sub_total">0</td>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>

                        </div>

                        <!-- Button trigger modal -->


                        <div class="row ml-2 justify-content-center">

                            <!-- <div class="col-md-8"> -->

                            <div class="modal fade discount" id="customer_order" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('lang.add_customer_order')</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.select_customer')</label>
                                                <select class="form-control m-b-10" id="customer_id" style="width: 100%"
                                                        required onchange="getCustomerInfo(this.value)">
                                                    @foreach ($customers as $customer)
                                                        <option value="">{{$customer}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.phone')</label>
                                                <input type="number" id="phone" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.delivered_date')</label>
                                                <input type="datetime-local" id="delivered_date" class="form-control"
                                                       required value="{{ date('Y-m-d\TH:i', $today_date) }}">

                                                <div class="form-group">
                                                    <label class="font-weight-bold">@lang('lang.order_date')</label>
                                                    <input type="date" id="order_date" class="form-control" required
                                                           value="{{ date('Y-m-d', $today_date) }}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold">@lang('lang.address')</label>
                                                    <input type="text" id="address" class="form-control" required>

                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold">Select Employee</label>
                                                    <select class="form-control m-b-10" id="employee" style="width: 100%"
                                                            required>
                                                        <option value="">Please Choose Employee</option>
                                                        @foreach ($employees as $emp)
                                                            @if ($emp->user->role == 'Delivery_Person')
                                                                <option value="{{ $emp->id }}">
                                                                    {{ $emp->user->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <a href="#" class="btn btn-success" onclick="storeCustomerOrder()">
                                                    <i class="fas fa-calendar-check"></i> @lang('lang.store_order')
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 offset-md-6">
                <div class="pending-voucher row">
                </div>
            </div>
            <div class="modal fade" id="editprice" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Item Price</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    id="#close_modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--End Sale Page -->
        <div class="col-md-5 mt-1 pl-0">
            <!-- Begin Sale Customer Info -->
            <div class="col-md-12 pl-0" style="margin-left:-1px">
                <div class="card pl-2 pr-4 py-3 mb-0" style="border-radius: 0px;margin-top:-4px">
                    <div class="">

                        <div class="d-flex align-items-center my-1">
                           <label class="control-label text-black col-5 font14">Customer Name</label>
                        <select class="form-control text-black d-none d-sm-none d-md-block d-lg-block col-md-7"
                                    style="font-size: 14px" id="ordercustomer_list" onchange="fillOrderCustomer(this.value)">
                                <option value="" class="text-black" style="font-size: 14px">Select Customers</option>

                                @foreach ($ordercustomers as $ordercustomer)
                                    <option value="{{ $ordercustomer->id }}">{{ $ordercustomer->name }}</option>
                                @endforeach

                            </select>
                            </div>

                        <div class="d-flex align-items-center my-1">
                            <label class="control-label text-black col-5 font14"></label>
                            <input type="text" class="form-control col-7 font14 text-black" id="customer_name" value=""
                                   placeholder="Name">
                        </div>

                        <div class="d-flex align-items-center my-1">
                            <label class="control-label text-black col-5 font14">Customer Phone</label>
                            <input type="number" class="form-control col-7 font14 text-black" id="customer_phone" value="09"
                                   placeholder="09">
                        </div>

                        <div class="d-flex align-items-center my-1">
                            <label class="control-label text-black col-5 font14">Address</label>
                            <textarea class="form-control col-7 font14 text-black" id="customer_address" value="address"
                                      placeholder="Address" d-flex align-items-centers="5" cols="100"></textarea>
                        </div>

                        <div class="d-flex align-items-center my-1">
                            <label class="control-label text-black col-5 font14">@lang('lang.order_date')</label>
                            <input type="date" id="order_date" class="form-control col-7 font14 text-black" required
                                   value="{{ date('Y-m-d', $today_date) }}">
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <label class="control-label  col-5 text-black">Payment Type</label>
                            <select id="payment_type" class="form-control col-7" style="font-size: 14px">
                                <option value="">Select Payment</option>
                                <option value="1">COD</option>
                                <option value="2">PrePaid Full</option>
                                <option value="3">PrePaid Partial</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <label class="control-label text-black col-5">Advance Payment</label>
                            <input type="number" value="0" id="advance_pay" class="form-control col-7 h-75 text-black">
                        </div>
                    </div>
                    <br>

                    <div class="d-flex align-items-center d-none d-sm-none d-md-block d-lg-block">
                        <div class="col-md-7 offset-md-5 pl-0">
                                                        <button id="save" class="btn btn-outline-secondary" type="button"><span><i
                                                                    class="fa fa-save mr-2"></i>Save</span></button>
                            <a href="#" class="btn btn-outline-danger mx-2" id="deletesaleuser"></i>
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card pl-2 pr-4 py-3" style="border-radius: 0px;margin-top:-9px">
                    <div class="row mb-2">
                        <label class="control-label  col-5 text-black">စုစုပေါင်း </label>
                        <input type="number" class="form-control col-7 h-75 text-black" id="gtot" value="">
                    </div>
                    <div class="row mb-2">
                        <label class="control-label text-black col-5">Discount</label>
                        <input type="text" class="form-control col-4 h-75 text-black" id="discount_amount" readonly
                               value="0">
                        <div class="col-3">
                            <button id="voucher_discount" onclick="insert_total()" class="btn btn-secondary"
                                    type="button"><span><i class="fa fa-save mr-3"></i>Discount</span></button>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="control-label text-black col-5">Logo Fee</label>
                        <input type="number" value="0" id="logo_fee" class="form-control col-7 h-75 text-black">
                    </div>

                    <div class="row mb-2">
                        <label class="control-label text-black col-5">ပို့ဆောင်ခ</label>
                        <input type="number" value="0" id="delivery_fee" class="form-control col-7 h-75 text-black">
                    </div>
                    
                    

                    <div class="row mb-2">
                        <label class="control-label text-black col-5">ကျသင့်ငွေ</label>
                        <input type="number" id="with_dis_total" class="form-control col-7 h-75 text-black">
                    </div>

                    <div class="row">
                        <label class="control-label pt-2 col-5 text-black">Voucher အမျိုးအစား</label>
                        <div class="col-4 pl-0">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                                        SLIP
                                    </a>
                                </li>
                                <li class=" nav-item">
                                    <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false"
                                       onclick="show_a5()">
                                        A5
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-secondary d-none d-sm-none d-md-block d-lg-block" type="button"
                                    data-toggle="modal" data-target="#seevoucher">
                                <span><i class="fas fa-eye"></i> Voucher</span></button>
                        </div>
                    </div>
                </div>

                <?php
                    $sale_name = session()->get('user')->name;
                ?>

                <div class="modal fade" id="seevoucher" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Voucher</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        id="#close_modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="tab-content br-n pn">
                                    <div id="navpills-1" class="tab-pane active">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 printableArea" style="width:45%;">
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="text-center">
                                                                <address>
                                                                </address>
                                                            </div>
                                                            <div class="pull-right text-left">
                                                                <h6 class="text-black">Date : <i
                                                                        class="fa fa-calendar"></i></h6>
                                                                <h6 class="text-black">Voucher Number : <span
                                                                        class="vou_code">{{ $voucher_code??1 }}</span>
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="table-responsive text-black" style="clear: both;">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                    <tr class="text-black">
                                                                        <th>Name</th>
                                                                        <th>Qty*Price</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="text-black" id="slip_live">

                                                                    <tr>
                                                                        <td style="font-size:15px;"></td>
                                                                        <td style="font-size:15px;"></td>
                                                                        <td style="font-size:15px;" id="subtotal"></td>
                                                                    </tr>

                                                                    </tbody>
                                                                    <tfoot class="text-black">
                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="text-right"
                                                                            style="font-size:18px;">Total
                                                                        </td>
                                                                        <td id="total_charges" class="font-weight-bold"
                                                                            style="font-size:18px;"><span
                                                                                id="slip_total"></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="text-right"
                                                                            style="font-size:18px;">Pay
                                                                        </td>
                                                                        <td id="pay" style="font-size:18px;"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="text-right"
                                                                            style="font-size:18px;">Change
                                                                        </td>
                                                                        <td id="changes" style="font-size:18px;"></td>
                                                                    </tr>
                                                                    </tfoot>
                                                                </table>
                                                                <h6 class="text-center font-weight-bold text-black">
                                                                    ***ကျေးဇူးတင်ပါသည်***</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="navpills-2" class="tab-pane ">
                                        <div class="row justify-content-center" id="a5_voucher">
                                            <div class="col-md-10">

                                                <div class="card card-body printableArea">
                                                    <div style="display:flex;justify-content:space-around">
                                                        <div class="col-md-12 text-center">
                                                            <div>
                                                                <img src="{{ asset("image/medicalWorld.png") }}" width="500px">
                                                            </div>

                                                            <div>
                                                                <p class="mt-2" style="font-size: 15px;">No.28,Hlaing Yadanar Mon 3rd Street, Hlaing Yadanar Mon Avenue, Hlaing Township, Yangon
                                                                    <br/><i class="fas fa-mobile-alt" style="font-size: 15px;"></i>  09 777 00 5861, 09 777 00 5862
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h3 class="text-center text-secondary font-weight-bold">Order Receive Form</h3>
                                                            </div>
                                                        </div>
                                                        <div></div>
                                                    </div>
                                                    <div class="row text-black">
                                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                                            <div class="d-flex flex-column mb-1">
                                                                <div class="">
                                                                    <h6 class=" mt-2 text-black">
                                                                        Order @lang('lang.number') : <span
                                                                            class="vou_code">{{ $voucher_code }}</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="">
                                                                    <h6 class=" mt-2 text-black"> Order
                                                                        @lang('lang.date')
                                                                        : {{ $vou_date }} </h6>
                                                                </div>
                                                                <div class="">
                                                                    <h6 class=" mt-2 text-black"> Sale Name: {{ $sale_name }} </h6>
                                                                </div>
                                                                
                                                            </div>

                                                            <div class="d-flex flex-column">
                                                                <div class="">
                                                                    <h6 class=" mt-2 text-black">Name :
                                                                        <span id="cus_name"></span>
                                                                    </h6>
                                                                </div>
                                                                <div class="">
                                                                    <h6 class=" mt-2 text-black">Phone :
                                                                        <span id="cus_phone"></span>
                                                                    </h6>
                                                                </div>
                                                                
                                                                <div class="">
                                                                    <h6 class=" mt-2 text-black">.</h6>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table style="width: 100%;">
                                                                <thead class="text-center">
                                                                <tr>
                                                                    <th
                                                                        style="width:30px;font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;">
                                                                        @lang('lang.number')</th>
                                                                    <th
                                                                        style="font-size:15px; font-weight:normal; height: 15px; border: 1px solid black;">
                                                                        @lang('lang.item')</th>
                                                                    <th
                                                                        style="font-size:15px; font-weight:normal; height: 15px; border: 1px solid black;">
                                                                        Color
                                                                    </th>
                                                                    <th
                                                                        style="width:70px;font-size:15px; font-weight:normal; height: 15px; border: 1px solid black;">
                                                                        Size
                                                                    </th>
                                                                    <th
                                                                        style="width:70px;font-size:15px; font-weight:normal; height: 15px; border: 1px solid black;">
                                                                        Quantity
                                                                    </th>
                                                                    <th
                                                                        style="width:70px;font-size:15px; font-weight:normal; height: 15px; border: 1px solid black;">
                                                                        @lang('lang.price')</th>
                                                                        <th
                                                                        style="width:90px;font-size:15px; font-weight:normal; height: 15px; border: 1px solid black;">
                                                                        Discount</th>
                                                                        
                                                                    <th
                                                                        style="width:90px;font-size:15px; font-weight:normal; height: 15px; border: 1px solid black;">
                                                                        @lang('lang.total')</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody class="text-center" id="a5_body">
                                                                </tbody>
                                                            </table>

                                                            <div class="d-flex justify-content-between align-items-center my-5">
                                                                <div class="">
                                                                    <h6 class="font-weight-bold">PAID BY</h6>
                                                                    <p style="font-size: 10px">Sign :</p>
                                                                    <p style="font-size: 10px">Name :</p>
                                                                    <p style="font-size: 10px">Position :</p>

                                                                </div>
                                                                <div class="">
                                                                    <h6 class="font-weight-bold">RECEIVED BY</h6>
                                                                    <p style="font-size: 10px">Sign :</p>
                                                                    <p style="font-size: 10px">Name : {{session()->get('user')->name}}</p>
                                                                    <p style="font-size: 10px">Position :</p>

                                                                </div>
                                                                <div class="">
                                                                    <h6 class="font-weight-bold">APPROVED BY</h6>
                                                                    <p style="font-size: 10px">Sign :</p>
                                                                    <p style="font-size: 10px">Name : </p>
                                                                    <p style="font-size: 10px">Position :</p>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="row mt-2">

                            <div class="col-md-6 text-right">
                                <h3 class="text-info font-weight-normal" style="font-size:18px;">
                                    @lang('lang.total') - <span id="total_charges_a5"> </span>
                                </h3>
                            </div>

                            <div class="col-md-6 text-right">
                                <h3 class="text-info font-weight-bold" style="font-size:18px;">
                                    Pay - <span id="pay_1"> </span>
                                </h3>
                            </div>

                            <div class="col-md-6">
                                <h3 class="text-info font-weight-bold" style="font-size:18px;">
                                    Credit - <span id="credit_amount"> </span>
                                </h3>
                            </div>

                            <div class="col-md-6 text-right">
                                <h3 class="text-info font-weight-bold" style="font-size:18px;">
                                    Change - <span id="changes_1"> </span>
                                </h3>
                            </div>

                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 d-none">
                        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#customer_order">
                            <i class="fas fa-calendar-check"></i> @lang('lang.add_customer_order')
                        </a>
                    </div>
                    <div class="col-md-4 col-4 d-none d-sm-none d-md-block d-lg-block ">
                        <i class="btn btn-success ml-3" onclick="storePendingVoucher()"><i
                                class="fas fa-arrow-alt-circle-down"></i> Pending Order </i>
                    </div>
                {{-- <div class="col-md-4 col-4 d-none"> --}}
                <!-- <i class="btn btn-success" onclick="showCheckOut()"><i class="fas fa-calendar-check"></i> @lang('lang.check_out') </i> -->
                    {{-- <a href="#show_vou" class="btn btn-success"><i class="fas fa-calendar-check"></i>
                            @lang('lang.check_out') </a>
                    </div> --}}
                    <div class="col-md-2">
                        <button id="print" class="ml-2 btn btn-success d-none d-sm-none d-md-block d-lg-block"
                                type="button">
                            <span><i class="fa fa-print"></i> Print</span></button>
                    </div>
                <!-- <div class="col-md-4 offset-4 d-block d-md-none d-lg-none store_voucher">
                        {{-- for mobile --}}
                    <button class="btn btn-danger " type="button"> <span><i class="fa fa-calendar-check"></i> Store
                            Voucher</span> </button>
                </div> -->
                    <div class="col-md-4 d-none d-sm-none d-md-block d-lg-block ">
                        {{-- for web --}}
                        <button class="btn btn-danger store_order" type="button" onclick="storeCustomerOrder()">
                            <span><i class="fa fa-calendar-check"></i> Store Orders</span></button>
                    </div>
                </div>
            </div>
            <br>

            <div class="modal fade" id="voudiscount" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h4 class="modal-title text-white">Voucher Discount</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    id="#close_modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body" id="checkout_modal_body">
                            <input type="hidden" id="vou_discount" name="vou_discount">
                            <div class="form-group">
                                <label class="h6 mb-2 font-weight-bold">Total Price</label>
                                <input type="text" class="form-control" readonly id="voucher_total" value="">
                            </div>
                            <div class="form-check form-switch float-right">
                                <input class="form-check-input" name="voufoc" type="checkbox" id="voufoc" value="1">
                                <label class="form-check-label" for="voufoc">FOC</label>
                            </div>
                            <div class="form-group">
                                {{--                                <label class="font-weight-bold">@lang('lang.price') <span id="vou_discount_amount"--}}
                                {{--                                        class="text-danger"></span>--}}
                                {{--                                    mmk<span>(Voucher Total)</span></label>--}}
                                <label class="font-weight-bold h6 mb-2 text-primary">Discount</label>
                                <input type="number" id="discount_price" class="form-control" required value="">
                                {{--                                <input type="number" id="vou_price_change" class="form-control" required value="">--}}
                                <input type="hidden" id="vou_or_price" value="0">
                            </div>
                            <div class="row">
                                <div class="col-6 form-check form-switch">
                                    <input class="form-check-input" name="vou_percent_for_price" type="checkbox" value="1"
                                           id="vou_percent_for_price">
                                    <label class="form-check-label" for="vou_percent_for_price">(%)</label>
                                </div>
                                <div class="form-group col-6">
                                    <input type="number" id="vou_percent_price" class="form-control" disabled>
                                </div>
                            </div>

                            <button type="button" class="btn btn-success" id="vou_price_change_btn" btn-lg
                                    btn-block
                            ">Change Price</button>
                        </div>


                    </div>
                </div>
            </div>
            <?php
            $username = session()->get('user')->name;

            ?>
            <input type="hidden" id="userName" value="{{$username}}">
            <input type="hidden" id="voucherCode" value="{{ $voucher_code }}">
            <input type="hidden" id="select_cusid" value=1>
        </div><!-- All row end -->
        @endsection

        @section('js')

            <script type="text/javascript">
                $('#table_1').DataTable({

                    "paging": false,
                    "ordering": true,
                    "info": false,
                    scrollY: 700,

                });

                $('#table_2').DataTable({

                    "paging": false,
                    "ordering": true,
                    "info": false,
                    scrollY: 700,

                });

                $('#table_3').DataTable({

                    "paging": false,
                    "ordering": true,
                    "info": false,
                    scrollY: 700,

                });
                $('#table_4').DataTable({

                    "paging": false,
                    "ordering": true,
                    "info": false,
                    scrollY: 700,

                });

                $(".select").select2({
                    placeholder: "ရှာရန်",
                });

                $(document).ready(function () {
                   
                    let order_detail = localStorage.getItem('order_detail');
                    let delivery_fee = 0;
                    let logo_fee = 0;
                    if(order_detail != null){
                    let orderObj = JSON.parse(order_detail);
                    
                    
                    $('#customer_name').val(orderObj.customerName);
                    $('#customer_phone').val(orderObj.customerPhone);
                    $('#customer_address').val(orderObj.address);
                    
                    $('#order_date').val(orderObj.orderDate);

                    $('#payment_type').val(orderObj.paymentType).change();

                    $('#advance_pay').val(orderObj.advancePay);

                   $('#delivery_fee').val(orderObj.deliveryFee);
                   
                   $('#logo_fee').val(orderObj.logoFee);
                   delivery_fee =orderObj.deliveryFee;
                   logo_fee = orderObj.logoFee;
                   
                   $("#voucherCode").val(orderObj.orderNumber);

                    
                    $("#showroom").val(orderObj.showroom).change();
                    
                    }
                    var orderGrandTotal = localStorage.getItem('orderGrandTotal');
                     var orderGrandTotalobj = JSON.parse(orderGrandTotal);
                    
                    
                            var sub_total = orderGrandTotalobj.sub_total;
                             var discount_amount = orderGrandTotalobj.total_discount_value;
                            var total_wif_discount = (orderGrandTotalobj.sub_total + delivery_fee + logo_fee) - orderGrandTotalobj.total_discount_value;

                        $("#total_quantity").text(orderGrandTotalobj.total_qty);

                        $("#sub_total").text(sub_total);
                        $('#gtot').val(sub_total);
                        $('#discount_amount').val(discount_amount);
                        $('#with_dis_total').val(total_wif_discount);
                   

                    $('.now_customer').hide();
                    
                    local_customer_lists();
                     showOrderItem();
                     
                     

                });

                function deleteItems() {
                    localStorage.clear();
                    // clearLocalstorage(0);

                    localStorage.setItem('item-count', 0);
                }

                function qrSearch() {
                    if ($("#search_wif_typing").hasClass("d-block")) {
                        $("#search_wif_typing").removeClass("d-block");
                        $("#search_wif_typing").addClass("d-none");
                        $("#search_wif_barcode").removeClass("d-none");
                        $("#search_wif_barcode").addClass("d-block");
                    } else {
                        $("#search_wif_typing").removeClass("d-none");
                        $("#search_wif_typing").addClass("d-block");
                        $("#search_wif_barcode").removeClass("d-block");
                        $("#search_wif_barcode").addClass("d-none");
                    }

                    document.getElementById("qr_code").focus();

                }

                function QRcodeTest(value) {

                    let sale_type = $("#price_type").val();

                    $.ajax({

                        type: 'POST',

                        url: '/getCountingUnitsByItemCode',

                        data: {
                            "_token": "{{ csrf_token() }}",
                            "unit_code": value,
                        },

                        success: function (data) {

                            var item_name = data.item.item_name;

                            var id = data.id;

                            var name = data.unit_name;

                            var qty = parseInt(data.current_quantity);

                            if (sale_type == 1) {

                                var price = data.normal_sale_price;

                            } else if (sale_type == 2) {

                                var price = data.normal_sale_price;

                            } else {

                                var price = data.order_price;

                            }
                            var value = 1;
                            if (qty == 0) {


                                swal({
                                    title: "Can't Add",
                                    text: "Your Input is higher than Current Quantity!",
                                    icon: "info",
                                });

                            } else {

                                var total_price = price * value;

                                var item = {
                                    id: id,
                                    item_name: item_name,
                                    unit_name: name,
                                    current_qty: qty,
                                    order_qty: value,
                                    selling_price: price
                                };

                                var total_amount = {
                                    sub_total: total_price,
                                    total_qty: value
                                };

                                var myOrderCart = localStorage.getItem('myOrderCart');

                                var grand_total = localStorage.getItem('orderGrandTotal');

                                if (myOrderCart == null) {

                                    myOrderCart = '[]';

                                    var myOrderCartobj = JSON.parse(myOrderCart);

                                    myOrderCartobj.push(item);

                                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                                } else {

                                    var myOrderCartobj = JSON.parse(myOrderCart);

                                    var hasid = false;

                                    $.each(myOrderCartobj, function (i, v) {

                                        if (v.id == id) {

                                            hasid = true;

                                            v.order_qty = parseInt(value) + parseInt(v.order_qty);
                                        }
                                    })

                                    if (!hasid) {

                                        myOrderCartobj.push(item);
                                    }

                                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));
                                }

                                if (grand_total == null) {

                                    localStorage.setItem('orderGrandTotal', JSON.stringify(total_amount));

                                } else {

                                    var grand_total_obj = JSON.parse(grand_total);

                                    grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                                    grand_total_obj.total_qty = parseInt(value) + parseInt(grand_total_obj.total_qty);

                                    localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));
                                }

                                showmodal();

                                $("#qr_code").val("");
                                $("#qr_code").focus();
                            }
                        }

                    });
                }

                function getCountingUnit(item_id) {
                    var html = "";

                    $.ajax({

                        type: 'POST',

                        url: '/getCountingUnitsByItemId',

                        data: {
                            "_token": "{{ csrf_token() }}",
                            "item_id": item_id,

                        },

                        success: function (data) {

                            $.each(data, function (i, unit) {

                                html += `<tr class="text-center">
                            <input type="hidden" id="item_name" value="${unit.item.item_name}">
                            <input type="hidden" id="qty_${unit.id}" value="${unit.current_quantity}">
                            <td>${unit.item.item_name}</td>
                            <td id="name_${unit.id}">${unit.unit_name}</td>
                            <td><select class='form-control' id="price_${unit.id}"><option value='${unit.normal_sale_price}'>Normal Sale - ${unit.normal_sale_price}</option><option value='${unit.whole_sale_price}'>Whole Sale - ${unit.whole_sale_price}</option><option value='${unit.order_price}'>Order Sale - ${unit.order_price}</option></select></td>

                            <td><i class="btn btn-primary" onclick="tgPanel(${unit.id})" ><i class="fas fa-plus"></i> Add</i></td>
                      </tr>`;
                            });

                            $("#count_unit").html(html);

                            $("#unit_table_modal").modal('show');
                        }

                    });
                }

                $('#search_wif_typing').on('change', '#counting_unit_select', function () {

                    // })
                    // $('#search_wif_typing #counting_unit_select').change(function() {
                    var id = $('#counting_unit_select').val();
                    var unitname = $(this).find(":selected").data('unitname');
                    var itemname = $(this).find(":selected").data('itemname');
                    var normalprice = $(this).find(":selected").data('normal');
                    var wholeprice = $(this).find(":selected").data('whole');
                    var orderprice = $(this).find(":selected").data('order');
                    var currentqty = $(this).find(":selected").data('currentqty');
                    var price_type = $('#price_type').val();
                    console.log(normalprice, wholeprice, orderprice);
                    if (price_type == 1) {
                        var saleprice = normalprice;
                    } else if (price_type == 2) {
                        var saleprice = wholeprice;
                    } else {
                        var saleprice = orderprice;
                    }

                    if (currentqty == 0) {

                        swal({
                            title: "Can't Add",
                            text: "Your Input is higher than Current Quantity!",
                            icon: "info",
                        });

                    } else {

                        var total_price = saleprice * 1;
                        var eachsub = saleprice * 1;
                        var item = {
                            id: parseInt(id),
                            item_name: itemname,
                            unit_name: unitname,
                            current_qty: currentqty,
                            order_qty: 1,
                            selling_price: saleprice,
                            each_sub: eachsub,
                            discount: 0
                        };

                        var total_amount = {
                            sub_total: total_price,
                            total_qty: 0,
                            vou_discount: 0,
                            total_price: 0,
                        };

                        var myOrderCart = localStorage.getItem('myOrderCart');

                        var grand_total = localStorage.getItem('orderGrandTotal');

                        if (myOrderCart == null) {

                            myOrderCart = '[]';

                            var myOrderCartobj = JSON.parse(myOrderCart);

                            myOrderCartobj.push(item);

                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                        } else {

                            var myOrderCartobj = JSON.parse(myOrderCart);

                            var hasid = false;

                            $.each(myOrderCartobj, function (i, v) {

                                if (v.id == id) {

                                    hasid = true;

                                    v.order_qty = parseInt(1) + parseInt(v.order_qty);
                                    v.each_sub = parseInt(v.selling_price) * parseInt(v.order_qty);
                                    console.log(v.each_sub);
                                }
                            })

                            if (!hasid) {

                                myOrderCartobj.push(item);
                            }

                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));
                        }

                        if (grand_total == null) {

                            localStorage.setItem('orderGrandTotal', JSON.stringify(total_amount));

                        } else {

                            var grand_total_obj = JSON.parse(grand_total);

                            grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                            grand_total_obj.total_qty = parseInt(grand_total_obj.total_qty);

                            localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));
                        }

                        $("#unit_table_modal").modal('hide');

                        // for a5 voucher
                        var myOrderCart = localStorage.getItem('myOrderCart');

                        var arr = [];

                        $('#lenn').html(myOrderCart);


                        // $.ajax({

                        //     type:'POST',

                        //     url:'/getItemForA5',

                        //     data:{
                        //         "_token":"{{ csrf_token() }}",
                        //         "items":myOrderCart,
                        //     },

                        //     success:function(data){
                        //         var arr_item = [];
                        //         arr_item.push(data);
                        //         console.log(data);
                        //         htmllen = "";
                        //         htmllen+=`${arr_item}`;
                        //         $('#lenn').html(data);

                        //     }
                        // });
                        var grand_total = localStorage.getItem('orderGrandTotal');

                        var grand_total_obj = JSON.parse(grand_total);
                        if (grand_total_obj.vou_discount == 0) {
                            var sub_total = grand_total_obj.sub_total;
                        } else {
                            var sub_total = grand_total_obj.vou_discount;
                        }
                        $('#voucher_total').val(sub_total);
                        $('#gtot').val(sub_total);
                        $('#with_dis_total').val(sub_total);
                        showmodal();
                    }
                })

                function tgPanel(id) {

                    var item_name = $('#item_name').val();

                    var item_price_check = $('#price_' + id).val();

                    var name = $('#name_' + id).text();

                    var qty_check = $('#qty_' + id).val();

                    var qty = parseInt(qty_check);

                    var price = parseInt(item_price_check);

                    if (item_price_check == "") {
                        swal({
                            title: "Please Check",
                            text: "Please Select Price To Sell",
                            icon: "info",
                        });
                    } else {
                        swal("Please Enter Quantity:", {
                            content: "input",
                        })
                            .then((value) => {
                                if (value.toString().match(/^\d+$/)) {
                                    if (value > qty) {
                                        swal({
                                            title: "Can't Add",
                                            text: "Your Input is higher than Current Quantity!",
                                            icon: "info",
                                        });
                                    } else {
                                        var total_price = price * value;
                                        var item = {
                                            id: id,
                                            item_name: item_name,
                                            unit_name: name,
                                            current_qty: qty,
                                            order_qty: value,
                                            selling_price: price
                                        };
                                        var total_amount = {
                                            sub_total: total_price,
                                            total_qty: value
                                        };
                                        var myOrderCart = localStorage.getItem('myOrderCart');
                                        var grand_total = localStorage.getItem('orderGrandTotal');
                                        //console.log(item);

                                        if (myOrderCart == null) {

                                            myOrderCart = '[]';

                                            var myOrderCartobj = JSON.parse(myOrderCart);

                                            myOrderCartobj.push(item);

                                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                                        } else {

                                            var myOrderCartobj = JSON.parse(myOrderCart);

                                            var hasid = false;

                                            $.each(myOrderCartobj, function (i, v) {

                                                if (v.id == id) {

                                                    hasid = true;

                                                    v.order_qty = parseInt(value) + parseInt(v.order_qty);
                                                }
                                            })

                                            if (!hasid) {

                                                myOrderCartobj.push(item);
                                            }

                                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));
                                        }

                                        if (grand_total == null) {

                                            localStorage.setItem('orderGrandTotal', JSON.stringify(total_amount));

                                        } else {

                                            var grand_total_obj = JSON.parse(grand_total);

                                            grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                                            grand_total_obj.total_qty = parseInt(grand_total_obj.total_qty);

                                            localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));
                                        }

                                        $("#unit_table_modal").modal('hide');

                                        showmodal();
                                    }
                                } else {
                                    swal({
                                        title: "Input Invalid",
                                        text: "Please only input english digit",
                                        icon: "info",
                                    });
                                }
                            })

                    }
                }

                function plus(id) {
                    var now_qty = parseInt($(`#nowqty${id}`).val());
                    count_change(id, 'plus', now_qty);
                    $(`#nowqty${id}`).focus();
                    var num = $(`#nowqty${id}`).val();
                    $(`#nowqty${id}`).focus().val('').val(num);

                }

                function minus(id) {

                    count_change(id, 'minus', 1);
                }

                function plusfive(id) {

                    count_change(id, 'plus', 5);
                }

                function minusfive(id) {

                    count_change(id, 'minus', 5);
                }

                function remove(id, qty) {
                    count_change(id, 'remove', qty)
                }

                function count_change(id, action, qty) {

                    var grand_total = localStorage.getItem('orderGrandTotal');

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var myOrderCartobj = JSON.parse(myOrderCart);

                    var grand_total_obj = JSON.parse(grand_total);

                    var item = myOrderCartobj.filter(item => item.id == id);

                    if (action == 'plus') {

                        if (qty > item[0].current_qty) {

                            swal({
                                title: "Can't Add",
                                text: "Stock မရှိပါ!",
                                icon: "info",
                            });

                            // $('#btn_plus_' + item[0].id).attr('disabled', 'disabled');
                        } else {

                            item[0].order_qty = qty;
                            if (parseInt(item[0].discount) == 0) {
                                item[0].each_sub = parseInt(item[0].selling_price) * qty;
                            } else {
                                item[0].each_sub = parseInt(item[0].discount) * qty;
                            }

                            new_total = 0;
                            new_total_qty = 0;
                            $.each(myOrderCartobj, function (i, value) {
                                new_total += value.each_sub;
                                new_total_qty += value.order_qty
                            })

                            grand_total_obj.sub_total = new_total;

                            grand_total_obj.total_qty = new_total_qty;

                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                            localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                            count_item();

                            showmodal();

                        }
                    } else if (action == 'minus') {

                        if (item[0].order_qty <= qty) {

                            //var ans=confirm('Are you sure');

                            swal({
                                title: "Are you sure?",
                                text: "The item will be remove from cart list",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Yes',
                                cancelButtonText: "No",
                                closeOnConfirm: false,
                                closeOnCancel: false
                            }).then(
                                function (isConfirm) {
                                    if (isConfirm) {

                                        let item_cart = myOrderCartobj.filter(item => item.id !== id);

                                        grand_total_obj.sub_total -= parseInt(item[0].selling_price) * qty;

                                        grand_total_obj.total_qty -= qty;

                                        console.log("yes");
                                        localStorage.setItem('myOrderCart', JSON.stringify(item_cart));

                                        localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                                        count_item();

                                        showmodal();

                                    } else {

                                        item[0].order_qty;
                                        console.log("no");
                                        localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                                        localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                                        count_item();

                                        showmodal();
                                    }
                                });


                        } else {
                            console.log("hello");
                            item[0].order_qty -= qty;

                            grand_total_obj.sub_total -= parseInt(item[0].selling_price) * qty;
                            item[0].each_sub -= parseInt(item[0].selling_price) * qty;
                            grand_total_obj.total_qty -= qty;

                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                            localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                            count_item();

                            showmodal();
                        }
                    } else if (action == 'remove') {
                        //var ans=confirm('Are you sure?');

                        swal({
                            title: "Are you sure?",
                            text: "The order will be remove from order list",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Yes',
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }).then(
                            function (isConfirm) {

                                if (isConfirm) {
                                    let item_cart = myOrderCartobj.filter(item => item.id !== id);
                                    console.log(item_cart);
                                    grand_total_obj.sub_total = grand_total_obj.sub_total - (parseInt(item[0].selling_price) *
                                        qty);

                                    grand_total_obj.total_qty = grand_total_obj.total_qty - qty;

                                    localStorage.setItem('myOrderCart', JSON.stringify(item_cart));

                                    localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                                    count_item();

                                    addOrder();

                                } else {
                                    item[0].order_qty;

                                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                                    localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                                    count_item();

                                    showmodal();
                                }
                            });

                        // if(ans){


                        // }else{


                        // }
                    }

                }

                function showmodal() {

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var orderGrandTotal = localStorage.getItem('orderGrandTotal');

                    var orderGrandTotal_obj = JSON.parse(orderGrandTotal);

                    if (myOrderCart) {

                        var myOrderCartobj = JSON.parse(myOrderCart);

                        var html = '';


                        if (myOrderCartobj.length > 0) {

                            $.each(myOrderCartobj, function (i, v) {

                                var id = v.id;

                                var item = v.item_name;

                                var qty = v.order_qty;

                                var count_name = v.unit_name;

                                if (v.discount == 0) {
                                    var selling_price = v.selling_price;
                                } else if (v.discount == 'foc') {
                                    var selling_price = 0;
                                } else if (v.discount == null) {
                                    var selling_price = null;
                                } else {
                                    var selling_price = v.discount;
                                }

                                var each_sub_total = v.order_qty * selling_price ?? 0;
                                // <i class="fa fa-plus-circle btnplus font-18" onclick="plusfive(${id})" id="${id}"></i>
                                // <i class="fa fa-minus-circle btnminus font-18   "  onclick="minusfive(${id})" id="${id}"></i>
                                html += `<tr class="text-center">


                            <td class="text-black">${count_name}</td>



                            <td class="text-black w-25 m-0 p-0" onkeyup="plus(${id})" id="${id}">
                                <input type="number" class="form-control w-100 text-black text-center p-0 mt-1" name="" id="nowqty${id}" value="${qty}" style="border: none;border-color: transparent;">
                            </td>

                            <td class="text-black w-25 m-0 p-0" data-price="${selling_price}" >
                                <input onkeyup="table_edit_price(${v.id},${selling_price})" type="number" class=" form-control w-100 text-black text-center p-0 mt-1" id="nowprice${id}" value="${selling_price}" style="border: none;border-color: transparent;">
                            </td>


                            <td class="text-black">${v.each_sub ?? 0}</td>
                            <td><i class="fa fa-times" onclick="remove(${id},${qty})" id="${id}"></i> </td>
                            </tr>`;

                            });
                        }

                        var htmlslip = "";
                        var id = $('#counting_unit_select').val();
                        $.each(myOrderCartobj, function (i, v) {
                            if (parseInt(v.discount) == 0) {
                                var selling_price = v.selling_price;
                            } else {
                                var selling_price = v.discount;
                            }
                            var totalslip = parseInt(selling_price) * parseInt(v.order_qty);
                            htmlslip += `
                         <tr>
                            <td style="font-size:15px;">${v.unit_name}</td>
                            <td style="font-size:15px;">${v.order_qty} * ${selling_price}</td>
                            <td style="font-size:15px;" id="subtotal">${totalslip}</td>
                        </tr>
                `;
                        });

                        if (orderGrandTotal_obj.vou_discount == 0) {
                            var sub_total = orderGrandTotal_obj.sub_total;
                            var total_wif_discount = orderGrandTotal_obj.sub_total;
                        } else if (orderGrandTotal_obj.vou_discount == "foc") {
                            var sub_total = orderGrandTotal_obj.sub_total;
                            var total_wif_discount = 0;

                        } else {
                            var sub_total = orderGrandTotal_obj.sub_total;
                            var total_wif_discount = orderGrandTotal_obj.sub_total - orderGrandTotal_obj.vou_discount;
                        }

                        $('#slip_live').html(htmlslip);
                        $('#total_charges').text(total_wif_discount);
                        var pay = $('#payable').val();


                        $("#total_quantity").text(orderGrandTotal_obj.total_qty);

                        $("#sub_total").text(total_wif_discount);
                        $('#gtot').val(sub_total);
                        $('#with_dis_total').val(total_wif_discount)

                        $("#sale").html(html);

                    }
                    show_a5();
                }


                function count_item() {

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    if (myOrderCart) {

                        var myOrderCartobj = JSON.parse(myOrderCart);

                        var total_count = 0;

                        $.each(myOrderCartobj, function (i, v) {

                            total_count += v.order_qty;

                        })

                        $(".item_count_text").html(total_count);

                    } else {

                        $(".item_count_text").html(0);

                    }
                }

                $('#sale').on('dblclick', '.editprice', function () {
                    var id = $(this).data('id');
                    var price = $(this).data('price');
                    $('#count_id').val(id);
                    $('#price_change').val(price);
                    $('#or_price').val(price);
                    console.log(id, price);
                    $('#editprice').modal("show");
                })

                $('#price_change_btn').click(function () {

                    var count_id = $('#count_id').val();
                    // alert(count_id);
                    var price_change = $('#price_change').val();
                    // alert(price_change);
                    var grand_total = localStorage.getItem('orderGrandTotal');

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var discart = localStorage.getItem('mydiscart');

                    var focflagcart = localStorage.getItem('myfocflag');

                    var hasdiscart = localStorage.getItem('myhasdis');

                    var myOrderCartobj = JSON.parse(myOrderCart);

                    var grand_total_obj = JSON.parse(grand_total);

                    var dis_cart_obj = JSON.parse(discart);

                    var foc_flag_obj = JSON.parse(focflagcart);

                    var has_dis_obj = JSON.parse(hasdiscart);

                    var foc = {
                        foc_flag: 1
                    };

                    var hasdis = {
                        hasdis: 1
                    };


                    $.each(dis_cart_obj, function (i, v) {
                        // alert(v.discount_flag);

                        var discart = localStorage.getItem('mydiscart');
                        var dis_cart_obj = JSON.parse(discart);

                        // alert(dis_cart_obj[i].id);
                        if (dis_cart_obj[i].id == count_id) {
                            // var dis={id:dis_cart_obj[i].id,item_name:dis_cart_obj[i].itemname,unit_name:dis_cart_obj[i].unitname,current_qty:dis_cart_obj[i].currentqty,order_qty:1,original_price:dis_cart_obj[i].saleprice,discount:price_change};

                            if (price_change == 0) {
                                dis_cart_obj[i].discount = price_change;
                                dis_cart_obj[i].different = parseInt(dis_cart_obj[i].original_price) - parseInt(
                                    price_change);
                                dis_cart_obj[i].discount_flag = 1;
                            } else {
                                dis_cart_obj[i].discount = price_change;
                                dis_cart_obj[i].different = parseInt(dis_cart_obj[i].original_price) - parseInt(
                                    price_change);
                                var hasdiscart = localStorage.getItem('myhasdis');
                                var has_dis_obj = JSON.parse(hasdiscart);
                                localStorage.setItem('myhasdis', JSON.stringify(hasdis));
                            }


                            localStorage.setItem('mydiscart', JSON.stringify(dis_cart_obj));
                            // alert("done");
                        }
                    });

                    if (price_change == 0) {
                        var focflagcart = localStorage.getItem('myfocflag');
                        var foc_flag_obj = JSON.parse(focflagcart);
                        localStorage.setItem('myfocflag', JSON.stringify(foc));
                    }

                    // alert(dis_cart_obj.length);
                    //discount cart


                    //End discount cart

                    var item = myOrderCartobj.filter(item => item.id == count_id);

                    grand_total_obj.sub_total -= parseInt(item[0].selling_price);

                    grand_total_obj.sub_total += parseInt(price_change);

                    // item[0].selling_price= parseInt(price_change);

                    item[0].each_sub = parseInt(price_change);

                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                    localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                    showmodal();

                    $('#editprice').modal("hide");

                })


                //clearLocalstorate in masterblade


                $('#percent_for_price').click(function () {
                    var idArray = [];
                    $("input:checkbox[name=percent_for_price]:checked").each(function () {
                        idArray.push(parseInt($(this).val()));
                    });
                    if (idArray.length > 0) {
                        $('#percent_price').removeAttr('disabled');
                        $('#percent_price').focus();
                    } else {
                        $('#percent_price').attr('disabled', 'disabled');
                    }
                    //    var percent_for_price=$('#percent_for_price').val();
                })
                // $('#percent_price').keyup(function() {
                //     var percent_price = $('#percent_price').val();
                //     var or_price = $('#or_price').val();
                //     var discount_amount = parseInt(or_price * (percent_price / 100));
                //     var change_percent_price = parseInt(or_price) + discount_amount;
                //     $('#discount_amount').html(discount_amount);
                //     $('#price_change').val(change_percent_price);
                // })

                $('#foc').click(function () {
                    var idArray = [];
                    $("input:checkbox[name=foc]:checked").each(function () {
                        idArray.push(parseInt($(this).val()));
                    });
                    var price_change = $('#price_change').val();
                    var or_price = $('#or_price').val();
                    if (idArray.length > 0) {
                        $('#price_change').val(0);
                    } else {
                        $('#price_change').val(or_price);
                    }
                    //    var percent_for_price=$('#percent_for_price').val();
                })

                function showCheckOut() {


                    var now_customer = $('#now_customer').val();

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var grand_total = localStorage.getItem('orderGrandTotal');

                    var discount = localStorage.getItem('mydiscart');

                    var focflag = localStorage.getItem('myfocflag');

                    var hasdis = localStorage.getItem('myhasdis');


                    if (!myOrderCart) {

                        swal({
                            title: "Please Check",
                            text: "Item Cannot be Empty to Check Out",
                            icon: "info",
                        });

                    } else {

                        $("#item").attr('value', myOrderCart);

                        $("#grand").attr('value', grand_total);

                        $('#right_now_customer').val(now_customer);

                        $('#discount').attr('value', discount);

                        $('#foc_flag').attr('value', focflag);

                        $('#has_dis').attr('value', hasdis);

                        $("#vourcher_page").submit();

                    }
                }

                function getCustomerInfo(value) {

                    $.ajax({

                        type: 'POST',

                        url: '/getCustomerInfo',

                        data: {
                            "_token": "{{ csrf_token() }}",
                            "customer_id": value,
                        },

                        success: function (data) {

                            $("#phone").val(data.phone);

                            $("#address").val(data.address);
                        },


                    });
                }

                function storeCustomerOrder() {
                    
                    var item = localStorage.getItem('myOrderCart');
                    var grand_total = localStorage.getItem('orderGrandTotal');
                    var edit_voucher = localStorage.getItem('editvoucher');
                    var customer_name = $('#customer_name').val();
                    var customer_phone = $('#customer_phone').val();
                    var customer_address = $('#customer_address').val();
                    var order_date = $('#order_date').val();
                    var payment_type = $('#payment_type').val();
                    var advance_pay = $('#advance_pay').val();
                    var delivery_fee = $('#delivery_fee').val();
                    var logo_fee = $('#logo_fee').val();
                    
                    var voucher_code = $("#voucherCode").val();
                    
                    var username = $('#userName').val();
                    
                    var showroom = $("#showroom").find(":selected").val();
                    //let id = $(`#ordercustomer_list`).find(":selected").val();
                    var id = $('#select_cusid').val();

                    if (!item || !grand_total) {

                        swal({
                            title: "@lang('lang.please_check')",
                            text: "@lang('lang.cannot_checkout')",
                            icon: "info",
                        });

                    } else {

                        $.ajax({
                            type: 'POST',
                            url: '{{ route('storeCustomerOrderv2') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item": item,
                                "grand_total": grand_total,
                                "customer_name": customer_name,
                                "customer_phone": customer_phone,
                                "customer_address": customer_address,
                                "order_date": order_date,
                                "payment_type": payment_type,
                                "advance_pay": advance_pay,
                                "delivery_fee": delivery_fee,
                                "logo_fee": logo_fee,
                                "showroom":  showroom,
                                "voucher_code": voucher_code,
                                "customer_id": id,
                                "user_name": username,
                                "edit_voucher" : edit_voucher ?? 0
                                
                            },

                            success: function (data) {

                                 swal({
                                     title: "Success",
                                     text: "Order is Successfully Stored",
                                     icon: "success",
                                 });
                                localStorage.removeItem('exitvoucher');
                                 localStorage.clear();
                                 localStorage.setItem('item-count', 0);
                                 setTimeout(function () {
                                     location.reload(true);
                                 }, 1000);

                            },

                            error: function (status) {
                                console.log(status.error);

                                swal({
                                    title: "Something Wrong!",
                                    text: "Something Wrong When Store Customer Order",
                                    icon: "error",
                                });
                            }
                        });

                    }
                }

                $('.pending-voucher').on('click', '.buttonrelative .deletevoucher', function () {
                    var now_customer = $('#now_customer').val();
                    var pendingvoucherno = $(this).data('pendingvoucherno');
                    var cartname = "myOrderCart_" + pendingvoucherno;
                    var grand_totalname = "orderGrandTotal_" + pendingvoucherno;

                    var local_customer = localStorage.getItem('local_customer_lists');
                    var local_customer_array = JSON.parse(local_customer);
                    $.each(local_customer_array, function (i, v) {
                        if (v == pendingvoucherno) {
                            local_customer_array.splice(i, 1);
                        }
                    })
                    localStorage.setItem('local_customer_lists', JSON.stringify(local_customer_array));
                    localStorage.removeItem(cartname);
                    localStorage.removeItem(grand_totalname);

                    if (now_customer == pendingvoucherno) {
                        localStorage.removeItem('myOrderCart');
                        localStorage.removeItem('orderGrandTotal');
                        $('.now_customer').hide();
                        $('#now_customer').val(0);
                        $('#total_quantity').empty();
                        $('#sub_total').empty();
                        $('#sale').empty();
                    }

                    local_customer_lists();
                    showmodal();


                });

                function local_customer_lists() {
                    var cust_name = $('#pending_cust').val();
                    if (cust_name) {
                        var cust = cust_name;

                        // alert("null");
                    } else {
                        var cust = "Customer";
                        // alert("has");
                    }
                    // alert(cust);
                    var local_customer_lists = localStorage.getItem('local_customer_lists');

                    var local_customer_array = JSON.parse(local_customer_lists);

                    $('.pending-voucher').empty();

                    $.each(local_customer_array, function (i, v) {

                        var btnpending = `

            <div class="buttonrelative mb-2">
                <button class="btn btn-warning mx-2" data-pendingvoucherno="${v}"><i class="fas fa-arrow-alt-circle-up"></i> ${cust} ${v}</button>
            <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${v}">x</p>
            </div>

            `;
                        $('.pending-voucher').append(btnpending);
                    })
                }

                $('.pending-voucher').on('click', '.buttonrelative button', function () {

                    var pendingvoucherno = $(this).data('pendingvoucherno');

                    $('#now_customer').val(pendingvoucherno);
                    $('#now_customer_no').text(pendingvoucherno);

                    $('.now_customer').show();
                    var cartname = "myOrderCart_" + pendingvoucherno;
                    var grand_totalname = "orderGrandTotal_" + pendingvoucherno;


                    var myOrderCart_pending_vocher = localStorage.getItem(cartname);

                    var grand_total_pending_voucher = localStorage.getItem(grand_totalname);

                    localStorage.setItem('myOrderCart', myOrderCart_pending_vocher);

                    localStorage.setItem("orderGrandTotal", grand_total_pending_voucher);

                    showmodal();

                })

                function storePendingVoucher() {
                    var cust_name = $('#pending_cust').val();
                    if (cust_name) {
                        var cust = cust_name;

                        // alert("null");
                    } else {
                        var cust = "Customer";
                        // alert("has");
                    }
                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var grand_total = localStorage.getItem('orderGrandTotal');

                    var nextvoucherno = parseInt(pendingvoucherno) + 1;

                    var now_customer = $('#now_customer').val();

                    var local_customer_lists = localStorage.getItem('local_customer_lists');
                    var local_last_customer_no = localStorage.getItem('last_customer_no');
                    if (!myOrderCart) {

                        swal({
                            title: "Please Check",
                            text: "Item Cannot be Empty to Store Voucher",
                            icon: "info",
                        });

                    } else {

                        if (now_customer == 0) {
                            // 0 means new customer

                            var last_customer_no = JSON.parse(local_last_customer_no);
                            var local_customer_obj = JSON.parse(local_customer_lists);

                            if (local_customer_obj) {
                                // console.log("not null ="+local_customer_obj.length);
                                // console.log("not nullllllll");
                                if (!local_customer_obj.length == 0) {
                                    console.log("!local_customer_obj.length==0");
                                    var pendingvoucherno = last_customer_no + 1;
                                } else {
                                    var pendingvoucherno = 1;
                                }
                            } else {
                                // console.log("in null"+local_customer_obj);
                                var pendingvoucherno = 1;
                                var local_customer_obj = [];
                            }

                            localStorage.setItem('last_customer_no', JSON.stringify(pendingvoucherno));
                            local_customer_obj.push(parseInt(pendingvoucherno));
                            localStorage.setItem('local_customer_lists', JSON.stringify(local_customer_obj));
                            var cartname = "myOrderCart_" + pendingvoucherno;
                            var grand_totalname = "orderGrandTotal_" + pendingvoucherno;

                            var btnpending = `
        <div class="buttonrelative mb-2">
            <button class="btn btn-warning mx-2" data-pendingvoucherno="${pendingvoucherno}"><i class="fas fa-arrow-alt-circle-up"></i> ${cust} ${pendingvoucherno}</button>
        <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${pendingvoucherno}">x</p>
        </div>

        `;
                            $('.pending-voucher').append(btnpending);
                        } else {
                            var cartname = "myOrderCart_" + now_customer;
                            var grand_totalname = "orderGrandTotal_" + now_customer;

                        }
                        localStorage.setItem(cartname, myOrderCart);
                        localStorage.setItem(grand_totalname, grand_total);

                        localStorage.removeItem('myOrderCart');
                        localStorage.removeItem('orderGrandTotal');
                        $('.now_customer').hide();
                        $('#now_customer').val(0);
                        $('#total_quantity').empty();
                        $('#sub_total').empty();
                        $('#sale').empty();
                        showmodal();

                    }

                    function local_customer_lists() {

                        var local_customer_lists = localStorage.getItem('local_customer_lists');

                        var local_customer_array = JSON.parse(local_customer_lists);

                        $('.pending-voucher').empty();

                        $.each(local_customer_array, function (i, v) {

                            var btnpending = `

            <div class="buttonrelative mb-2">
                <button class="btn btn-warning mx-2" data-pendingvoucherno="${v}"><i class="fas fa-arrow-alt-circle-up"></i> Customer${v}</button>
            <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${v}">x</p>
            </div>

            `;
                            $('.pending-voucher').append(btnpending);
                        })
                    }

                }

                function getCreditAmount(pay_amount) {

                    var total_charges = parseInt($('#with_dis_total').val());

                    var has_credit = parseInt($('#credit').val());
                    var previous_credit = $('#previous_credit').val();
                    // alert(total_charges);alert
                    if (pay_amount > total_charges) {
                        var credit_amt = 0;
                        $('#current_change').val(parseInt(pay_amount) - parseInt(total_charges));
                    } else {
                        var credit_amt = parseInt(total_charges) - parseInt(pay_amount);
                        var hascre = parseInt(previous_credit) + parseInt(credit_amt);
                    }
                    $('#pay').text(pay_amount);
                    $("#credit").val(hascre);
                    $('#current_credit').val(credit_amt);
                }

                function fillCustomer(value) {

                    var customer_id = value;
                    $('#select_cusid').val(customer_id);


                    $.ajax({
                        type: 'POST',
                        url: '{{ route('AjaxGetCustomerwID') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "customer_id": customer_id,
                        },
                        success: function (data) {
                            $("#name").val(data.sale_cust.name);
                            $("#custphone").val(data.sale_cust.phone);
                            $('#pending_cust').val(data.sale_cust.name);
                            //  $("#credit").val(data.credit_amount);
                            if (data.sale_credit != null) {
                                $('#credit').val(data.sale_cust.credit_amount);
                                $('#previous_credit').val(data.sale_cust.credit_amount);
                            } else {
                                $('#credit').val(0);
                                $('#previous_credit').val(0);
                            }
                        },
                    });
                }

                var last_row_id = 0;
                $("#save").click(function () {
                    var name = $('#customer_name').val();
                    var phone = $('#customer_phone').val();
                    var address = $('#customer_address').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('AjaxStoreOrderCustomer') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "name": name,
                            "phone": phone,
                            "address": address,
                        },
                        success: function (data) {
                            console.log(data.last_row);
                            if (data.success == 1) {
                                last_row_id = data.last_row.id;
                                $('#select_cusid').val(last_row_id);
                                //$lastRecord = DB::table('sales_customers')->orderBy('id', 'DESC')->first();

                            }
                            swal({
                                title: "Success!",
                                text: "Successfully Saved!",
                                icon: "success",
                            });
                        }
                    });

                });
                var salescustomer = null;

                $("#deletesaleuser").click(function() {
                    var ordercustomer_id = $('#ordercustomer_list').children("option:selected").val();
                    console.log(ordercustomer_id);
                    swal({
                        title: "@lang('lang.confirm')",
                        icon: 'warning',
                        buttons: ["@lang('lang.no')", "@lang('lang.yes')"]
                    })
                        .then((isConfirm) => {
                            if (isConfirm) {
                                $.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    url: '{{ route('orderCustomerDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "ordercustomer_id": ordercustomer_id,

                                    },
                                    success: function() {

                                        swal({
                                            title: "Success!",
                                            text: "Successfully Deleted!",
                                            icon: "success",
                                        });


                                    },
                                });
                            }


                        });
                });

                $(".store_voucher").click(function () {
                    // alert("hello");

                    var custphone = $('#custphone').val();

                    var from_id = $('#fid').val();

                    var exitvoucher = localStorage.getItem('exitvoucher');
                    if (exitvoucher == null) {
                        voucher_id = 0;
                    } else {
                        voucher_id = exitvoucher;
                    }


                    var salecustomer_id = $('#salescustomer_list').children("option:selected").val();

                    var now_customer = $('#now_customer').val();

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var grand_total = localStorage.getItem('orderGrandTotal');
                    var editvoucher = localStorage.getItem('editvoucher');

                    var item = myOrderCart;
                    var grand = grand_total;
                    var discount = discount;
                    var voucher_code = $('#voucherCode').val();
                    var right_now_customer = now_customer;
                    var cus_pay = $('#payable').val();

                    // alert(vou_Dis);

                    var repaymentDate = $('#repaymentDate').val();

                    var name = $('#name').val();

                    var id = $('#salescustomer_list').children("option:selected").val();

                    var credit = $('#current_credit').val();
                    // alert(id);
                    if (!cus_pay) {
                        swal({
                            icon: 'error',
                            title: 'ပေးငွေ ထည့်ပါ!',
                            text: 'Customer Pay cannot be null!!!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                    } else if (id) {
                        // alert("in");
                        $.ajax({
                            type: 'POST',
                            url: '/testVoucher',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item": item,
                                "grand": grand,
                                "voucher_code": voucher_code,
                                "sales_customer_id": id,
                                "sales_customer_name": name,
                                "credit_amount": credit,
                                "repaymentDate": repaymentDate,
                                "voucher_id": parseInt(voucher_id),
                                "cus_pay": cus_pay,
                                "edit_voucher": editvoucher ?? 0,
                            },
                            success: function (data) {
                                if (data.status == 0) {
                                    swal({
                                        icon: 'error',
                                        title: 'မှားယွင်းနေပါသည်.',
                                        text: 'ပြန်စစ်ပါ..',
                                    })
                                } else {
                                    $('#voucherCode').val(data.voucher_code);
                                    $('.vou_code').empty();
                                    $('.vou_code').text(data.voucher_code);
                                    localStorage.setItem('exitvoucher', JSON.stringify(data.id));
                                    clearLocalstorage(right_now_customer);
                                    formReset();
                                    $('#counting_unit_select').empty();

                                    var item_html = ``;

                                    $.each(data.items, function (i, item) {

                                        if (item.counting_units) {
                                            $.each(item.counting_units, function (j, counting_unit) {

                                                $.each(counting_unit.stockcount, function (k,
                                                                                           stock) {

                                                    if (stock.from_id == from_id) {
                                                        stockcountt = stock.stock_qty;
                                                    }
                                                })
                                                item_html += `
                                    <option class="text-black" data-unitname="${counting_unit.unit_name}"
                                        data-itemname="${item.item_name}"
                                        data-normal="${counting_unit.normal_sale_price}"
                                        data-whole="${counting_unit.whole_sale_price}"
                                        data-order="${counting_unit.order_price}" data-currentqty="${stockcountt}"
                                        value="${counting_unit.id}">${counting_unit.unit_code}-
                                        ${counting_unit.unit_name}&nbsp;&nbsp; ${stockcountt}ခု&nbsp;&nbsp;
                                        ${counting_unit.normal_sale_price}ကျပ်</option>
                                    `;
                                            })
                                        }

                                    })
                                    var main_html = `
                                <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                                <option></option>` + item_html + `
                                </select>
                                `;

                                    $('#search_wif_typing').html(main_html);

                                    $("#search_wif_typing .select").select2({
                                        placeholder: "ရှာရန်",
                                    });
                                    swal({
                                        icon: 'success',
                                        title: 'သိမ်းဆည်းပြီး!',
                                        text: 'Voucher သိမ်းဆည်းပြီးပါပြီ!!',
                                        button: false,
                                        timer: 1500,
                                    })
                                }


                            }
                        });
                    } else {
                        //last_row_id
                        // alert("out");
                        $.ajax({
                            type: 'POST',
                            url: '/testVoucher',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item": item,
                                "grand": grand,
                                "voucher_code": voucher_code,
                                "sales_customer_id": last_row_id,
                                "sales_customer_name": name,
                                "credit_amount": credit,
                                "voucher_id": parseInt(voucher_id),
                                "cus_pay": cus_pay,
                                "editvoucher": editvoucher ?? 0,
                            },
                            success: function (data) {
                                if (data.status == 0) {
                                    swal({
                                        icon: 'error',
                                        title: 'မှားယွင်းနေပါသည်.',
                                        text: 'ပြန်စစ်ပါ..',
                                    })
                                } else {
                                    $('#voucherCode').val(data.voucher_code);
                                    $('.vou_code').empty();
                                    $('.vou_code').text(data.voucher_code);
                                    localStorage.setItem('exitvoucher', JSON.stringify(data.id));
                                    clearLocalstorage(right_now_customer);
                                    formReset();
                                    $('#counting_unit_select').empty();

                                    var item_html = ``;

                                    $.each(data.items, function (i, item) {

                                        if (item.counting_units) {
                                            $.each(item.counting_units, function (j, counting_unit) {

                                                $.each(counting_unit.stockcount, function (k,
                                                                                           stock) {

                                                    if (stock.from_id == from_id) {
                                                        stockcountt = stock.stock_qty;
                                                    }
                                                })
                                                item_html += `
                                    <option class="text-black" data-unitname="${counting_unit.unit_name}"
                                        data-itemname="${item.item_name}"
                                        data-normal="${counting_unit.normal_sale_price}"
                                        data-whole="${counting_unit.whole_sale_price}"
                                        data-order="${counting_unit.order_price}" data-currentqty="${stockcountt}"
                                        value="${counting_unit.id}">${counting_unit.unit_code}-
                                        ${counting_unit.unit_name}&nbsp;&nbsp; ${stockcountt}ခု&nbsp;&nbsp;
                                        ${counting_unit.normal_sale_price}ကျပ်</option>
                                    `;
                                            })
                                        }

                                    })
                                    var main_html = `
                    <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                        <option></option>` + item_html + `
                    </select>
                            `;

                                    $('#search_wif_typing').html(main_html);

                                    $("#search_wif_typing .select").select2({
                                        placeholder: "ရှာရန်",
                                    });

                                    swal({
                                        icon: 'success',
                                        title: 'သိမ်းဆည်းပြီး!',
                                        text: 'Voucher သိမ်းဆည်းပြီးပါပြီ!!',
                                        button: false,
                                        timer: 1500,
                                    })
                                }

                            }
                        });
                        //end last_row_id
                    }
                });
                $("#repaymentDate").datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                // Begin Print

                $("#print").click(function(){
                    var item = localStorage.getItem('myOrderCart');
                    var grand_total = localStorage.getItem('orderGrandTotal');
                    var edit_voucher = localStorage.getItem('editvoucher');
                    var customer_name = $('#customer_name').val();
                    var customer_phone = $('#customer_phone').val();
                    var customer_address = $('#customer_address').val();
                    var order_date = $('#order_date').val();
                    var payment_type = $('#payment_type').val();
                    var advance_pay = $('#advance_pay').val();
                    var delivery_fee = $('#delivery_fee').val();
                    var logo_fee = $('#logo_fee').val();
                    var voucher_code = $("#voucherCode").val();
                    
                    var username = $('#userName').val();
                    
                    var showroom = $("#showroom").find(":selected").val();
                    //let id = $(`#ordercustomer_list`).find(":selected").val();
                    var id = $('#select_cusid').val();



                    if (!item || !grand_total) {

                        swal({
                            title: "@lang('lang.please_check')",
                            text: "@lang('lang.cannot_checkout')",
                            icon: "info",
                        });

                    } else {

                        $.ajax({

                            type: 'POST',

                            url: '/storeCustomerOrderv2',

                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item": item,
                                "grand_total": grand_total,
                                "customer_name": customer_name,
                                "customer_phone": customer_phone,
                                "customer_address": customer_address,
                                "order_date": order_date,
                                "payment_type": payment_type,
                                "advance_pay": advance_pay,
                                "delivery_fee": delivery_fee,
                                "logo_fee": logo_fee,
                                "showroom":  showroom,
                                "voucher_code": voucher_code,
                                "customer_id": id,
                                "user_name" : username,
                                "edit_voucher" : edit_voucher ?? 0

                            },

                            success: function (data) {

                                swal({
                                     title: "Success",
                                     text: "Order is Successfully Stored",
                                     icon: "success",
                                 });

                                var mode = 'iframe'; //popup
                                    var close = mode == "popup";
                                    var options = {
                                        mode: mode,
                                        popClose: close
                                    };
                                    $(".tab-pane.active div.printableArea").printArea(options);
                                    localStorage.removeItem('exitvoucher');
                                    localStorage.clear();
                                localStorage.setItem('item-count', 0);
                               setTimeout(function () {
                                    location.reload(true);
                                }, 1000);

                            },

                            error: function (status) {
                                console.log(status.error);

                                swal({
                                    title: "Something Wrong!",
                                    text: "Something Wrong When Store Customer Order",
                                    icon: "error",
                                });
                            }
                        });

                    }
                });



                function formReset() {

                    $('#sale').empty();
                    $('#total_quantity').empty();
                    $('#sub_total').empty();
                    $('#credit').val("");
                    $('#gtot').val(0);
                    $('#with_dis_total').val(0);
                    $('#payable').val("");
                    $('#current_credit').val("");
                    $('#current_change').val(0);
                    $('#discount_amount').val(0);
                }

                function orderFormReset() {


                    $('#total_quantity').val(0);
                    $('#sub_total').val(0);
                    $('#gtot').val(0);
                    $('#with_dis_total').val(0);
                    $('#discount_amount').val(0);

                    $('#customer_name').val('');
                    $('#customer_name').placeholder = "Name";
                    $('#customer_phone').val('');
                    $('#customer_phone').placeholder = "09";
                    $('#customer_address').val('');
                    $('#customer_address').placeholder = "Address";
                    $('#advance_pay').val(0);
                    $('#delivery_fee').val(0);
                    $('#logo_fee').val(0);
                    showOrderItem();


                }

                function insert_total() {
                    var grand_total = localStorage.getItem('orderGrandTotal');

                    var grand_total_obj = JSON.parse(grand_total);
                    $('#voucher_total').val(grand_total_obj.sub_total);
                    $('#vou_price_change').val(0);
                    $('#voudiscount').modal('show');
                }

                $('#vou_price_change_btn').click(function () {


                    var grand_total = localStorage.getItem('orderGrandTotal');

                    var grand_total_obj = JSON.parse(grand_total);

                    var price_change = $('#discount_price').val();
                    let delivery_fee = $('#delivery_fee').val();
                    let logo_fee = $('#logo_fee').val();
                    var percent_price = $('#vou_percent_price').val();
                    // var price_change = $('#vou_price_change').val();
                    if ($('#voufoc').is(':checked')) {
                        var totaL = 0;
                        var discount_amount = $("#gtot").val();
                        $("#discount_amount").val(price_change);
                        grand_total_obj.total_discount_type = "foc";
                        grand_total_obj.total_discount_value = discount_amount;

                    } else if (percent_price) {
                        var totaL = $('#gtot').val();
                        var discount_percent = parseInt(totaL) * parseInt(percent_price) / 100;
                        var discount_amount = totaL - discount_percent;
                        // $('#discount_amount').val(percent_price + '%');
                        $('#discount_amount').val(price_change);
                        grand_total_obj.total_discount_type = "percent";
                        grand_total_obj.total_discount_value = discount_percent;
                    } else {
                        var totaL = $('#gtot').val();
                        
                        var discount_amount = price_change;
                        $('#discount_amount').val(price_change);
                        grand_total_obj.total_discount_type = "amount";
                        grand_total_obj.total_discount_value = price_change;

                    }

                    // grand_total_obj
                   
                        $('#with_dis_total').val((grand_total_obj.sub_total + parseInt(delivery_fee) + parseInt(logo_fee)) - grand_total_obj.total_discount_value);
                    
                    // $('#sub_total').empty();

                    // $('#sub_total').text(parseInt(price_change));

                    $('#total_charges_a5').empty();
                    $('#total_charges_a5').text(parseInt(price_change));
                    $('#total_charges').empty();
                    $('#total_charges').text(parseInt(price_change));

                    localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                    $('#voudiscount').modal('hide');

                })

                function table_edit_price(id, old_price) {

                    var price_change = parseInt($(`#nowprice${id}`).val());
                    
                    console.log(price_change);

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var grand_total = localStorage.getItem('orderGrandTotal');

                    var myOrderCartobj = JSON.parse(myOrderCart);

                    var grand_total_obj = JSON.parse(grand_total);

                    var item = myOrderCartobj.filter(item => item.id == id);

                    if (price_change == 0) {
                        item[0].discount = 'foc';
                    } else if (!price_change) {
                        item[0].discount = null;
                    } else {
                        item[0].discount = price_change;
                    }

                    item[0].each_sub = item[0].order_qty * price_change ?? 0;

                    new_total = 0;
                    new_total_qty = 0;
                    $.each(myOrderCartobj, function (i, value) {
                        if (value.discount == 0) {
                            var price = value.selling_price;
                        } else if (value.discount == 'foc') {
                            var price = 0;
                        } else {
                            var price = value.discount;
                        }
                        new_total += parseInt(value.order_qty) * parseInt(price);
                        new_total_qty += value.order_qty;
                    })

                    grand_total_obj.sub_total = new_total;

                    grand_total_obj.total_qty = new_total_qty;

                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                    localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));

                    // count_item();

                    showmodal();

                    var num = $(`#nowprice${id}`).val();
                    $(`#nowprice${id}`).focus().val('').val(num);
                }


                $('#voufoc').click(function () {
                    // alert($("input:checkbox[name=foc]:checked").val());

                    var price_change = $('#vou_price_change').val();
                    var or_price = $('#voucher_total').val();
                    if ($("input:checkbox[name=voufoc]:checked").val() == 1) {
                        $('#discount_price').val(or_price);
                    } else {
                        $('#discount_price').val(0);
                    }
                    //    var percent_for_price=$('#percent_for_price').val();
                })
                $('#vou_percent_for_price').click(function () {
                    var idArray = [];
                    $("input:checkbox[name=vou_percent_for_price]:checked").each(function () {
                        idArray.push(parseInt($(this).val()));
                    });
                    if (idArray.length > 0) {
                        $('#vou_percent_price').removeAttr('disabled');
                        $('#vou_percent_price').focus();
                    } else {
                        $('#vou_percent_price').attr('disabled', 'disabled');
                    }
                    //    var percent_for_price=$('#percent_for_price').val();
                })
                $('#vou_percent_price').keyup(function() {
                    var percent_price = $('#vou_percent_price').val();
                    var or_price = $('#voucher_total').val();
                    var discount_amount = parseInt(or_price * (percent_price/100));
                    var change_percent_price = parseInt(or_price) + discount_amount;
                    $('#vou_discount_amount').html(discount_amount);
                    $('#discount_price').val(discount_amount);
                });

                //     let gtot = $('#gtot').val();
                //     // alert(percent_price+"---"+or_price);
                //     var discount_amount = parseInt(gtot) * parseInt(percent_price) / 100;
                //     // var discount_amount = parseInt( gtot * (percent_price / 100));
                //     var grand_total = localStorage.getItem('orderGrandTotal');
                //     var grand_total_obj = JSON.parse(grand_total);
                //     let vou_discount = grand_total_obj.vou_discount;
                //     vou_discount = gtot - discount_amount;
                //     localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));
                //     $('#with_dis_total').val(vou_discount);
                //
                //     // var change_percent_price = parseInt(or_price) + discount_amount;
                //     // $('#vou_discount_amount').html(discount_amount);
                //     // $('#vou_price_change').val(change_percent_price);
                // })

                $('#delivery_fee').focusout(function () {
                    let value1 = 0;
                    let value2 = 0;
                    var price_change = $('#discount_amount').val();
                    var grand_total = localStorage.getItem('orderGrandTotal');
                    var delivery_fee = parseInt($('#delivery_fee').val());
                    var logo_fee = parseInt($('#logo_fee').val());
                    var grand_total_obj = JSON.parse(grand_total);
                    

                        total_value = (grand_total_obj.sub_total + delivery_fee +logo_fee) - price_change;
                        
                        $('#with_dis_total').val(total_value);
                    

                })
                
                $('#logo_fee').focusout(function () {
                    let value1 = 0;
                    let value2 = 0;
                    var price_change = $('#discount_amount').val();
                    var grand_total = localStorage.getItem('orderGrandTotal');
                    var delivery_fee = parseInt($('#delivery_fee').val());
                    var logo_fee = parseInt($('#logo_fee').val());
                    var grand_total_obj = JSON.parse(grand_total);
                        total_value = (grand_total_obj.sub_total + delivery_fee + logo_fee) - price_change;
                        $('#with_dis_total').val(total_value);
                })

                function show_a5() {
                    $("#a5_body").empty();
                    let customer_name = $("#customer_name").val();
                    let customer_phone = $("#customer_phone").val();
                    var grand_total = localStorage.getItem('orderGrandTotal');
                    var grand_total_obj = JSON.parse(grand_total);
                    let delivery_fee = $("#delivery_fee").val();
                    let logo_fee = $("#logo_fee").val();
                    
                    let total_amount = grand_total_obj.sub_total + parseInt(delivery_fee) + parseInt(logo_fee);
                    let net_amount = total_amount - grand_total_obj.total_discount_value;
                    let advance_pay = $("#advance_pay").val();
                    let balance = net_amount-advance_pay;
                    let total_charges = grand_total_obj.sub_total;
                    $("#cus_name").text(customer_name);
                    $("#cus_phone").text(customer_phone);

                    var k = 1;
                    var myOrderCart = localStorage.getItem('myOrderCart');
                    var myOrderCartobj = JSON.parse(myOrderCart);
                    //Begin A5 Voucher

                    var len = myOrderCartobj.length;
                    var htmlcountitem = "";
                    var j = 1;

                    var i = 1;
                    var each_sub_total = 0;
                    let customer_address = $("#customer_address").val();
                    

                    $.each(myOrderCartobj, function (i, value) {
                        {{--$.ajax({--}}
                            {{--    type: 'POST',--}}
                            {{--    url: '/getSpecId',--}}
                            {{--    data: {--}}
                            {{--        "_token": "{{ csrf_token() }}",--}}
                            {{--        "fabric_id": value.fabric_id,--}}
                            {{--    },--}}

                            {{--    success: function(data) {--}}
                            {{--        console.log(data);--}}
                            {{--        data.data.forEach(el=>{--}}
                            {{--            rows += `<td style="font-size:13px;height: 25px; border: 1px solid black;">${el.fabric_name}</td>`--}}
                            {{--        })--}}
                            {{--    },--}}


                            {{--});--}}

                        <!--if (value.discount == 0) {-->
                        <!--    var selling_price = value.selling_price;-->
                        <!--} else if (value.discount == 'foc') {-->
                        <!--    var selling_price = 0;-->
                        <!--} else if (value.discount == null) {-->
                        <!--    var selling_price = value.selling_price;-->
                        <!--} else {-->
                        <!--    var selling_price = value.discount;-->
                        <!--}-->

                        <!--var each_sub_total = value.order_qty * selling_price ?? 0;-->

                        htmlcountitem += `
                <tr>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${(i++) + 1}</td>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${value.design_name} ${value.fabric_name}</td>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${value.color_name}</td>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${value.size_name}</td>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${value.order_qty} </td>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${value.selling_price} </td>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${value.discount_value} </td>
                <td style="font-size:13px;height: 25px; border: 1px solid black;">${value.each_sub} </td>
            </tr>
                `;
                    })
                    htmlcountitem += `
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2" style="font-size:15px;height: 25px; border: 1px solid black;">Total Amount</td>
                    <td style="font-size:15px;height: 25px; border: 1px solid black;">
                        ${total_amount}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>

                    <td colspan="2" style="font-size:15px;height: 25px; border: 1px solid black;">Discount</td>
                    <td style="font-size:15px;height: 25px; border: 1px solid black;">
                        ${grand_total_obj.total_discount_value}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2" style="font-size:15px;height: 25px; border: 1px solid black;">Net Amount</td>
                    <td style="font-size:15px;height: 25px; border: 1px solid black;">
                        ${net_amount}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-left" style="font-size:15px;height: 25px;">Remark :</td>
                    <td colspan="2" style="font-size:15px;height: 25px;">

                    </td>
                    <td colspan="2" style="font-size:15px;height: 10px; border: 1px solid black;">Advance</td>
                    <td style="font-size:15px;height: 10px; border: 1px solid black;">
                        ${advance_pay}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-left" style="font-size:15px;height: 25px;">Customer Address :</td>
                    <td colspan="2" style="font-size:15px;height: 25px;">
                        <span>${customer_address}</span>
                    </td>
                    <td colspan="2" style="font-size:15px;height: 10px; border: 1px solid black;">Balance</td>
                    <td style="font-size:15px;height: 10px; border: 1px solid black;">
                        ${balance}</td>
                </tr>

            `;
                    $("#a5_body").html(htmlcountitem);
                    //End A5 Voucher
                }

                // Add Order Function
                function addOrder() {
                    let itemid = 1;
                    let itemcount = localStorage.getItem('item_count');
                    if (itemcount != null) {
                        itemcount = parseInt(itemcount) + 1;
                        itemid = itemcount;
                    } else {
                        itemcount = itemid;
                    }
                    localStorage.setItem('item_count', itemcount);
                    var itemname = "";
                    var designid = 0;
                    var design_name = "";
                    var fabricid = 0;
                    var fabric_name = "";
                    var colorid = 0;
                    var color_name = "";
                    var sizeid = 0;
                    var size_name = "";
                    var genderid = 0;
                    var gender_name = "";
                    var orderqty = 0;
                    var sellingprice = 0;
                    var discount_type = "";
                    var discount_value = 0;
                    var eachsub = 0;
                    var is_discount = false;

                    var total_price = sellingprice * 1;
                    var total_discount_type = "";
                    var total_discount_value = 0;
                    var eachsub = sellingprice * 1;
                    var order_item = {
                        id: itemid,
                        item_name: itemname,
                        design_id: designid,
                        design_name: design_name,
                        fabric_id: colorid,
                        fabric_name: fabric_name,
                        color_id: colorid,
                        color_name: color_name,
                        size_id: sizeid,
                        size_name: size_name,
                        gender_id: genderid,
                        gender_name: gender_name,
                        order_qty: orderqty,
                        selling_price: sellingprice,
                        each_sub: eachsub,
                        discount_type: discount_type,
                        discount_value: discount_value,
                        is_discount: is_discount,
                        oldunit_flag: false,
                        oldunit_id: 0,
                    };


                    var total_amount = {
                        sub_total: total_price,
                        total_qty: 0,
                        total_discount_type: total_discount_type,
                        total_discount_value: total_discount_value,
                    };

                    var myOrderCart = localStorage.getItem('myOrderCart');

                    var grand_total = localStorage.getItem('orderGrandTotal');

                    if (myOrderCart == null) {

                        myOrderCart = '[]';

                        var myOrderCartobj = JSON.parse(myOrderCart);

                        myOrderCartobj.push(order_item);

                        localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));

                    } else {

                        var myOrderCartobj = JSON.parse(myOrderCart);

                        var hasid = false;

                        $.each(myOrderCartobj, function (i, v) {

                            if (v.id == itemid) {

                                hasid = true;

                                v.order_qty = parseInt(1) + parseInt(v.order_qty);
                                v.each_sub = parseInt(v.selling_price) * parseInt(v.order_qty);
                                console.log(v.each_sub);
                            }
                        })

                        if (!hasid) {

                            myOrderCartobj.push(order_item);
                        }

                        localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartobj));
                    }

                    if (grand_total == null) {

                        localStorage.setItem('orderGrandTotal', JSON.stringify(total_amount));

                    } else {

                        var grand_total_obj = JSON.parse(grand_total);
                        grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;
                        grand_total_obj.total_qty = parseInt(grand_total_obj.total_qty);

                        localStorage.setItem('orderGrandTotal', JSON.stringify(grand_total_obj));
                    }
                    showOrderItem();
                }

                // Show Order Function
                function showOrderItem() {
                    var myOrderCart = localStorage.getItem('myOrderCart');
                    var orderGrandTotal = localStorage.getItem('orderGrandTotal');
                    if (myOrderCart) {
                        var myOrderCartobj = JSON.parse(myOrderCart);
                        var html = '';
                        if (myOrderCartobj.length > 0) {
                            $.each(myOrderCartobj, function (i, v) {
                                var id = v.id;
                                var item = v.item_name;
                                var qty = v.order_qty;
                                var price = v.selling_price;
                                var each_sub_total = v.order_qty * price ?? 0;
                                html += `<tr class="text-center">
                            <td id="" style="">
                                <input style="width: 300px;font-size: 14px;color: black" type="text" name="item_name" id="item_name${id}" class="form-control border-0" onkeyup="addName(${id})" value="${item}">
                            </td>
                            <td class="text-center" style="width:25%">
                            <div class="d-flex justify-content-center">
                            <div class='card mb-0' style="width: 100px">
                                <select class="form-control select2" name="spec" id='spec${id}' onchange="showRelatedSpec(this.value,${id})">
                                    <option value="0">Specs</option>
                                    <option value="1">Design</option>
                                    <option value="2">Fabric</option>
                                    <option value="3">Colour</option>
                                    <option value="4">Size</option>
                                    <option value="5">Gender</option>
                                </select>
                            </div>
                            <div class='card mb-0 mx-1' style="width: 150px" >
                                <select id="specDetail${id}" class="form-control select2">
                                </select>
                            </div>
                            <div class="mx-2">
                                <button class="btn btn-primary" value='' onclick="specName(${id})">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                            </div>
                            </td>
                            <td style="" class="">
                                <input style="width: 100px" id='quantity${id}'  type="number" class="form-control text-dark border-0" value=${qty} onchange="addQuantity(${id})">
                            </td>
                            <td style="" class="">
                                <input style="width: 100px" type="number" class="form-control text-dark border-0" value=${price} id='price${id}' onfocusout="addPrice(${id})">
                            </td>
                            
                            <td style="" class="">
                                <input style="width: 100px" type="number" class="form-control text-dark border-0 w-75" id='discount${id}' value=${v.discount_value}>

                            </td>
                            
                            <td style="" class="">
                                <input style="width: 100px" type="number" class="form-control text-dark border-0 w-75" id='subTotal${id}' value=${v.each_sub}>

                            </td>

                            <td style="width: 10%" class="">
                                <button onclick="showDiscountModel(${id})"  class="btn btn-sm btn-outline-primary btn-rounded"
                                data-toggle="modal" id="#itemDiscount" data-target="#item_order_discount${id}">
                                %</button>
                            </td>
                            <td style="width:5%" class=""><i class="fa fa-trash-alt text-danger removeItem" onclick="removeItem(${id})" id="removeItem${id}"></i></td>
                            </tr>
`;
                            });
                        }
                        $('#order').html(html);
                    }

                }

                function showRelatedSpec(value, id) {
                    // console.log(value+id)
                    let option1 = `
                @foreach(\App\Design::all() as $design)
                    <option id='design' value="{{$design->id}}" name='design_name'>{{$design->design_name}}</option>
                @endforeach
                    `;
                    let option2 = `
                @foreach(\App\Fabric::all() as $fabric)
                    <option id='fabric' value="{{$fabric->id}}" name='fabric_name'>{{$fabric->fabric_name}}</option>
                @endforeach
                    `;
                    let option3 = `
                @foreach(\App\Colour::all() as $colour)
                    <option id='colour' value="{{$colour->id}}" name='colour_name'>{{$colour->colour_name}}</option>
                @endforeach
                    `;
                    let option4 = `
                @foreach(\App\Size::all() as $size)
                    <option id='size' value="{{$size->id}}" name="size_name">{{$size->size_name}}</option>
                @endforeach
                    `;
                    let option5 = `
                @foreach(\App\Gender::all() as $gender)
                    <option id='gender' value="{{$gender->id}}" name="size_name">{{$gender->gender_name}}</option>
                @endforeach
                    `;
                    if (value == 1) {
                        $(`#specDetail${id}`).html(option1);
                    } else if (value == 2) {
                        $(`#specDetail${id}`).html(option2);
                    } else if (value == 3) {
                        $(`#specDetail${id}`).html(option3);
                    } else if (value == 4) {
                        $(`#specDetail${id}`).html(option4);
                    } else if (value == 5) {
                        $(`#specDetail${id}`).html(option5);
                    }
                }

                function specName(id) {
                    let specInfo = $(`#specDetail${id}`).find(":selected").text();
                    let type = $(`#spec${id}`).find(":selected").val();
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let item = myOrderCartObj.filter(item => item.id == id);
                    // Specification Id
                    let designId = $(`#specDetail${id}`).find(":selected").filter('#design').val();
                    let fabricId = $(`#specDetail${id}`).find(":selected").filter('#fabric').val();
                    let colourId = $(`#specDetail${id}`).find(":selected").filter('#colour').val();
                    let sizeId = $(`#specDetail${id}`).find(":selected").filter('#size').val();
                    let genderId = $(`#specDetail${id}`).find(":selected").filter('#gender').val();
                    // Specification Name
                    let designName = $(`#specDetail${id}`).find(":selected").filter('#design').text();
                    let fabricName = $(`#specDetail${id}`).find(":selected").filter('#fabric').text();
                    let colourName = $(`#specDetail${id}`).find(":selected").filter('#colour').text();
                    let sizeName = $(`#specDetail${id}`).find(":selected").filter('#size').text();
                    let genderName = $(`#specDetail${id}`).find(":selected").filter('#gender').text();

                    item[0].item_name += specInfo + ' ';
                    if (type == 1) {
                        item[0].design_id = designId;
                        item[0].design_name = designName;
                    } else if (type == 2) {
                        item[0].fabric_id = fabricId;
                        item[0].fabric_name = fabricName;
                    } else if (type == 3) {
                        item[0].color_id = colourId;
                        item[0].color_name = colourName;
                    } else if (type == 4) {
                        item[0].size_id = sizeId;
                        item[0].size_name = sizeName;
                    } else if (type == 5) {
                        item[0].gender_id = genderId;
                        item[0].gender_name = genderName;
                    }
                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                    autoItemPrice(id);
                    showOrderItem();
                }

                function addQuantity(id) {
                    let qty = parseInt($(`#quantity${id}`).val());
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let item = myOrderCartObj.filter(item => item.id == id);
                    if(item[0].design_id == 0){
                        swal({
                                    title: "Specification Required",
                                    text: "Design Input Required",
                                    icon: "info",
                                });
                    }else if(item[0].fabric_id == 0){
                        swal({
                                    title: "Specification Required",
                                    text: "Fabric Input Required",
                                    icon: "info",
                                });
                    }else if(item[0].color_id == 0){
                        swal({
                                    title: "Specification Required",
                                    text: "Color Input Required",
                                    icon: "info",
                                });
                    }else if(item[0].size_id == 0){
                        swal({
                                    title: "Specification Required",
                                    text: "Size Input Required",
                                    icon: "info",
                                });
                    }else{
                    item[0].order_qty = qty;
                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                    subTotal(id);
                    calculateTotalQty();
                    calculateTotalPrice();
                    showOrderItem();
                    }
                }

                function addPrice(id) {
                    let price = parseInt($(`#price${id}`).val());
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let item = myOrderCartObj.filter(item => item.id == id);
                    item[0].selling_price = price;
                    item[0].each_sub = item[0].order_qty * item[0].selling_price;
                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                    $(`#subTotal${id}`).val(item[0].each_sub);
                    // $("#gtot").val(total.sub_total);
                    subTotal(id);
                    calculateTotalPrice();
                    // $("#gtot").val(orderGrandTotalObj.sub_total);
                    showOrderItem();
                }

                function subTotal(id) {
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let item = myOrderCartObj.filter(item => item.id == id);
                    item[0].each_sub = item[0].order_qty * item[0].selling_price;
                    localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                    calculateTotalPrice();
                    showOrderItem();
                    $(`#subTotal${id}`).val(item[0].each_sub);
                    calculateTotalPrice();
                    showOrderItem();
                }

                function calculateTotalQty() {
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let total = myOrderCartObj.reduce((pv, cv) => pv + cv.order_qty, 0);
                    let orderGrandTotal = localStorage.getItem('orderGrandTotal');
                    let orderGrandTotalObj = JSON.parse(orderGrandTotal);
                    orderGrandTotalObj.total_qty = total;
                    localStorage.setItem('orderGrandTotal', JSON.stringify(orderGrandTotalObj));
                    $("#total_quantity").text(orderGrandTotalObj.total_qty);
                }

                function calculateTotalPrice() {
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let totalPrice = myOrderCartObj.reduce((pv, cv) => pv + cv.each_sub, 0);
                    let orderGrandTotal = localStorage.getItem('orderGrandTotal');
                    let orderGrandTotalObj  = JSON.parse(orderGrandTotal);
                    orderGrandTotalObj.sub_total = totalPrice;
                    localStorage.setItem('orderGrandTotal', JSON.stringify(orderGrandTotalObj));
                    $("#sub_total").text(orderGrandTotalObj.sub_total);
                    $("#gtot").val(orderGrandTotalObj.sub_total);
                }


                function removeItem(id) {
                    var grand_total = localStorage.getItem('orderGrandTotal');
                    var myOrderCart = localStorage.getItem('myOrderCart');
                    var myOrderCartobj = JSON.parse(myOrderCart);
                    var grand_total_obj = JSON.parse(grand_total);
                    var item = myOrderCartobj.filter(item => item.id != id);
                    localStorage.setItem('myOrderCart', JSON.stringify(item));
                    calculateTotalQty();
                    calculateTotalPrice();
                    $("#removeItem" + id).parents("tr").remove();
                }

                function showDiscountModel(id) {
                    $(".showDiscount").attr("id", `item_order_discount${id}`);
                    //$(".itemDisAmount").attr("id", `item_discount_amount${id}`);
                    //$(".itemDisPercent").attr("id", `item_dis_percent${id}`);
                    $(".itemDiscountBtn").attr("id", `itemDiscountSave${id}`);
                    // $(".itemFoc").attr("id", `item_foc${id}`);
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let item = myOrderCartObj.filter(item => item.id == id);
                    $("#item_current_amount").val(item[0].each_sub);
                    console.log(item[0].each_sub);
                    $(`.itemDisAmount`).val(0);
                    $("#discount_id").val(id);

                    // console.log($(".showDiscount").attr("id"));
                }

                // function itemDiscountModel(id){
                //     // calculateTotalPrice();
                //     let myOrderCart = localStorage.getItem('myOrderCart');
                //     let myOrderCartObj = JSON.parse(myOrderCart);
                //     let item = myOrderCartObj.filter(item => item.id == id);
                //     console.table(item)
                //     $("#item_current_amount").val(item[0].each_sub);
                //     $('#sub_total').val();
                //     $("#discount_id").val(id);
                //     $('#itemDiscountModel').modal('discount');
                //
                // }
                const itemDisSave = (id) => {
                    console.log(id)
                }

                function amount_radio(value) {
                    let id = $("#discount_id").val();
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let item = myOrderCartObj.filter(item => item.id == id);
                    let dis_percent = $("#item_discount_percent").val();
                    let foc = $("#item_dis_foc").val();
                    let current_total = $("#item_current_amount").val();
                    if (value === "amount") {
                        $("#item_discount_amount").val(0);
                        $("#item_dis_amount_form").removeClass("d-none");
                        $("#item_dis_amount_form").show();
                        $("#item_dis_percent_form").hide(300);


                    } else if (value === "percent") {
                        $("#item_discount_percent").val(0);
                        $("#item_dis_percent_form").removeClass("d-none");
                        $("#item_dis_percent_form").show();
                        $("#item_dis_amount_form").hide(300);
                    } else if (value === "foc") {
                        $("#item_dis_amount_form").addClass("d-none");
                        $("#item_dis_percent_form").addClass("d-none");
                        var or_price = $('#item_current_amount').val();
                    
                    var discount_amount = or_price;
                    var change_percent_price = 0;
                    console.log(discount_amount, change_percent_price);
                    $('#discount_value').val(discount_amount);
                    $('#total_amount').val(change_percent_price);

                    }
                     $("#discount_type").val(value);
                }
                
                $('#item_discount_percent').keyup(function() {
                    var percent_price = $('#item_discount_percent').val();
                    console.log(percent_price);
                    var or_price = $('#item_current_amount').val();
                    // alert(percent_price+"---"+or_price);
                    var discount_amount = parseInt(or_price * (percent_price / 100));
                    var change_percent_price = parseInt(or_price) - discount_amount;
                    console.log(discount_amount, change_percent_price);
                    $('#discount_value').val(discount_amount);
                    $('#total_amount').val(change_percent_price);
                })
                
                $('#item_discount_amount').keyup(function() {
                    
                    var or_price = $('#item_current_amount').val();
                    // alert(percent_price+"---"+or_price);
                    var discount_amount = $('#item_discount_amount').val();
                    var change_percent_price = parseInt(or_price) - discount_amount;
                    console.log(discount_amount, change_percent_price);
                    $('#discount_value').val(discount_amount);
                    $('#total_amount').val(change_percent_price);
                })

                function autoItemPrice(id){
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    let item = myOrderCartObj.filter(item => item.id == id);
                    let design_id = item[0].design_id;
                    let fabric_id = item[0].fabric_id;
                    let colour_id = item[0].color_id;
                    $.ajax({
                        type: 'POST',
                        url: '/newOrderItemPrice',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "design_id": design_id,
                            "fabric_id": fabric_id,
                            "colour_id": colour_id,
                        },
                        success:function(data){
                            $("#price"+id).val(data);
                        }
                    });

                }

                // $("#itemDiscountSave").on("click",function (){
                //     let id = $("#discount_id").val();
                //     let dis_amount = $("#item_discount_amount").val();
                //     let dis_percent = $("#item_discount_percent").val();
                //     let foc = $("#item_dis_foc").val();
                //     let current_total = $("#item_current_amount").val();
                //     let dis_total = 0;
                //     let myOrderCart = localStorage.getItem('myOrderCart');
                //     let myOrderCartObj = JSON.parse(myOrderCart);
                //     let item = myOrderCartObj.filter(item => item.id == id);
                //     let amount_type =$("#item_dis_amount").val();
                //     let percent_type =$("#item_dis_percent").val();
                //     let foc_type =$("#item_foc").val();
                //     if(dis_amount){
                //         dis_total = Number(current_total) - dis_amount;
                //         item[0].discount_value = dis_amount;
                //         item[0].discount_type = amount_type;
                //     }else if(dis_percent){
                //         dis_total = Number(current_total) - (Number(current_total) * dis_percent ) / 100;
                //         item[0].discount_value = dis_percent;
                //         item[0].discount_type = percent_type;
                //     }else if(foc) {
                //         dis_total = 0;
                //         item[0].discount_value = 0;
                //         item[0].discount_type = foc_type;
                //     }
                //     item[0].each_sub = dis_total;
                //     $("#subTotal"+id).val(item[0].each_sub);
                //     localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                //     calculateTotalPrice();
                //     $("#discount-check"+id).html(`
                //     <span style="background: #00D398;color: white;" class="badge badge-pill">Discount</span>
                //     `)
                //
                // });

                function fillOrderCustomer(value) {

                    var customer_id = value;
                    $('#select_cusid').val(customer_id);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('AjaxGetOrderCustomerwID') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "customer_id": customer_id,
                        },
                        success: function(data) {
                            $("#customer_name").val(data.order_cust.name);
                            $("#customer_phone").val(data.order_cust.phone);
                            $("#customer_address").val(data.order_cust.address);
                        },
                    });
                }
                
                $("#itemDiscountSave").click(function (){
                    let id = $("#discount_id").val();
                    let type = $("#discount_type").val();
                    console.log(id,type);
                    
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    let orderGrandTotal = localStorage.getItem('orderGrandTotal');
                    let myOrderCartObj = JSON.parse(myOrderCart);
                    var orderGrandTotalObj = JSON.parse(orderGrandTotal);

                        
                    let item = myOrderCartObj.filter(item => item.id == id);
                    
                    if(type == 'amount'){
                        let dis_amount = $("#discount_value").val();
                        var change_amount = item[0].each_sub - dis_amount;
                            $.each(myOrderCartObj, function(i, v) {

                                if (v.id == id) {

                                    v.each_sub = change_amount;
                                    v.discount_type = type;
                                    v.discount_value = dis_amount;
                                    
                                        orderGrandTotalObj.sub_total = orderGrandTotalObj.sub_total - dis_amount;
                                       
                                }
                            })
                             $('#gtot').val(orderGrandTotalObj.sub_total);
                                        $('#sub_total').text(orderGrandTotalObj.sub_total);
                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                            localStorage.setItem('orderGrandTotal', JSON.stringify(orderGrandTotalObj));
                        showOrderItem();
                    }else if(type == 'percent'){
                       
                        var or_price = item[0].each_sub;
                    // alert(percent_price+"---"+or_price);
                    var dis_amount = $("#discount_value").val();
                    var change_amount = or_price - dis_amount;
                    $.each(myOrderCartObj, function(i, v) {

                                if (v.id == id) {

                                    v.each_sub = change_amount;
                                    v.discount_type = type;
                                    v.discount_value = dis_amount;
                                    
                                        orderGrandTotalObj.sub_total = orderGrandTotalObj.sub_total - dis_amount;
                                       
                                }
                            })
                             $('#gtot').val(orderGrandTotalObj.sub_total);
                                        $('#sub_total').text(orderGrandTotalObj.sub_total);
                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                            localStorage.setItem('orderGrandTotal', JSON.stringify(orderGrandTotalObj));
                             showOrderItem();
                    }else if(type == 'foc'){
                        var dis_amount = item[0].each_sub;
                        $.each(myOrderCartObj, function(i, v) {

                                if (v.id == id) {

                                    v.each_sub = 0;
                                    v.discount_type = type;
                                    v.discount_value = dis_amount;
                                    
                                        orderGrandTotalObj.sub_total = orderGrandTotalObj.sub_total - dis_amount;
                                        
                                }
                            })
                            $('#gtot').val(orderGrandTotalObj.sub_total);
                                        $('#sub_total').text(orderGrandTotalObj.sub_total);
                            localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                            localStorage.setItem('orderGrandTotal', JSON.stringify(orderGrandTotalObj));
                             showOrderItem();
                    }
                    
                    $('#itemDiscount').modal('hide');

                })

            </script>
@endsection

