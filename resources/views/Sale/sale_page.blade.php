@extends('master')

@section('title', 'Sale Page')

@section('place')
    <style>
        .editprice {
            cursor: pointer
        }

        .discount {
            cursor: pointer
        }

    </style>

@endsection

@section('content')
    @php
        $from_id = session()->get('from');
    @endphp

    <?php
    $itemss = '<span id="lenn"></span>';

    ?>


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
    <div class="row offset-1">
        <div class="col-12 d-flex justify-content-start align-items-center mb-3">
            <div class="col-md-4">
                <select style="width: 220px" name="category" class="form-control" id="category" onchange="searchSubCategory(this.value)">
                    <option value="">Category</option>
                    @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select style="width: 220px" name="subcategory" class="form-control" id="subcategory" onchange="searchCountingUnit(this.value)">
                    <option value="">Subcategory</option>
                    @foreach($sub_categories as $sub_category)
                        <option value="{{$sub_category->id}}">
                            {{$sub_category->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6 pr-0">
            <div class="row mt-1 mb-2">
                <label class="col-md-2 pl-4">အမျိုးအမည်</label>
                <div class="col-md-8 col-sm-12 d-block" id="search_wif_typing">
                    <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                        <option></option>
                        @foreach($counting_units as $counting_unit)
                            @if($counting_unit->current_quantity != 0)

                                <option class="text-black"  data-unitname="{{ $counting_unit->unit_name }}"
                                        data-design_name="{{$counting_unit->design->design_name??""}}"
                                        data-fabric_name="{{$counting_unit->fabric->fabric_name??""}}"
                                        data-color_name="{{$counting_unit->colour->colour_name??""}}"
                                        data-size_name="{{$counting_unit->size->size_name??""}}"
                                        data-normal="{{ $counting_unit->order_price ?? 0 }}"
                                        data-currentqty="{{ $counting_unit->current_quantity }}" value="{{ $counting_unit->id }}">
                                    {{ $counting_unit->unit_code }}-
                                    {{ $counting_unit->unit_name }}&nbsp;&nbsp; {{ $counting_unit->current_quantity }}ခု&nbsp;&nbsp;
                                    {{ $counting_unit->order_price }}ကျပ်</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 col-sm-12 d-none" id="search_wif_barcode">
                    <input class="form-control" type="text" onchange="QRcodeTest(this.value)" id="qr_code" autofocus>
                </div>
                <button onclick="qrSearch()"
                        class="col-md-1 btn-sm btn-success ml-4 pl-1 d-none d-sm-none d-md-block d-lg-block " style="padding:0">
                    <i class="fas fa-barcode p-0 text-white" style="font-size: 25px"></i>

                </button>
            </div>
        </div>
        <div class="col-md-5 mt-1 pl-0">
            <div class="row mt-1 mb-2">
                <label class="col-md-4 pl-4">Voucher Code: </label>
                <label class="col-md-4 font-weight-bold vou_code" id="voucher_code">{{$voucher_code}} </label>
            </div>
        </div>


        <div class="col-md-7 pr-0">

            {{-- refresh here --}}
            <div class="col-md-12 pr-0" style="">
                <div class="card" style="border-radius: 0px;min-height:100vh">
                    <div class="card-title">
                        <a href="" class="text-success px-2" onclick="deleteItems()"><i class="fas fa-sync"></i> Refresh
                            Here &nbsp</a>
                    </div>
                    <div class="card-body salepageheight">
                        <h5 class="now_customer text-warning">Customer <span id="now_customer_no"></span></h5>
                        <input type="hidden" name="now_customer" value="0" id="now_customer">

                        <div class="row justify-content-center">
                            <table class="table text-black table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <th class="text-black">@lang('lang.item') @lang('lang.name')</th>
                                    <th class="text-black">@lang('lang.quantity')</th>
                                    <th class="text-black">@lang('lang.price')</th>
                                    <th class="text-black">Discount</th>
                                    <th class="text-black">Sub Total</th>
                                </tr>
                                </thead>
                                <tbody id="sale">
                                <tr class="text-center">
                                    {{--                                        Discount Modal--}}
                                    <div class="modal fade" id="itemDiscount" role="dialog" aria-hidden="true">
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
                                                        <div class="row">
                                                        <label for="" class="font-weight-bold h6 text-secondary ">Current Amount : </label>
                                                        <h5 class="text-secondary font-weight-bold" id="item_current_amount"></h5>
                                                        </div>



                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-around mb-5" id="form-radio">
                                                        <div class="form-check  form-check-inline" >
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="item_dis_amount" value="amount" onclick="amount_radio(this.value)">
                                                            <label class="form-check-label" for="item_dis_amount">Amount</label>
                                                        </div>
                                                        <div class="form-check form-check-inline" >
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="item_dis_percent" value="percent" onclick="amount_radio(this.value)">
                                                            <label class="form-check-label" for="item_dis_percent">Percent( % )</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="item_foc" value="foc" onclick="amount_radio(this.value)">
                                                            <label class="form-check-label" for="item_foc">Foc</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="discount_id" >
                                                    <input type="hidden" id="discount_type" >
                                                    <div class="mb-3 d-none" id="item_dis_amount_form">
                                                        <label for="" class="font-weight-bold text-secondary ">Enter Discount Amount</label>
                                                        <input type="number" class="form-control w-75" id="item_discount_amount">
                                                    </div>
                                                    <div class="mb-3 d-none" id="item_dis_percent_form">
                                                        <label for="" class="font-weight-bold text-secondary ">Enter Discount Percent ( % )</label>
                                                        <input type="number" class="form-control w-75" id="item_discount_percent">
                                                    </div>
                                                    <input type="hidden" name="foc" value="foc" id="item_dis_foc">

                                                    <div class="mb-3">
                                                        <button id="itemDiscountSave" class="btn btn-outline-success btn-rounded">Discount</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </tr>
                                </tbody>
                                <tfoot>
                                <tr class="text-center">
                                    <td class="text-black" colspan="4">@lang('lang.total') @lang('lang.quantity')
                                    </td>
                                    <td class="text-black" id="total_quantity">0</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="text-black" colspan="4">@lang('lang.total')</td>
                                    <td class="text-black" id="sub_total">0</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row ml-2 justify-content-center">

                            <!-- <div class="col-md-8"> -->

                            <div class="modal fade" id="customer_order" role="dialog" aria-hidden="true">
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
                        <div class="row">
                            <label class="control-label text-black col-5">Customer Name</label>
                            <input type="hidden" id="pending_cust">
                            <select class="form-control text-black d-none d-sm-none d-md-block d-lg-block col-md-7"
                                    style="font-size: 14px" id="salescustomer_list" onchange="fillCustomer(this.value)">
                                <option value="" class="text-black" style="font-size: 14px">Select Customers</option>

                                @foreach ($salescustomers as $salescustomer)
                                    <option value="{{ $salescustomer->id }}">{{ $salescustomer->name }}</option>
                                @endforeach

                            </select>
                            <input type="text" class="form-control col-7 offset-md-5 font14 text-black" id="name"
                                   value="customer">
                        </div>
                        <div class="row my-1">
                            <label class="control-label text-black col-5 font14">Phone</label>
                            <input type="number" class="form-control col-7 font14 text-black" id="custphone" value="09"
                                   placeholder="09">
                        </div>

                         <div class="row my-1">
                            <label class="control-label text-black col-5 font14">Remark</label>
                            <input type="text" class="form-control col-7 font14 text-black" id="remark_input" value="remark"
                                   placeholder="remark">
                        </div>
                    </div>
                    <div class="">
                        <!--<div class="row">-->
                        <!--    <label class="control-label text-black col-5">အရင်ကြွေးကျန်</label>-->
                        <!--    <input type="number" class="form-control col-7 text-black" value="0" id="credit" readonly>-->
                        <!--    <input type="hidden" id="previous_credit" value="0">-->
                        <!--</div>-->
                        <!-- <div class="col-md-12">
                            <label class="text-info">Repayment Date </label>
                            <input type="text" class="form-control" id="repaymentDate" name="request_date">
                            </div> -->
                    </div><br>
                    <div class="row d-none d-sm-none d-md-block d-lg-block">
                        <div class="col-md-7 offset-md-5 pl-0">
                            <button id="save" class="btn btn-outline-secondary" type="button"><span><i
                                        class="fa fa-save mr-2"></i>Save</span></button>
                            <a href="#" class="btn btn-outline-danger mx-2" id="deletesaleuser"></i>
                                <i class="fas fa-trash-alt"></i></a>


                        </div>
                    </div>
                </div>
                <div class="card pl-2 pr-4 py-3" style="border-radius: 0px;margin-top:-9px">
                    <div class="row mb-2">
                        <label class="control-label  col-5 text-black">စုစုပေါင်း </label>
                        <input type="number" class="form-control col-7 h-75 text-black" id="gtot" value="0">
                    </div>
                    <div class="row mb-2">
                        <label class="control-label text-black col-5">Discount</label>
                        <input type="number" class="form-control col-4 h-75 text-black" id="discount_amount" readonly
                               value="0">
                        <div class="col-3">
                            <button id="voucher_discount" onclick="insert_total()" class="btn btn-secondary"
                                    type="button"><span><i class="fa fa-save mr-3"></i>Discount</span></button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="control-label text-black col-5">ကျသင့်ငွေ</label>
                        <input type="number" id="with_dis_total" class="form-control col-7 h-75 text-black">
                    </div>
                    <div class="row mb-2">
                        <label class="control-label text-black col-5">ပေးငွေ</label>
                        <input type="number" onkeyup="getCreditAmount(this.value)"
                               class="form-control col-7 h-75 text-black" id="payable">
                    </div>
                    <div class="row mb-2">
                        <label class="control-label  col-5 text-black">လက်ကျန်ငွေ</label>
                        <input type="number" class="form-control col-7 h-75 text-black" value="0" id="current_credit"
                               readonly>
                    </div>

                    <div class="row mb-2">
                        <label class="control-label  col-5 text-black">ပြန်အမ်းငွေ</label>
                        <input type="number" class="form-control col-7 h-75" value="0" id="current_change">
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
                                <span><i class="fas fa-eye"></i> Voucher</span> </button>
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
                                            <div class="col-md-12 printableArea" style="width:55%;">
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="text-center">
                                                                <address>
                                                                    <h5> &nbsp;<b
                                                                            class="text-center text-black">Medical World</b>
                                                                    </h5>

                                                                    <h6 class="text-black">No.28,Hlaing Yadanar Mon 3rd Street, Hlaing Yadanar Mon Avenue,
                                                                    </h6>
                                                                    <h6 class="text-black">
                                                                        Hlaing Township, Yangon</h6>
                                                                    <h6 class="text-black"><i
                                                                            class="fas fa-mobile-alt"></i> 09777005861, 09777005862</h6>
                                                                </address>
                                                            </div>
                                                            <div class="pull-right text-left">
                                                                <h6 class="text-black">Date : <i
                                                                        class="fa fa-calendar"></i> </h6>
                                                                <h6 class="text-black">Voucher Number : <span
                                                                        class="vou_code">{{ $voucher_code }}</span>
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="table-responsive text-black" style="clear: both;">
                                                                <table class="table table-hover">
                                                                    <thead>
                                                                    <tr class="text-black">
                                                                        <th>Name</th>
                                                                        <th>Qty*Price(Discount)</th>


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
                                                                            style="font-size:15px;">Total
                                                                        </td>
                                                                        <td id="total_charges" class="font-weight-bold"
                                                                            style="font-size:15px;"><span
                                                                                id="slip_total"></span>
                                                                        </td>
                                                                    </tr>

                                        <tr>
                                                                        <td></td>
                                                                        <td class="text-right"
                                                                            style="font-size:15px;">Discount</td>
                                                                        <td id="slip_discount" class="font-weight-bold" style="font-size:15px;"></td>
                                                                    </tr>

                                        <tr>
                                                                        <td></td>
                                                                        <td class="text-right"
                                                                            style="font-size:15px;">Net</td>
                                                                        <td id="slip_net" class="font-weight-bold" style="font-size:15px;"></td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="text-right"
                                                                            style="font-size:15px;">Pay</td>
                                                                        <td id="pay" class="font-weight-bold" style="font-size:15px;"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="text-right"
                                                                            style="font-size:15px;">Change
                                                                        </td>
                                                                        <td id="changes" class="font-weight-bold" style="font-size:15px;"></td>
                                                                    </tr>
                                                                    </tfoot>
                                                                </table>
                                                                <h6 class="text-center font-weight-bold text-black">
                                                                    **ကျေးဇူးတင်ပါသည်***</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="navpills-2" class="tab-pane ">
                                        <div class="row justify-content-center" id="a5_voucher">
                                            <div class="col-md-12">

                                                <div class="card card-body printableArea">
                                                    <div style="display:flex;justify-content:space-around">
                                                        <div class="col-md-12 text-center">
                                                            <div>
                                                                <img src="{{ asset('image/medical_world_logo_update.jpg') }}">
                                                            </div>

                                                            <div >

                                                                <p class="mt-2" style="font-size: 18px;">No.28,Hlaing Yadanar Mon 3rd Street, Hlaing Yadanar Mon Avenue, Hlaing Township, Yangon
                                                                    <br /><i class="fas fa-mobile-alt" style="font-size: 15px;"></i> 09777005861, 09777005862
                                                                </p>
                                                            </div>

                                                            <div>
                                                                <h2 class="text-center text-secondary font-weight-bold">Sale Voucher</h2>
                                                            </div>
                                                        </div>
                                                        <div></div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-end">


                                                        <div class="">
                                                            <h3 class=" mt-2 " style="font-size : 15px">
                                                                @lang('lang.invoice') @lang('lang.number') : <span
                                                                    class="vou_code">{{ $voucher_code }}</span>
                                                            </h3>

                                                            <h3 class=" mt-2 "
                                                                style="font-size : 15px;">@lang('lang.invoice')
                                                                @lang('lang.date')
                                                                : {{ $vou_date }} </h3>
                                                                <h3 class=" mt-2 "
                                                                style="font-size : 15px;">Cashier: {{ $sale_name }} </h3>
                                                        </div>
                                                        <div class="">
                                                            <h3 class=" mt-2 " style="font-size : 15px">Customer Name: <span id="cus_name"></span>
                                                            </h3>

                                                            <h3 class=" mt-2 " style="font-size : 15px">Customer Phone :
                                                                <span id="cus_phone"></span>
                                                            </h3>

                                                            <h3 class=" mt-2 "
                                                                style="font-size : 15px;">.</h3>

                                                        </div>

                                                    </div>



                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table style="width: 100%; ">
                                                                <thead class="text-center">
                                                                <tr>
                                                                    {{--                                                                        <th--}}
                                                                    {{--                                                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">--}}
                                                                    {{--                                                                            @lang('lang.number')</th>--}}
                                                                    {{--                                                                        <th--}}
                                                                    {{--                                                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">--}}
                                                                    {{--                                                                            @lang('lang.item')</th>--}}
                                                                    {{--                                                                        <th--}}
                                                                    {{--                                                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">--}}
                                                                    {{--                                                                            Qty</th>--}}
                                                                    {{--                                                                        <th--}}
                                                                    {{--                                                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">--}}
                                                                    {{--                                                                            @lang('lang.price')</th>--}}
                                                                    {{--                                                                        <th--}}
                                                                    {{--                                                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">--}}
                                                                    {{--                                                                            Sub @lang('lang.total')</th>--}}
                                                                    <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.number')</th>
                                                                    <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.item')</th>
                                                                    <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Fabric</th>
                                                                    <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Size</th>

                                                                    <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.order_voucher_qty')</th>
                                                                    <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.price')</th>

                                        <th style="font-size:14px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Discount</th>

                                                                    <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.total') Charge </th>

                                                                </tr>
                                                                </thead>
                                                                <tbody class="text-center" id="a5_body">
                                                                </tbody>
                                                            </table>
                                                            <div class="d-flex justify-content-between align-items-center my-5 px-3">
                                                                <div class="">
                                                                    <h5 class="font-weight-bold">PAID BY</h5>
                                                                    <p style="font-size: 13px">Signature :</p>
                                                                    <p style="font-size: 13px">Name :</p>
                                                                    <p style="font-size: 13px">Position :</p>

                                                                </div>
                                                                <div class="">
                                                                    <h5 class="font-weight-bold">RECEIVED BY</h5>
                                                                    <p style="font-size: 13px">Signature :</p>
                                                                    <p style="font-size: 13px">Name : {{session()->get('user')->name}}</p>
                                                                    <p style="font-size: 13px">Position :</p>
                                                                </div>
                                                                <div class="">
                                                                    <h5 class="font-weight-bold">APPROVED BY</h5>
                                                                    <p style="font-size: 13px">Signature :</p>
                                                                    <p style="font-size: 13px">Name :</p>
                                                                    <p style="font-size: 13px">Position :</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="row mt-2">

                            <div class="col-md-6 text-right">
                                <h3 class="text-info font-weight-bold" style="font-size:18px;">
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
                                class="fas fa-arrow-alt-circle-down"></i> @lang('lang.pending_voucher') </i>
                    </div>
                {{-- <div class="col-md-4 col-4 d-none"> --}}
                <!-- <i class="btn btn-success" onclick="showCheckOut()"><i class="fas fa-calendar-check"></i> @lang('lang.check_out') </i> -->
                    {{-- <a href="#show_vou" class="btn btn-success"><i class="fas fa-calendar-check"></i>
                            @lang('lang.check_out') </a>
                    </div> --}}
                    <div class="col-md-2">
                        <button id="print" class="ml-2 btn btn-success d-none d-sm-none d-md-block d-lg-block"
                                type="button">
                            <span><i class="fa fa-print"></i> Print</span> </button>
                    </div>
                    <div class="col-md-4 offset-4 d-block d-md-none d-lg-none store_voucher">
                        {{-- for mobile --}}
                        <button class="btn btn-danger " type="button"> <span><i class="fa fa-calendar-check"></i> Store
                                Voucher</span> </button>
                    </div>
                    <div class="col-md-4 d-none d-sm-none d-md-block d-lg-block ">
                        {{-- for web --}}
                        <button class="btn btn-danger store_voucher" type="button">
                            <span><i class="fa fa-calendar-check"></i> Store Voucher</span> </button>
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
                                <label class="form-control font-weight-bold">Voucher Total</label>
                                <input type="text" class="form-control" readonly id="voucher_total" value="">
                            </div>
                            <div class="form-check form-switch float-right">
                                <input class="form-check-input" name="voufoc" type="checkbox" id="voufoc" value="1">
                                <label class="form-check-label" for="voufoc">FOC</label>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Discount Total</label>
                                <input type="number" id="vou_price_change" class="form-control" required value="">
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
                                    btn-block">Change Price</button>
                        </div>


                    </div>
                </div>
            </div>
            <?php
            $username = session()->get('user')->name;

            ?>
            <input type="hidden" id="voucherCode" value="{{ $voucher_code }}">
            <input type="hidden" id="userName" value="{{$username}}">
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

                $(document).ready(function() {

                    $('#a5_last').hide();
                    $('#a5_middle').hide();

                    //     var mycart = localStorage.getItem('mycart');
                    //     setInterval(() => {
                    //     $.ajax({

                    //         type:'POST',

                    //         url:'/getItemForA5',

                    //         data:{
                    //             "_token":"{{ csrf_token() }}",
                    //             "items":mycart,
                    //         },

                    //         success:function(data){
                    //             console.log("10");
                    //         }
                    //     });
                    // },1000);
                    var mycart = localStorage.getItem('mycart');
                    var mycartobj = JSON.parse(mycart);
                    var arr = [];




                    $('.now_customer').hide();

                    local_customer_lists();
                    console.log($('#select_cusid').val());

                    var voucher_details = localStorage.getItem('voucher_details');

               if (voucher_details != null) {

                    var vdetail_obj = JSON.parse(voucher_details);
                    $('.vou_code').val(vdetail_obj.voucher_code);
                    $('#voucherCode').val(vdetail_obj.voucher_code);
                    $('#salescustomer_list').val(vdetail_obj.customer_id).change();
                    $('#name').val(vdetail_obj.customer_name);
                    $('#custphone').val(vdetail_obj.customer_phone);
                    $('#remark_input').val(vdetail_obj.remark);


               }
                showmodal();
                });

                function deleteItems() {
                    clearLocalstorage(0);
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

                        success: function(data) {

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

                                var mycart = localStorage.getItem('mycart');

                                var grand_total = localStorage.getItem('grandTotal');

                                if (mycart == null) {

                                    mycart = '[]';

                                    var mycartobj = JSON.parse(mycart);

                                    mycartobj.push(item);

                                    localStorage.setItem('mycart', JSON.stringify(mycartobj));

                                } else {

                                    var mycartobj = JSON.parse(mycart);

                                    var hasid = false;

                                    $.each(mycartobj, function(i, v) {

                                        if (v.id == id) {

                                            hasid = true;

                                            v.order_qty = parseInt(value) + parseInt(v.order_qty);
                                        }
                                    })

                                    if (!hasid) {

                                        mycartobj.push(item);
                                    }

                                    localStorage.setItem('mycart', JSON.stringify(mycartobj));
                                }

                                if (grand_total == null) {

                                    localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                                } else {

                                    var grand_total_obj = JSON.parse(grand_total);

                                    grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                                    grand_total_obj.total_qty = parseInt(value) + parseInt(grand_total_obj.total_qty);

                                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));
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

                        success: function(data) {

                            $.each(data, function(i, unit) {

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

                $('#search_wif_typing').on('change','#counting_unit_select',function(){


                    var id = $('#counting_unit_select').val();
                    // console.log(id);
                    var unitname = $(this).find(":selected").data('unitname');
                    let design_name = $(this).find(":selected").data('design_name');
                    let size_name = $(this).find(":selected").data('size_name');
                    let fabric_name = $(this).find(":selected").data('fabric_name');
                    let color_name = $(this).find(":selected").data('color_name');

                    // let color_name = $("#colour_name").val();
                    var discount_type = "";
                    var discount_value = 0;

                    var saleprice = $(this).find(":selected").data('normal');
                    var currentqty = $(this).find(":selected").data('currentqty');


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
                            unit_name: unitname,
                            current_qty: currentqty,
                            order_qty: 1,
                            selling_price: saleprice,
                            each_sub: eachsub,

                            design_name: design_name,
                            fabric_name: fabric_name,
                            color_name: color_name,
                            size_name: size_name,
                            discount_type: discount_type,
                            discount_value: discount_value,
                        };

                        var total_amount = {
                            sub_total: total_price,
                            total_qty: 1,

                            total_discount_type: "",
                            total_discount_value: 0,
                        };

                        var mycart = localStorage.getItem('mycart');

                        var grand_total = localStorage.getItem('grandTotal');

                        if (mycart == null) {

                            mycart = '[]';

                            var mycartobj = JSON.parse(mycart);

                            mycartobj.push(item);

                            localStorage.setItem('mycart', JSON.stringify(mycartobj));

                        } else {

                            var mycartobj = JSON.parse(mycart);

                            var hasid = false;

                            $.each(mycartobj, function(i, v) {

                                if (v.id == id) {

                                    hasid = true;

                                    v.order_qty = parseInt(1) + parseInt(v.order_qty);
                                    v.each_sub = parseInt(v.selling_price) * parseInt(v.order_qty);
                                    console.log(v.each_sub);
                                }
                            })

                            if (!hasid) {

                                mycartobj.push(item);
                            }

                            localStorage.setItem('mycart', JSON.stringify(mycartobj));
                        }

                        if (grand_total == null) {

                            localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                        } else {

                            var grand_total_obj = JSON.parse(grand_total);

                            grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                            grand_total_obj.total_qty = parseInt(1) + parseInt(grand_total_obj.total_qty);

                            localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));
                        }

                        $("#unit_table_modal").modal('hide');

                        // for a5 voucher
                        var mycart = localStorage.getItem('mycart');

                        var arr = [];

                        $('#lenn').html(mycart);


                        // $.ajax({

                        //     type:'POST',

                        //     url:'/getItemForA5',

                        //     data:{
                        //         "_token":"{{ csrf_token() }}",
                        //         "items":mycart,
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
                        var grand_total = localStorage.getItem('grandTotal');

                        var grand_total_obj = JSON.parse(grand_total);

                            var sub_total = grand_total_obj.sub_total;
                            total_with_discount = grand_total_obj.sub_total - grand_total_obj.total_discount_value;
                        $('#voucher_total').val(sub_total);
                        $('#gtot').val(sub_total);
                        $('#with_dis_total').val(total_with_discount);

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
                                            selling_price: price,

                                        };

                                        var total_amount = {
                                            sub_total: total_price,
                                            total_qty: value,

                                        };

                                        var mycart = localStorage.getItem('mycart');

                                        var grand_total = localStorage.getItem('grandTotal');

                                        //console.log(item);

                                        if (mycart == null) {

                                            mycart = '[]';

                                            var mycartobj = JSON.parse(mycart);

                                            mycartobj.push(item);

                                            localStorage.setItem('mycart', JSON.stringify(mycartobj));

                                        } else {

                                            var mycartobj = JSON.parse(mycart);

                                            var hasid = false;

                                            $.each(mycartobj, function(i, v) {

                                                if (v.id == id) {

                                                    hasid = true;

                                                    v.order_qty = parseInt(value) + parseInt(v.order_qty);
                                                }
                                            })

                                            if (!hasid) {

                                                mycartobj.push(item);
                                            }

                                            localStorage.setItem('mycart', JSON.stringify(mycartobj));
                                        }

                                        if (grand_total == null) {

                                            localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                                        } else {

                                            var grand_total_obj = JSON.parse(grand_total);

                                            grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                                            grand_total_obj.total_qty = parseInt(value) + parseInt(grand_total_obj.total_qty);

                                            localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));
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

                    var grand_total = localStorage.getItem('grandTotal');

                    var mycart = localStorage.getItem('mycart');

                    var mycartobj = JSON.parse(mycart);

                    var grand_total_obj = JSON.parse(grand_total);

                    var item = mycartobj.filter(item => item.id == id);

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
                            $.each(mycartobj, function(i, value) {
                                new_total += value.each_sub;
                                new_total_qty += value.order_qty
                            })

                            grand_total_obj.sub_total = new_total;

                            grand_total_obj.total_qty = new_total_qty;

                            localStorage.setItem('mycart', JSON.stringify(mycartobj));

                            localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

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
                                function(isConfirm) {
                                    if (isConfirm) {

                                        let item_cart = mycartobj.filter(item => item.id !== id);

                                        grand_total_obj.sub_total -= parseInt(item[0].selling_price) * qty;

                                        grand_total_obj.total_qty -= qty;

                                        console.log("yes");
                                        localStorage.setItem('mycart', JSON.stringify(item_cart));

                                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                                        count_item();

                                        showmodal();

                                    } else {

                                        item[0].order_qty;
                                        console.log("no");
                                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

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

                            localStorage.setItem('mycart', JSON.stringify(mycartobj));

                            localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                            count_item();

                            showmodal();
                        }
                    } else if (action == 'remove') {
                        //var ans=confirm('Are you sure?');

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
                            function(isConfirm) {

                                if (isConfirm) {
                                    let item_cart = mycartobj.filter(item => item.id !== id);
                                    console.log(item_cart);
                                    grand_total_obj.sub_total = grand_total_obj.sub_total - (parseInt(item[0].selling_price) *
                                        qty);

                                    grand_total_obj.total_qty = grand_total_obj.total_qty - qty;

                                    localStorage.setItem('mycart', JSON.stringify(item_cart));

                                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                                    count_item();

                                    showmodal();

                                } else {
                                    item[0].order_qty;

                                    localStorage.setItem('mycart', JSON.stringify(mycartobj));

                                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

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

                    var mycart = localStorage.getItem('mycart');

                    var grandTotal = localStorage.getItem('grandTotal');

                    var grandTotal_obj = JSON.parse(grandTotal);

                    if (mycart) {

                        var mycartobj = JSON.parse(mycart);

                        var html = '';

                        if (mycartobj.length > 0) {

                            $.each(mycartobj, function(i, v) {

                                var id = v.id;

                                var qty = v.order_qty;

                                var count_name = v.unit_name;


                                    var selling_price = v.selling_price;


                                var each_sub_total = v.order_qty * selling_price ?? 0;
                                // <i class="fa fa-plus-circle btnplus font-18" onclick="plusfive(${id})" id="${id}"></i>
                                // <i class="fa fa-minus-circle btnminus font-18   "  onclick="minusfive(${id})" id="${id}"></i>
                                html += `<tr class="text-center">


                            <td class="text-black">${count_name}</td>



                            <td class="text-black w-10 m-0 p-0" onkeyup="plus(${id})" id="${id}">
                                <input type="number" class="form-control w-100 text-black text-center p-0 mt-1" name="" id="nowqty${id}" value="${qty}" style="border: none;border-color: transparent;">
                            </td>

                            <td class="text-black w-25 m-0 p-0" data-price="${selling_price}" >
                                <input onkeyup="table_edit_price(${v.id},${selling_price})" type="number" class=" form-control w-100 text-black text-center p-0 mt-1" id="nowprice${id}" value="${selling_price}" style="border: none;border-color: transparent;">
                            </td>

                            <td class="text-black" id="discount_value">${v.discount_value ?? 0}</td>

                            <td class="text-black" id="each_sub">${v.each_sub ?? 0}</td>
                           <td>
                          <button onclick="saleItemDiscountModel(${id})" class="btn btn-sm btn-outline-primary btn-rounded"
                                data-toggle="modal" id="#itemDiscount" data-target="#itemDiscount">
                                %</button>
                            </td>
                            <td>
                                <i class="fa fa-times" onclick="remove(${id},${qty})" id="${id}"></i> </td>
                            </tr>`;

                            });
                        }

                        var htmlslip = "";
                        var id = $('#counting_unit_select').val();
                        $.each(mycartobj, function(i, v) {

                                var selling_price = v.selling_price;

                            var totalslip = (parseInt(selling_price) * parseInt(v.order_qty)) - parseInt(v.discount_value);
                            htmlslip += `
                         <tr>
                            <td style="font-size:15px;">${v.unit_name}</td>
                            <td style="font-size:15px;">${v.order_qty} * ${selling_price} ( ${v.discount_value} ) </td>

                            <td style="font-size:15px;" id="subtotal">${totalslip}</td>
                        </tr>
                `;
                        });

                         var sub_total = grandTotal_obj.sub_total;
                            var total_wif_discount = grandTotal_obj.sub_total - grandTotal_obj.total_discount_value;
                            var discount_amt = grandTotal_obj.total_discount_value;

                        $('#slip_live').html(htmlslip);
                        $('#total_charges').text(sub_total);
                        $('#slip_discount').text(discount_amt);
                        $('#slip_net').text(total_wif_discount);
                        var pay = $('#payable').val();



                        $("#total_quantity").text(grandTotal_obj.total_qty);

                        $("#sub_total").text(total_wif_discount);
                        $('#gtot').val(sub_total);
                        $('#with_dis_total').val(total_wif_discount);
                        $('#discount_amount').val(discount_amt);

                        $("#sale").html(html);




                    }
                    show_a5();
                }


                function count_item() {

                    var mycart = localStorage.getItem('mycart');

                    if (mycart) {

                        var mycartobj = JSON.parse(mycart);

                        var total_count = 0;

                        $.each(mycartobj, function(i, v) {

                            total_count += v.order_qty;

                        })

                        $(".item_count_text").html(total_count);

                    } else {

                        $(".item_count_text").html(0);

                    }
                }

                $('#sale').on('dblclick', '.editprice', function() {
                    var id = $(this).data('id');
                    var price = $(this).data('price');
                    $('#count_id').val(id);
                    $('#price_change').val(price);
                    $('#or_price').val(price);
                    console.log(id, price);
                    $('#editprice').modal("show");
                })

                $('#price_change_btn').click(function() {

                    var count_id = $('#count_id').val();
                    // alert(count_id);
                    var price_change = $('#price_change').val();
                    // alert(price_change);
                    var grand_total = localStorage.getItem('grandTotal');

                    var mycart = localStorage.getItem('mycart');

                    var discart = localStorage.getItem('mydiscart');

                    var focflagcart = localStorage.getItem('myfocflag');

                    var hasdiscart = localStorage.getItem('myhasdis');

                    var mycartobj = JSON.parse(mycart);

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




                    $.each(dis_cart_obj, function(i, v) {
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

                    var item = mycartobj.filter(item => item.id == count_id);

                    grand_total_obj.sub_total -= parseInt(item[0].selling_price);

                    grand_total_obj.sub_total += parseInt(price_change);

                    // item[0].selling_price= parseInt(price_change);

                    item[0].each_sub = parseInt(price_change);

                    localStorage.setItem('mycart', JSON.stringify(mycartobj));

                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                    showmodal();

                    $('#editprice').modal("hide");

                })


                //clearLocalstorate in masterblade


                $('#percent_for_price').click(function() {
                    var idArray = [];
                    $("input:checkbox[name=percent_for_price]:checked").each(function() {
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
                $('#percent_price').keyup(function() {
                    var percent_price = $('#percent_price').val();
                    var or_price = $('#or_price').val();
                    var discount_amount = parseInt(or_price * (percent_price / 100));
                    var change_percent_price = parseInt(or_price) + discount_amount;
                    $('#discount_amount').html(discount_amount);
                    $('#price_change').val(change_percent_price);
                })

                $('#foc').click(function() {
                    var idArray = [];
                    $("input:checkbox[name=foc]:checked").each(function() {
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

                    var mycart = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    var discount = localStorage.getItem('mydiscart');

                    var focflag = localStorage.getItem('myfocflag');

                    var hasdis = localStorage.getItem('myhasdis');


                    if (!mycart) {

                        swal({
                            title: "Please Check",
                            text: "Item Cannot be Empty to Check Out",
                            icon: "info",
                        });

                    } else {

                        $("#item").attr('value', mycart);

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

                        success: function(data) {

                            $("#phone").val(data.phone);

                            $("#address").val(data.address);
                        },


                    });
                }

                function storeCustomerOrder() {

                    var item = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    var customer_id = $('#customer_id').val();

                    var phone = $('#phone').val();

                    var order_date = $('#order_date').val();

                    var delivered_date = $('#delivered_date').val();

                    var employee = $('#employee').val();

                    var address = $('#address').val();

                    if (!item || !grand_total) {

                        swal({
                            title: "@lang('lang.please_check')",
                            text: "@lang('lang.cannot_checkout')",
                            icon: "info",
                        });

                    } else {

                        $.ajax({

                            type: 'POST',

                            url: '/storeCustomerOrder',

                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item": item,
                                "grand_total": grand_total,
                                "customer_id": customer_id,
                                "phone": phone,
                                "address": address,
                                "order_date": order_date,
                                "delivered_date": delivered_date,
                                "employee": employee,
                            },

                            success: function(data) {

                                localStorage.clear();

                                swal({
                                    title: "Success",
                                    text: "Order is Successfully Stored",
                                    icon: "success",
                                });

                                setTimeout(function() {
                                    window.location.href = url;
                                }, 1000);
                            },

                            error: function(status) {

                                swal({
                                    title: "Something Wrong!",
                                    text: "Something Wrong When Store Customer Order",
                                    icon: "error",
                                });
                            }
                        });

                    }
                }

                $('.pending-voucher').on('click', '.buttonrelative .deletevoucher', function() {
                    var now_customer = $('#now_customer').val();
                    var pendingvoucherno = $(this).data('pendingvoucherno');
                    var cartname = "mycart_" + pendingvoucherno;
                    var grand_totalname = "grandTotal_" + pendingvoucherno;

                    var local_customer = localStorage.getItem('local_customer_lists');
                    var local_customer_array = JSON.parse(local_customer);
                    $.each(local_customer_array, function(i, v) {
                        if (v == pendingvoucherno) {
                            local_customer_array.splice(i, 1);
                        }
                    })
                    localStorage.setItem('local_customer_lists', JSON.stringify(local_customer_array));
                    localStorage.removeItem(cartname);
                    localStorage.removeItem(grand_totalname);

                    if (now_customer == pendingvoucherno) {
                        localStorage.removeItem('mycart');
                        localStorage.removeItem('grandTotal');
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

                    $.each(local_customer_array, function(i, v) {

                        var btnpending = `

            <div class="buttonrelative mb-2">
                <button class="btn btn-warning mx-2" data-pendingvoucherno="${v}"><i class="fas fa-arrow-alt-circle-up"></i> ${cust} ${v}</button>
            <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${v}">x</p>
            </div>

            `;
                        $('.pending-voucher').append(btnpending);
                    })
                }

                $('.pending-voucher').on('click', '.buttonrelative button', function() {

                    var pendingvoucherno = $(this).data('pendingvoucherno');

                    $('#now_customer').val(pendingvoucherno);
                    $('#now_customer_no').text(pendingvoucherno);

                    $('.now_customer').show();
                    var cartname = "mycart_" + pendingvoucherno;
                    var grand_totalname = "grandTotal_" + pendingvoucherno;


                    var mycart_pending_vocher = localStorage.getItem(cartname);

                    var grand_total_pending_voucher = localStorage.getItem(grand_totalname);

                    localStorage.setItem('mycart', mycart_pending_vocher);

                    localStorage.setItem("grandTotal", grand_total_pending_voucher);

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
                    var mycart = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    var nextvoucherno = parseInt(pendingvoucherno) + 1;

                    var now_customer = $('#now_customer').val();

                    var local_customer_lists = localStorage.getItem('local_customer_lists');
                    var local_last_customer_no = localStorage.getItem('last_customer_no');
                    if (!mycart) {

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
                            var cartname = "mycart_" + pendingvoucherno;
                            var grand_totalname = "grandTotal_" + pendingvoucherno;

                            var btnpending = `
        <div class="buttonrelative mb-2">
            <button class="btn btn-warning mx-2" data-pendingvoucherno="${pendingvoucherno}"><i class="fas fa-arrow-alt-circle-up"></i> ${cust} ${pendingvoucherno}</button>
        <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${pendingvoucherno}">x</p>
        </div>

        `;
                            $('.pending-voucher').append(btnpending);
                        } else {
                            var cartname = "mycart_" + now_customer;
                            var grand_totalname = "grandTotal_" + now_customer;

                        }
                        localStorage.setItem(cartname, mycart);
                        localStorage.setItem(grand_totalname, grand_total);

                        localStorage.removeItem('mycart');
                        localStorage.removeItem('grandTotal');
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

                        $.each(local_customer_array, function(i, v) {

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
                    $('#changes').text(credit_amt);
                    $("#credit").val(hascre);
                    $('#current_credit').val(credit_amt);
                }

                function fillCustomer(value) {

                    var customer_id = value;
                    $('#select_cusid').val(customer_id);
                    console.log($('#select_cusid').val());

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('AjaxGetCustomerwID') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "customer_id": customer_id,
                        },
                        success: function(data) {
                            $("#name").val(data.sale_cust.name);
                            $("#custphone").val(data.sale_cust.phone);
                            $('#pending_cust').val(data.sale_cust.name);
                            //  $("#credit").val(data.credit_amount);
                            <!--if (data.sale_credit != null) {-->
                            <!--    $('#credit').val(data.sale_cust.credit_amount);-->
                            <!--    $('#previous_credit').val(data.sale_cust.credit_amount);-->
                            <!--} else {-->
                            <!--    $('#credit').val(0);-->
                            <!--    $('#previous_credit').val(0);-->
                            <!--}-->
                        },
                    });
                }

                var last_row_id = 0;
                $("#save").click(function() {
                    var name = $('#name').val();
                    var phone = $('#custphone').val();
                    //var credit_amount = $('#credit').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('AjaxStoreCustomer') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "name": name,
                            "phone": phone,
                            "credit_amount": 0,
                        },
                        success: function(data) {
                            console.log(data.last_row);
                            if (data.success == 1) {
                                last_row_id = data.last_row.id;
                                $('#select_cusid').val(last_row_id);
                                console.log($('#select_cusid').val());
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
                    var salecustomer_id = $('#salescustomer_list').children("option:selected").val();
                    console.log(salecustomer_id);
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
                                    url: '{{ route('saleCustomerDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "salecustomer_id": salecustomer_id,

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



                $(".store_voucher").click(function() {

                    var mycart = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    var editvoucher = localStorage.getItem('editvoucher');

                    var item = mycart;
                    var grand = grand_total;
                    var discount = discount;

                    if(editvoucher != null){
                        var voucher_details = localStorage.getItem('voucher_details');
                        if (voucher_details != null) {
                            var vdetail_obj = JSON.parse(voucher_details);
                            var voucher_code = vdetail_obj.voucher_code;
                        }
                    }else{
                        var voucher_code = $('#voucherCode').val();
                    }
                    var cus_pay = $('#payable').val();

                    var custname = $('#name').val();

                    var custphone = $('#custphone').val();

                    var remark = $('#remark_input').val();

                    var username = $('#userName').val();

                    //var id = $('#salescustomer_list').children("option:selected").val();
                    var id = $('#select_cusid').val();


                    console.log(voucher_code,cus_pay,custname,custphone,id);
                    if (!cus_pay) {
                        swal({
                            icon: 'error',
                            title: 'ပေးငွေ ထည့်ပါ!',
                            text: 'Customer Pay cannot be null!!!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                    } else{
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
                                "customer_name": custname,
                                "customer_phone": custphone,
                                "cus_pay": cus_pay,
                                "user_name": username,
                                "customer_id": id,
                                "remark" : remark,
                                "editvoucher": editvoucher ?? 0
                            },
                            success: function(data) {
                                console.log('success');
                                console.log(data.counting_units);
                                if (data.status == 0) {
                                    swal({
                                        icon: 'error',
                                        title: 'မှားယွင်းနေပါသည်.',
                                        text: data.message,
                                    })
                                } else {

                                    localStorage.removeItem('exitvoucher');
                                    localStorage.clear();

                                    swal({
                                        icon: 'success',
                                        title: 'သိမ်းဆည်းပြီး!',
                                        text: 'Voucher သိမ်းဆည်းပြီးပါပြီ!!',
                                        button: false,
                                        timer: 1500,
                                    })

                                    setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                     }



                            }
                        });
                    }
                });
                $("#repaymentDate").datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                // Begin Print
                $("#print").click(function() {

                    var now_customer = $('#now_customer').val();

                    var mycart = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    var editvoucher = localStorage.getItem('editvoucher');

                     if(editvoucher != null){
                        var voucher_details = localStorage.getItem('voucher_details');
                        if (voucher_details != null) {
                            var vdetail_obj = JSON.parse(voucher_details);
                            var voucher_code = vdetail_obj.voucher_code;
                        }
                    }else{
                        var voucher_code = $('#voucherCode').val();
                    }


                    var item = mycart;
                    var grand = grand_total;
                    //var voucher_code = $('#voucherCode').val();
                    var cus_pay = $('#payable').val();

                    var custname = $('#name').val();

                    var custphone = $('#custphone').val();
                    var remark = $('#remark_input').val();

                    var username = $('#userName').val();

                    //var id = $('#salescustomer_list').children("option:selected").val();
                    var id = $('#select_cusid').val();

                    console.log(voucher_code);

                    if (!pay) {
                        swal({
                            icon: 'error',
                            title: 'ပေးငွေ ထည့်ပါ ..',
                            text: 'Customer Pay cannot be null!!!',
                            footer: '<a href>Why do I have this issue?</a>'
                        })
                    } else {

                        //last_row_id

                        $.ajax({
                            type: 'POST',
                            url: '/testVoucher',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item": item,
                                "grand": grand,
                                "voucher_code": voucher_code,
                                "customer_name": custname,
                                "customer_phone": custphone,
                                "cus_pay": cus_pay,
                                "user_name": username,
                                "customer_id" : id,
                                "remark" : remark,
                                "editvoucher": editvoucher ?? 0
                            },
                            success: function(data) {
                                if (data.status == 0) {
                                    swal({
                                        icon: 'error',
                                        title: 'မှားယွင်းနေပါသည်.',
                                        text: 'ပြန်စစ်ပါ..',
                                    })
                                } else {

                                    localStorage.removeItem('exitvoucher');
                                    localStorage.clear();

                                    var mode = 'iframe'; //popup
                                    var close = mode == "popup";
                                    var options = {
                                        mode: mode,
                                        popClose: close
                                    };

                                    $(".tab-pane.active div.printableArea").printArea(options);

                                    setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                     }



                            }
                        });

                        //end last_row
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

                function insert_total() {
                    var grand_total = localStorage.getItem('grandTotal');

                    var grand_total_obj = JSON.parse(grand_total);
                    $('#voucher_total').val(grand_total_obj.sub_total);
                    $('#vou_price_change').val(0);
                    $('#voudiscount').modal('show');
                }

                $('#vou_price_change_btn').click(function() {


                    var grand_total = localStorage.getItem('grandTotal');

                    var grand_total_obj = JSON.parse(grand_total);

                    var price_change = $('#vou_price_change').val();

                    if ($('#voufoc').is(':checked')) {

                        var total = 0;
                        var discount_amount_text = 'foc';
                        var discount_amount = $('#gtot').val();

                    } else if($('#vou_percent_for_price').is(':checked')){
                        var total = $('#gtot').val();
                        var discount_amount_text = 'percent';
                        var discount_amount = price_change;
                        var total_with_dis = total - discount_amount;
                    }else{
                        var total = $('#gtot').val();
                        var discount_amount_text = 'amount';
                        var discount_amount = price_change;
                        var total_with_dis = total - discount_amount;
                    }

                    $('#discount_amount').val(discount_amount);

                    $('#with_dis_total').val(total_with_dis);

                    //$('#sub_total').empty();

                    //$('#sub_total').text(parseInt(price_change));

                    $('#total_charges_a5').empty();
                    $('#total_charges_a5').text(parseInt(price_change));
                    $('#total_charges').empty();
                    $('#total_charges').text(parseInt(price_change));

                    grand_total_obj.total_discount_type = discount_amount_text;
                    grand_total_obj.total_discount_value = parseInt(discount_amount);

                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                    $('#voudiscount').modal('hide');

                })

                function table_edit_price(id, old_price) {

                    var price_change = parseInt($(`#nowprice${id}`).val());

                    var mycart = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    var mycartobj = JSON.parse(mycart);

                    var grand_total_obj = JSON.parse(grand_total);

                    var item = mycartobj.filter(item => item.id == id);

                    item[0].selling_price = price_change;

                    item[0].each_sub = (item[0].order_qty * price_change) - item[0].discount_value ?? 0;

                    new_total = 0;
                    new_total_qty = 0;
                    $.each(mycartobj, function(i, value) {

                            var price = value.selling_price;

                        new_total += (parseInt(value.order_qty) * parseInt(price)) - parseInt(value.discount_value);
                        new_total_qty += value.order_qty;
                    })

                    grand_total_obj.sub_total = new_total;

                    grand_total_obj.total_qty = new_total_qty;

                    localStorage.setItem('mycart', JSON.stringify(mycartobj));

                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                    // count_item();

                    showmodal();

                    var num = $(`#nowprice${id}`).val();
                    $(`#nowprice${id}`).focus().val('').val(num);
                }


                $('#voufoc').click(function() {
                    // alert($("input:checkbox[name=foc]:checked").val());

                    var price_change = $('#vou_price_change').val();
                    var or_price = $('#voucher_total').val();
                    if ($("input:checkbox[name=voufoc]:checked").val() == 1) {
                        $('#vou_price_change').val(or_price);
                    } else {
                        $('#vou_price_change').val(0);
                    }
                    //    var percent_for_price=$('#percent_for_price').val();
                })
                $('#vou_percent_for_price').click(function() {
                    var idArray = [];
                    $("input:checkbox[name=vou_percent_for_price]:checked").each(function() {
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
                    // alert(percent_price+"---"+or_price);
                    var discount_amount = parseInt(or_price * (percent_price / 100));
                    var change_percent_price = parseInt(or_price) - discount_amount;
                    $('#vou_discount_amount').html(discount_amount);
                    $('#vou_price_change').val(discount_amount);
                })

                function show_a5() {
                    $("#a5_body").empty();
                    var name = $('#name').val();

                    var phone = $('#custphone').val();

                    $('#cus_name').text(name);
                    $('#cus_phone').text(phone);

                    var k = 1;
                    var mycart = localStorage.getItem('mycart');
                    var mycartobj = JSON.parse(mycart);

                    var grandTotal = localStorage.getItem('grandTotal');
                    var grandTotalobj = JSON.parse(grandTotal);

                    var remark = $('#remark_input').val();
                    var pay = $('#payable').val();
                    //Begin A5 Voucher

                    var len = mycartobj.length;
                    var htmlcountitem = "";
                    var j = 1;

                    var i = 1;
                    var each_sub_total = 0;
                    $.each(mycartobj, function(i, value) {

                        htmlcountitem += `
                <tr>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${i++ }</td>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${value.design_name} ${value.fabric_name}</td>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${value.color_name}</td>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${value.size_name}</td>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${value.order_qty}</td>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${value.selling_price}</td>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${value.discount_value ?? 0}</td>
                <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">${value.each_sub}</td>
            </tr>
                `;
                    })
                    htmlcountitem += `
<!--                <tr>-->
<!--                    <td colspan="3"></td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">ကျသင့်ငွေ</td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">-->
<!--                        <span id="total_charges_a5"></span>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td colspan="3"></td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">ပေးငွေ</td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">-->
<!--                        <span id="pay_1"> </span></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td colspan="3"></td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">ကြွေးကျန်</td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">-->
<!--                        <span id="credit_amount"> </span></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td colspan="3"></td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">အမ်းငွေ</td>-->
<!--                    <td style="font-size:20px;height: 8px; border: 2px solid black;">-->
<!--                        <span id="changes_1"> </span></td>-->
<!--                </tr>-->

                   <tr>
                            <td colspan="5"></td>
                            <td class="text-center" colspan="2" style="font-size:15px;height: 15px; border: 1px solid black;">Total Amount</td>
                            <td colspan="2" class="text-center" style="font-size:15px;height: 15px; border: 1px solid black;">${grandTotalobj.sub_total}
                               </td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>

                            <td class="text-center" colspan="2" style="font-size:15px;height: 15px; border: 1px solid black;">Discount</td>
                            <td colspan="2" class="text-center" style="font-size:15px;height: 15px; border: 1px solid black;">${grandTotalobj.total_discount_value}
                                </td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                            <td class="text-center" colspan="2" style="font-size:15px;height: 15px; border: 1px solid black;">Net Amount</td>
                            <td colspan="2" class="text-center" style="font-size:15px;height: 15px; border: 1px solid black;">${grandTotalobj.sub_total - grandTotalobj.total_discount_value}</td>

                </tr>
                <tr>
                    <td colspan="3" class="text-left" style="font-size:15px;height: 15px; border: none;">Remark : ${remark}</td>
                    <td colspan="2" style="font-size:15px;height: 15px; border: none;">
                        <span id="total_charges_a5"></span>
                    </td>
                    <td class="text-center" colspan="2" style="font-size:15px;height: 15px; border: 1px solid black;">Pay</td>
                    <td colspan="2" class="text-center" style="font-size:15px;height: 15px; border: 1px solid black;">
                    ${pay}
                </td>
        </tr>
        <tr>
            <td colspan="3" class="text-left" style="font-size:15px;height: 15px; border: none;">Customer Address :</td>
            <td colspan="2" style="font-size:15px;height: 15px; border: none;">

                </td>
                <td class="text-center" colspan="2" style="font-size:15px;height: 15px; border: 1px solid black;">Change</td>
                <td colspan="2" class="text-center" style="font-size:15px;height: 15px; border: 1px solid black;">${grandTotalobj.sub_total - grandTotalobj.total_discount_value - pay}
</td>
                        </tr>
            `;

                    $("#a5_body").html(htmlcountitem);

                    //End A5 Voucher
                }

                function searchSubCategory(value){
                    let cat_id = value;
                    // alert(cat_id);

                    $('#subcategory').empty();

                    $.ajax({
                        type: 'POST',
                        url: 'subcategory_search',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category_id": cat_id,
                        },

                        success: function(data) {
                            console.log(data);
                            if(data.length > 0){
                                $('#subcategory').append($('<option>').text('Subcategory'));
                                $.each(data, function(i, value) {
                                    $('#subcategory').append($('<option>').text(value.name).attr('value', value.id));
                                });
                            }else{
                                $('#subcategory').append($('<option>').text('No Subcategory'));
                            }
                        },

                        error: function(status) {
                            swal({
                                title: "Something Wrong!",
                                text: "Error in subcategory search",
                                icon: "error",
                            });
                        }

                    });

                }

                function searchCountingUnit(value){

                    let sub_id = value;
                    let cat_id = $('#category').val();
                    $('#counting_unit_select').empty();
                    $.ajax({
                        type: 'POST',
                        url: 'unit_search',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category_id" : cat_id,
                            "subcategory_id": sub_id,
                        },

                        success: function(data) {
                            console.log(data);
                            $('#counting_unit_select').append($('<option>').text('units'));
                            $.each(data,function(i,v){
                                if(v.current_quantity != 0){

                                    $('#counting_unit_select').append($('<option>').text((v.unit_code ?? 'COD001') +"-"+
                                        v.unit_name + " " +  v.current_quantity + "ခု"+
                                        v.order_price + "ကျပ်").attr('value', v.id).data('unitname',v.unit_name ?? '').data('normal',v.order_price ?? 0).data('currentqty',v.current_quantity ?? 0).data('design_name',v.design ? v.design.design_name : '').data('fabric_name',v.fabric ? v.fabric.fabric_name : '').data('color_name',v.colour.colour_name ?? '').data('size_name',v.size.size_name ?? ''));
                                }
                            })
                        },

                        error: function(status) {
                            swal({
                                title: "Something Wrong!",
                                text: "Error in searching units",
                                icon: "error",
                            });
                        }

                    });
                }
                function amount_radio(value){
                    if(value === "amount"){
                        $("#item_discount_amount").val(0);
                        $("#item_dis_amount_form").removeClass("d-none");
                        $("#item_dis_amount_form").show();
                        $("#item_dis_percent_form").hide(300);
                    }else if(value === "percent"){

                        $("#item_discount_percent").val(0);
                        $("#item_dis_percent_form").removeClass("d-none");
                        $("#item_dis_percent_form").show();
                        $("#item_dis_amount_form").hide(300);
                    }else if(value === "foc"){

                        $("#item_dis_amount_form").addClass("d-none");
                        $("#item_dis_percent_form").addClass("d-none");
                    }
                    $("#discount_type").val(value);
                }

                function saleItemDiscountModel(id){

                    let myCart = localStorage.getItem('mycart');
                    let myCartObj = JSON.parse(myCart);
                    let item = myCartObj.filter(item => item.id == id);
                    $("#item_current_amount").text(item[0].each_sub);

                    // $('#sub_total').val();
                    $("#discount_id").val(id);
                }


                $('#item_discount_percent').keyup(function() {
                    var percent_price = $('#item_discount_percent').val();
                    var or_price = $('#item_current_amount').val();
                    // alert(percent_price+"---"+or_price);
                    var discount_amount = parseInt(or_price * (percent_price / 100));
                    var change_percent_price = parseInt(or_price) - discount_amount;

                })

                $("#itemDiscountSave").click(function (){
                    let id = $("#discount_id").val();
                    let type = $("#discount_type").val();
                    console.log(id,type);

                    let myCart = localStorage.getItem('mycart');
                    let grandTotal = localStorage.getItem('grandTotal');
                    let myCartObj = JSON.parse(myCart);
                    var grandTotalObj = JSON.parse(grandTotal);


                    let item = myCartObj.filter(item => item.id == id);

                    if(type == 'amount'){
                        let dis_amount = $("#item_discount_amount").val();
                        var change_amount = item[0].each_sub - dis_amount;
                            $.each(myCartObj, function(i, v) {

                                if (v.id == id) {

                                    v.each_sub = change_amount;
                                    v.discount_type = type;
                                    v.discount_value = dis_amount;

                                        grandTotalObj.sub_total = grandTotalObj.sub_total - dis_amount;
                                }
                            })
                            localStorage.setItem('mycart', JSON.stringify(myCartObj));
                            localStorage.setItem('grandTotal', JSON.stringify(grandTotalObj));
                        showmodal();
                    }else if(type == 'percent'){
                        var percent_price = $("#item_discount_percent").val();
                        var or_price = item[0].each_sub;
                    // alert(percent_price+"---"+or_price);
                    var dis_amount = or_price * (percent_price / 100);
                    var change_amount = or_price - dis_amount;
                    $.each(myCartObj, function(i, v) {

                                if (v.id == id) {

                                    v.each_sub = change_amount;
                                    v.discount_type = type;
                                    v.discount_value = dis_amount;

                                        grandTotalObj.sub_total = grandTotalObj.sub_total - dis_amount;
                                }
                            })
                            localStorage.setItem('mycart', JSON.stringify(myCartObj));
                            localStorage.setItem('grandTotal', JSON.stringify(grandTotalObj));
                             showmodal();
                    }else if(type == 'foc'){
                        var dis_amount = item[0].each_sub;
                        $.each(myCartObj, function(i, v) {

                                if (v.id == id) {

                                    v.each_sub = 0;
                                    v.discount_type = type;
                                    v.discount_value = dis_amount;

                                        grandTotalObj.sub_total = grandTotalObj.sub_total - dis_amount;
                                }
                            })
                            localStorage.setItem('mycart', JSON.stringify(myCartObj));
                            localStorage.setItem('grandTotal', JSON.stringify(grandTotalObj));
                             showmodal();
                    }



                    <!--let dis_amount = $("#item_discount_amount").val();-->
                    <!--let dis_percent = $("#item_discount_percent").val();-->
                    <!--let foc = $("#item_dis_foc").val();-->
                    <!--let current_total = $("#item_current_amount").text();-->

                    <!--let dis_total = 0;-->
                    <!--let myCart = localStorage.getItem('mycart');-->
                    <!--let myCartObj = JSON.parse(myCart);-->
                    <!--let item = myCartObj.filter(item => item.id == id);-->
                    <!--let amount_type =$("#item_dis_amount").val();-->
                    <!--let percent_type =$("#item_dis_percent").val();-->
                    <!--let foc_type =$("#item_foc").val();-->
                    <!--item[0].discount_type = amount_type;-->

                    // if(dis_amount){
                    //     // discount = dis_amount;
                    //     // dis_total = Number(current_total) - dis_amount;
                    //     // item[0].discount = dis_amount;
                    //     item.discount_type = amount_type;
                    //     // item[0].discount_type = amount_type;
                    //
                    // }else if(dis_percent){
                    //     dis_total = Number(current_total) - (Number(current_total) * dis_percent ) / 100;
                    //     item[0].discount_value = dis_percent;
                    //     item[0].discount_type = percent_type;
                    // }else if(foc) {
                    //     dis_total = 0;
                    //     item[0].discount_value = 0;
                    //     item[0].discount_type = foc_type;
                    // }
                    // console.log(dis_amount);

                    $('#itemDiscount').modal('hide');

                })

                function checkNullUndefined(value){
                    return typeof value === 'string' && !value.trim()
                    || typeof value === 'undefined' || typeof value === null;
                }
            </script>

@endsection
