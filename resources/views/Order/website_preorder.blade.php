@extends('master')

@section('title','Website Pre-Order Page')

@section('place')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="font-weight-bold mt-2">Website Pre-Order List</h4>
            </div>
            <div class="card-body">
                 <div class="row p-2 offset-10">
                        <input  type="text" id="table_search" placeholder="Quick Search" onkeyup="search_table()" >
                    </div>

                <div class="table-responsive text-black">
                    <table class="table" id="order_table">
                        <thead class="head">
                            <tr>
                                <th>No.</th>
                                <th>Order No.</th>
                                <th>Customer Name</th>
                                <th>Order Address</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Total Qty</th>
                                <th>Total Amount</th>
                                <th> Remark</th>
                                <th class="text-center">@lang('lang.details')</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody id="website_order_list" class="body">
                             <?php
                                $i = 0;
                            ?>

                            @foreach($order_lists as $order)
                                <tr>
                                    <td>{{++$i}}</td>
                                	<td>{{$order->order_code}}</td>
                                    <td>{{$order->customer_name}}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">{{$order->deliver_address}}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">{{date('d-m-Y', strtotime($order->order_date))}}</td>
                                	@if($order->order_status == 'received')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-warning font-weight-bold">Pending</span></td>
                                	@elseif($order->order_status == 'confirmed')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-primary font-weight-bold">Confirmed</span></td>
                                	@elseif($order->order_status == 'delivered')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-info font-weight-bold">Delivered</span></td>
                                	@elseif($order->order_status == 'canceled')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-danger font-weight-bold">Canceled</span></td>
                                	@endif
                                	<td>{{$order->total_quantity}}</td>
                                    <td>{{$order->total_amount}}</td>
                                    <td>{{$order->remark}}</td>
                                	<td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <a href="{{route('website_order_details',$order->id)}}" class="btn rounded btn-sm btn-outline-info">Details</a>
                                            <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="collapse" data-target="#collapse_payment{{$order->id}}">Payment</a>
                                            {{-- <a href="#" class="btn rounded btn-sm btn-outline-info" onclick="showscreenshot({{$order->id}})">Screenshot</a> --}}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="btn rounded btn-sm btn-outline-info" data-toggle="modal"data-target="#status{{$order->id}}">Change Status</a>

                                    </td>
                                    {{-- <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#collapse_factory_order{{$order->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <a href="{{route('addFactoryOrderWebsiteWebsite',$order->id)}}" class="btn mx-1 rounded btn-sm btn-outline-info" title="New Factory Order"><i class="fas fa-plus-circle"></i></a>
                                            <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_{{$order->id}}">Confirm</a>
                                        </div>
                                    </td> --}}
                                    @if($order->status !== 4)
                                    <td class="text-center">
                                        @if($order->status == 1)
                                            <div class="d-flex align-items-center">
                                                <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#collapse_factory_order{{$order->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                                <a href="{{route('addFactoryOrderWebsite',$order->id)}}" class="btn mx-1 rounded btn-sm btn-outline-info" title="New Factory Order"><i class="fas fa-plus-circle"></i></a>
                                                <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_{{$order->id}}">Confirm</a>
                                            </div>


                                            @elseif($order->status == 2)
                                            <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#deliver_factory_order{{$order->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_{{$order->id}}">Deliver Order</a>

                                            @elseif($order->status == 5)

                                            <h6 class="text-danger mt-2">Canceled Order</h6>
                                        @endif

                                        <div class="modal fade" id="confirm_{{$order->id}}" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('lang.change_order_status') @lang('lang.form')</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

{{--                                                        Modal--}}
                                                    <div class="modal-body">
                                                        <form class="form" method="post" action="{{route('update_order_status_website')}}">
                                                            @csrf
                                                            <input type="hidden" name="order_id" value="{{$order->id}}">
                                                            <input type="hidden" name="order_status" value="{{$order->status}}">

                                                            @if($order->status == 2)

                                                            <div class="form-group row">
                                                                <label for="example-text-input" class="col-4 text-left col-form-label">
                                                                    Delivered By
                                                                </label>
                                                                <div class="col-7">
                                                                    <input class="form-control form-control-sm" type="text" name="delivered_by">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="example-text-input" class="col-4 text-left col-form-label">
                                                                    Delivered Date
                                                                </label>

                                                                <div class="col-7">
                                                                    <input class="form-control form-control-sm" type="date" name="delivered_date">
                                                                </div>
                                                            </div>
                                                                <div class="form-group row">
                                                                <label for="example-text-input" class="col-4 text-left col-form-label">
                                                                    Remark
                                                                </label>

                                                                <div class="col-7">
                                                                    <textarea name="delivered_remark" class="form-control form-control-sm" rows="5"></textarea>
                                                                </div>
                                                            </div>

                                    @elseif($order->status == 3)
                                        <div class="form-group row">
                                                                    <label for="example-text-input" class="col-12 col-form-label">
                                                                        <h3 class="font-weight-bold">Do you want to approve the changes in this order?</h3>
                                                                    </label>

                                                                </div>

                                                            @else
                                                                <div class="form-group row">
                                                                    <label for="example-text-input" class="col-12 col-form-label">
                                                                        <h3 class="font-weight-bold">Are You Sure to Confirm this Order?</h3>
                                                                    </label>

                                                                </div>
                                                            @endif
                                                            <div class="d-flex justify-content-around align-items-center">
                                                                <button class="btn btn-sm rounded btn-danger" data-dismiss="modal" aria-label="Close">
                                                                    No
                                                                </button>
                                                                <button class="btn btn-sm rounded btn-primary">Yes</button>
                                                            </div>


{{--                                                                <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.change_order_status')">--}}
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    @else
                                    <td class="text-center" style="overflow:hidden;white-space: nowrap;">
{{--                                            Order is Delivered!--}}

                                    <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#deliver_factory_order{{$order->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-list"></i>
                                            </button>

                                        <button class="btn btn-sm rounded btn-danger" type="button"
                                                data-toggle="modal" data-target="#orderVoucher{{$order->id}}">
                                            <span>Voucher</span>
                                        </button>

                                        <div class="modal fade" id="orderVoucher{{$order->id}}" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                            <h4 class="modal-title">Order Voucher</h4>

                                                            <button class="btn btn-sm rounded btn-info m-l-40" type="button"
                                    id="do_print">
                                            <span>Print</span>
                                        </button>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                                id="#close_modal">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body printableArea">
                                                            <div style="display:flex;justify-content:space-around">

                                                                <div class="col-md-12 text-center" >
                                                                    <div>
                                                                        <img src="{{ asset("image/medicalWorld.png") }}" width="500px">
                                                                    </div>

                                                                    <div>
                                                                        <p class="mt-2" style="font-size: 15px;">No.28,Hlaing Yadanar Mon 3rd Street, Hlaing Yadanar Mon Avenue, Hlaing Township, Yangon
                                                                            <br /><i class="fas fa-mobile-alt" style="font-size: 15px;"></i> 09 777 00 5861, 09 777 00 5862
                                                                        </p>
                                                                    </div>
                                                                    <div>
                                                                        <h2 class="text-center text-secondary font-weight-bold">Delivery Order Form</h2>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-between align-items-end">

                                                                        <div class="text-left">

                                                                            @foreach(\App\OrderVoucher::where('order_id',$order->id)->get() as $orderVou)
                                                                        <h3 class="text-black mt-3" style="font-size : 15px">@lang('lang.invoice') @lang('lang.number') : {{$orderVou->voucher_number}}</h3>
                                                                        <h3 class="text-black mt-3" style="font-size : 15px">@lang('lang.invoice') @lang('lang.date') :  {{date('d-m-Y', strtotime($orderVou->voucher_date))}}</h3>
                                                                            @endforeach
                                    <h3 class="text-black mt-3" style="font-size : 15px">Order @lang('lang.date') :  {{date('d-m-Y', strtotime($order->order_date))}}</h3>
                                                                        </div>
                                                                        <div class="text-left">
                                                                            <h3 class="text-black mt-3" style="font-size : 15px">Customer Name : {{ $order->customer_name }} </h3>
                                                                            <h3 class="text-black mt-3" style="font-size : 15px">Customer Phone : {{  $order->customer_phone }}</h3>

                                                                            <h3 class="text-black mt-3" style="font-size : 15px">Delivered by : {{ $order->delivered_by }}</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <table style="width: 100%;">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 5%;font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.number')</th>
                                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.item')</th>
                                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Colour</th>
                                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Size</th>
                                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.order_voucher_qty')</th>
                                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.price')</th>
                                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.total')</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>


                                                                    @php

                                                                        $i = 1 ;
                                                                    @endphp

@foreach(DB::table('counting_unit_ecommerce_order')->where('order_id',$order->id)->get() as $custom_unit)
@foreach($counting as $unit)
@if($unit->id == $custom_unit->counting_unit_id)

    <tr>
        <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $i++}}</td>
        <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{$unit->unit_name}}</td>

        @foreach(\App\Colour::where("id",$unit->colour_id)->get() as $c)
        <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ucfirst($c->colour_name)}} </td>
        @endforeach
        @foreach(\App\Size::where("id",$unit->size_id)->get() as $s)
        <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ucfirst($s->size_name)}} </td>
        @endforeach
        <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->quantity ?? 0}}</td>
        <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $unit->order_price ?? 0}} </td>
        <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->quantity * $unit->order_price}} </td>
    </tr>
@endif
@endforeach
@endforeach

                                                                    <tr>
                                                                        <td style="border: none;" colspan="3"></td>
                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Total Amount</td>
                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                            {{$order->total_amount}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" style="border: none;"></td>

                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Discount</td>
                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                            {{$order->discount_amount ?? 0}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" style="border: none;"></td>
                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Net Amount</td>
                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                        {{ $order->total_amount - $order->discount_amount ?? 0}}
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="1" class="text-left" style="font-size:15px;height: 45px; border: none;">Remark :</td>
                                                                        <td class="text-left" colspan="2" style="font-size:15px;height: 45px; border: none;">
                                                                            {{$order->delivered_remark}}
                                                                        </td>
                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Advance</td>
                                                                        <td colspan="2" style="font-size:15px;height: 10px; border: 1px solid black;">
                                                                            {{ $order->advance ?? 0}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="1" class="text-left" style="font-size:15px;height: 45px; border: none;">Address :</td>
                                                                        <td class="text-left" colspan="2" style="font-size:15px;height: 45px; border: none;">
                                                                            {{$order->deliver_address}}
                                                                        </td>
                                                                        <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Balance</td>
                                                                        <td colspan="2" class="text-center" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                        {{ ($order->total_amount - $order->discount_amount) - $order->advance ?? 0}}</td>
                                                                    </tr>


                                                                    </tbody>
                                                                </table>

                                                                {{-- <div class="d-flex justify-content-between align-items-left my-5 px-3">
                                                                    <div class="">
                                                                    <h4 class="font-weight-bold">Payment Information</h4> --}}

                                    {{-- <table>
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                                     @php

                                                                        $t = 1 ;
                                                                    @endphp

                         @foreach(\App\Transaction::where('order_id',$order->id)->get() as $transaction)

                                   <tr>
                                       <td>( {{$t++}} ) </td>
                                        <td style="font-size: 15px">{{$transaction->tran_date}} </td>
                                        <td style="font-size: 15px">{{$transaction->pay_amount}} </td>
                                        <td style="font-size: 15px">{{$transaction->remark}} </td>
                                    </tr>


                                    @endforeach
                                    </tbody>
                                    </table> --}}
                                    {{-- </div>


                                                                    </div> --}}

                                                                <div class="d-flex justify-content-between align-items-center my-5 px-3">
                                                                    <div class="">
                                                                        <h4 class="font-weight-bold">PAID BY</h4>
                                                                        <p style="text-align:left;font-size: 15px">Sign :</p>
                                                                        <p style="text-align:left;font-size: 15px">Name :</p>
                                                                        <p style="text-align:left;font-size: 15px">Position :</p>
                                                                    </div>
                                                                    <div class="">
                                                                        <h4 class="font-weight-bold">RECEIVED BY</h4>
                                                                        <p style="text-align:left;font-size: 15px">Sign :</p>
                                                                        <p style="text-align:left;font-size: 15px">Name : {{session()->get('user')->name}}</p>
                                                                        <p style="text-align:left;font-size: 15px">Position :</p>
                                                                    </div>
                                                                    <div class="">
                                                                        <h4 class="font-weight-bold">APPROVED BY</h4>
                                                                        <p style="text-align:left;font-size: 15px">Sign :</p>
                                                                        <p style="text-align:left;font-size: 15px">Name : </p>
                                                                        <p style="text-align:left;font-size: 15px">Position :</p>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    @endif



                                    <div class="modal fade" id="status{{$order->id}}" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h3 class="modal-title font-bold">Change Order Status</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body p-5">

                                                    <div class="mb-2">
                                                        <p class="text-center">
                                                            Please select status that you want!
                                                        </p>
                                                        <select class="form-control" id="statusval{{$order->id}}">
                                                            <option>Choose Status</option>
                                                            <option value="confirmed" id="con">Confirm</option>
                                                            <option value="delivered" id="del">Deliver</option>
                                                            <option value="canceled" id="can">Cancel</option>
                                                        </select>
                                                    </div>


                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="status_change({{$order->id}})">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>

                                        </div>
                                    </div>

                                    </div>


                                        <div class="modal" tabindex="-1" role="dialog" id='paysrc'>
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title">Order Payment Screenshot</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body" id="photo1">

                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </tr>
                                <tr>
                                    <td colspan="10">
                                        <div class="collapse" id="collapse_factory_order{{$order->id}}">
                                            <table class="table bg-light table-info"  >
                                                <thead>
                                                <tr class="text-center text-info h6">
                                                    <th>Factory Order Number</th>
                                                    <th>Department Name</th>
                                                    <th>Plan Date</th>
                                                    <th>Remark</th>
                                                    <th>Showroom</th>
                                                    <th>Total Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse(\App\FactoryOrder::where('order_id',$order->id)->whereIn('status',[1,3])->get() as $factory)
                                                <tr class="text-center">
                                                    <td>{{$factory->factory_order_number}}</td>
                                                    <td>{{$factory->department_name ?? '-'}}</td>
                                                    <td>{{$factory->plan_date ?? '-'}}</td>
                                                    <td>{{$factory->remark ?? '-'}}</td>
                                                    <td>{{ucfirst($factory->showroom)}}</td>
                                                    <td>{{$factory->total_quantity}}</td>
                                                    <td>
                                                        <a href="{{route('updateFactoryOrderItem',$factory->id)}}" class="btn btn-sm rounded btn-outline-info" title="Show Factory Order Item">
                                                            <i class="fas fa-list-alt"></i>
                                                        </a>

                                                        <a href="{{route('factoryOrderDetail',$factory->id)}}" class="btn btn-sm rounded btn-outline-info" title="Factory Order Detail">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="10"><p class="alert alert-warning">There is no data yet, please add factory order!</p></td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10">
                                        <div class="collapse" id="collapse_payment{{$order->id}}">
                                            <table class="table bg-light table-info"  >
                                                <thead>
                                                <tr class="text-center text-info h6">
                                                    <th>Payment Date</th>
                                                    <th>Payment Amount</th>
                                                    <th>Remark</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse(DB::table('ecommerce_order_screenshots')->where('ecommerce_order_id',$order->id)->get() as $eorder)

                                                <tr class="text-center">
                                                    <td>{{$eorder->created_at}}</td>
                                                    <td>{{$eorder->amount}}</td>
                                                    <td>{{$eorder->remark}}</td>
                                                    <td><a href="#" class="btn rounded btn-sm btn-outline-info" onclick="showscreenshot({{$eorder->id}})">Screenshot</a></td>
                                                </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="10"><p class="alert alert-warning">There is no data yet, please add factory order!</p></td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="10">
                                        <div class="collapse" id="deliver_factory_order{{$order->id}}">
                                            <table class="table bg-light table-info"  >
                                                <thead>
                                                <tr class="text-center text-info h6">
                                                    <th>Factory Order Number</th>
                                                    <th>Department Name</th>
                                                    <th>Deliver Date</th>
                                                    <th>Deliver Remark</th>
                                                    <th>Showroom</th>
                                                    <th>Total Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse(\App\FactoryOrder::where('order_id',$order->id)->where('status',2)->get() as $factory)
                                                <tr class="text-center">
                                                    <td>{{$factory->factory_order_number}}</td>
                                                    <td>{{$factory->department_name ?? '-'}}</td>
                                                    <td>{{$factory->delivery_date ?? '-'}}</td>
                                                    <td>{{$factory->delivery_remark ?? '-'}}</td>
                                                    <td>{{ucfirst($factory->showroom)}}</td>
                                                    <td>{{$factory->total_quantity}}</td>
                                                    <td>

                                                        <a href="{{route('factoryOrderDetail',$factory->id)}}" class="btn btn-sm rounded btn-outline-info" title="Factory Order Detail">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="10"><p class="alert alert-warning">There is no delivered factory Order!</p></td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>


                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

    <script>

    function status_change(id){

        let status = $('#statusval'+id).val();
        // alert(status);
         $.ajax({

                type: 'POST',

                url: '{{route('change_website_order_status')}}',

                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": id,
                    "status" : status,
                },

                success: function(data) {
                    //  alert(data.order_status);
                    $('#status'+id).modal('hide');
                    if(data.order_status == 'confirmed'){
                       var html = `
                        <span class="badge badge-pill badge-primary font-weight-bold">Confirmed</span>
                        `;
                        $('#chg_status'+id).html(html);
                    }else if(data.order_status == 'delivered'){
                       var html = `
                        <span class="badge badge-pill badge-info font-weight-bold">Delivered</span>
                        `;
                        $('#chg_status'+id).html(html);
                    }else{
                       var html = `
                        <span class="badge badge-pill badge-danger font-weight-bold">Canceled</span>
                        `;
                        $('#chg_status'+id).html(html);
                    }
                    location.reload();

                }
         })
    }

    function showscreenshot(id){
        // alert(id);
    $('#paysrc').modal('show');
     $.ajax({

        type: 'POST',

        url: '{{route('showscreenshot')}}',

        data: {
            "_token": "{{ csrf_token() }}",
            "order_id": id,
        },

        success: function(data) {
            //  alert(data.screenshot);
            $('#photo1').html(`<img src="{{asset('storage/screenshot/${data.screenshot}')}}" alt="" title="" width="470" height="430"/>`);
        }
     })

}
    </script>
@endsection
