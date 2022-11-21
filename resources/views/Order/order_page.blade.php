@extends('master')

@section('title','Order Page')

@section('place')

@endsection

@section('content')

<style>
    th{
    overflow:hidden;
    white-space: nowrap;
  }
    .badge-success{
        background: #5AD669 !important;
    }
</style>

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="font-weight-normal text-black">@lang('lang.order') @lang('lang.page')</h4>
    </div>
</div>

<div class="row justify-content-start">
        <div class="col-8">
           <div class="mb-4">
                <div class="row">
                      <?php
                    //$from = date('Y-m-d',strtotime(now()));
                    //$to = date('Y-m-d',strtotime(now()));;
                    $from = date('Y-m-d',strtotime(now()));
                    $to = date('Y-m-d',strtotime(now()));
                    $id = 0;
                ?>
                    <div class="col-2">
                        <label class="">@lang('lang.from')</label>
                        <input type="date" name="from" id="from" class="form-control form-control-sm" onChange="setFrom(this.value)" required value="{{$from}}">
                    </div>
                    <div class="col-2">
                        <label class="">@lang('lang.to')</label>
                        <input type="date" name="to" id="to" class="form-control form-control-sm" onChange="setTo(this.value)" required value="{{$to}}">
                    </div>
                    <div class="col-2">
                        <label class="">Customer</label>
                        <select name="customer" id="customer" class="form-control form-control-sm select2" onChange="setCustomer(this.value)">
                            <option>Select Customers</option>
                                <option value=0 selected>All</option>
                            @foreach(\App\OrderCustomer::all() as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-2">
                        <label class="">Sales Person</label>
                        <select name="sales_person" id="sales_person" class="form-control form-control-sm select2" onChange="setSales(this.value)">
                            <option>Select Sales Person</option>
                                <option value='All' selected>All</option>
                            @foreach(\App\User::where('role','Sales')->orWhere('role','Owner')->get() as $employee)
                                <option value="{{$employee->name}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 m-t-30">
                        <button class="btn btn-sm rounded btn-outline-info" id="search_orders">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>

         @if(session()->get('user')->role != "Partner")
         <div class="col-md-4 mt-4">

             <form id="exportForm" onsubmit="return exportForm()" method="get">
                 <div class="row">
                <input type="hidden" name="export_from" id="export_from" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="export_to" id="export_to" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="export_customer" id="export_customer" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="export_sales" id="export_sales" class="form-control form-control-sm hidden" required>
                <div class="col-3">
                     <select name="export_data_type" id="export_data_type" class="form-control form-control-sm select2" style="font-size: 12px;">
                                <option value=1 selected>Orders</option>
                                <option value=2 >Items</option>
                        </select>

                </div>
                <div class="col-3">
                     <select name="export_type" id="export_type" class="form-control form-control-sm select2" style="font-size: 12px;">
                                <option value=1 selected>Excel</option>
                                <option value=2 >PDF</option>
                        </select>

                </div>

                <div class="col-6">
                <input type="submit" class="btn btn-sm rounded btn-outline-info col-4" value=" Export ">
                </div>
                </div>

            </form>


        </div>
        @endif


    </div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                @if($type == 1)
                <h4 class="font-weight-bold mt-2">@lang('lang.incoming_order') @lang('lang.list')</h4>
                @elseif($type == 2)
                <h4 class="font-weight-bold mt-2">@lang('lang.confirm_order') @lang('lang.list')</h4>
                @elseif($type == 3)
                <h4 class="font-weight-bold mt-2">@lang('lang.changes_order') @lang('lang.list')</h4>
                @elseif($type == 3 || $type == 4)
                <h4 class="font-weight-bold mt-2">@lang('lang.delivered_order') @lang('lang.list')</h4>
                @else
                <h4 class="font-weight-bold mt-2">@lang('lang.accepted_order') @lang('lang.list')</h4>
                @endif

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
                                <th>@lang('lang.order') @lang('lang.number')</th>
                                <th>@lang('lang.customer') @lang('lang.name')</th>
                                <th>@lang('lang.order') @lang('lang.address')</th>
                                <th>@lang('lang.order') @lang('lang.date')</th>
                                @if($type == 5)
                                <th>@lang('lang.accepted_date')</th>
                                @endif
                                <th>@lang('lang.total') @lang('lang.quantity')</th>
                                <th>@lang('lang.total') Amount</th>
                                <th>Advance</th>
                                <th>Outstanding</th>
                                <th>Order By</th>
                                @if($type == 4)
                                <th>Delivered Date</th>
                                <th>Delivered By</th>
                                <th>Deliver Remark</th>
                                @endif
                                <th>@lang('lang.order') @lang('lang.status')</th>

                                <th class="text-center">@lang('lang.details')</th>
                                @if($type != 5)
                                <th class="text-center">@lang('lang.action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="order_list" class="body">
                            <?php
                                $i = 0;
                            ?>

                            @foreach($order_lists as $order)
                                <tr>
                                    <td>{{++$i}}</td>
                                	<td>{{$order->order_number}}</td>
                                    <td>{{$order->name}}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">{{$order->address}}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">{{date('d-m-Y', strtotime($order->order_date))}}</td>
                                    @if($order->status == 5)
                                    <td style="overflow:hidden;white-space: nowrap;">{{date('d-m-Y h:i A' , strtotime($order->accepted_date))}}</td>
                                    @endif
                                	<td>{{$order->total_quantity}}</td>
                                	<td>{{$order->est_price}}</td>
                                    <td>{{$order->advance_pay}}</td>
                                    <td>{{$order->collect_amount}}</td>
                                    <td>{{$order->order_by}}</td>
                                    @if($type == 4)
                                    @php
                                        $delivered_date = date('d-m-Y',strtotime($order->delivered_date));
                                    @endphp
                                    <td>{{$delivered_date}}</td>
                                    <td>{{$order->delivered_by}}</td>
                                    <td>{{$order->delivered_remark}}</td>
                                    @endif

                                    @if($order->status == 1)
                                	<td><span class="badge badge-pill badge-info font-weight-bold">Incoming Order</span></td>
                                    @elseif($order->status == 2)
                                    <td><span class="badge badge-pill badge-info font-weight-bold">Confirm Order</span></td>
                                    @elseif($order->status == 3)
                                    <td><span class="badge badge-pill badge-info font-weight-bold">Change Order</span></td>
                                    @elseif($order->status == 4)
                                    <td><span class="badge badge-pill badge-success font-weight-bold">Delivered Order</span></td>
                                    @elseif($order->status == 5)
                                    <td><span class="badge badge-pill badge-info font-weight-bold">Accepted Order</span></td>
                                    @endif

                                     @if(session()->get('user')->role != "Partner")
                                	<td class="text-center">
                                        <a href="{{route('order_details',$order->id)}}" class="btn rounded btn-sm btn-outline-info">Details</a>
                                    </td>
                                    @endif

                                    @if(session()->get('user')->role != "Partner")
                                    @if($type != 5)
                                        @if($order->status !== 4)
                                        <td class="text-center">
                                            @if($order->status == 1)
                                                <div class="d-flex align-items-center">
                                                    <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#collapse_factory_order{{$order->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                    <a href="{{route('addFactoryOrder',$order->id)}}" class="btn mx-1 rounded btn-sm btn-outline-info" title="New Factory Order"><i class="fas fa-plus-circle"></i></a>
                                                    <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_{{$order->id}}">Confirm</a>
                                                </div>


                                                @elseif($order->status == 2)
                                                <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#deliver_factory_order{{$order->id}}" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                                <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_{{$order->id}}">Deliver Order</a>

                                                @elseif($order->status == 3)
                                                    <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_{{$order->id}}">Approve</a>
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
                                                            <form class="form" method="post" action="{{route('update_order_status')}}">
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
                                                                                <h3 class="text-black mt-3" style="font-size : 15px">Customer Name : {{ $order->name }} </h3>
                                                                                <h3 class="text-black mt-3" style="font-size : 15px">Customer Phone : {{  $order->phone }}</h3>

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

                                                                        @foreach(\App\CustomUnitOrder::where('order_id',$order->id)->get() as $custom_unit)

                                                                            <tr>
                                                                                <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $i++}}</td>
                                                                                <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->design_name}} {{ $custom_unit->fabric_name}}</td>
                                                                                <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->colour_name ?? "-" }} </td>
                                                                                <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->size_name ?? "-"}} </td>
                                                                                <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->order_qty ?? 0}}</td>
                                                                                <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->selling_price ?? 0}} </td>
                                                                                <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $order->est_price}} </td>
                                                                            </tr>
                                                                        @endforeach

                                                                        <tr>
                                                                            <td style="border: none;" colspan="3"></td>
                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Total Amount</td>
                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                                {{$order->est_price ?? 0}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3" style="border: none;"></td>

                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Discount</td>
                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                                {{$order->total_discount_value ?? 0}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3" style="border: none;"></td>
                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Net Amount</td>
                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                            {{ $order->est_price - $order->total_discount_value ?? 0}}
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="1" class="text-left" style="font-size:15px;height: 45px; border: none;">Remark :</td>
                                                                            <td class="text-left" colspan="2" style="font-size:15px;height: 45px; border: none;">
                                                                                {{$order->delivered_remark}}
                                                                            </td>
                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Advance</td>
                                                                            <td colspan="2" style="font-size:15px;height: 10px; border: 1px solid black;">
                                                                                {{ $order->advance_pay }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="1" class="text-left" style="font-size:15px;height: 45px; border: none;">Address :</td>
                                                                            <td class="text-left" colspan="2" style="font-size:15px;height: 45px; border: none;">
                                                                                {{$order->address}}
                                                                            </td>
                                                                            <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Balance</td>
                                                                            <td colspan="2" class="text-center" style="font-size:15px;height: 45px; border: 1px solid black;">
                                                                            {{ ($order->est_price - $order->total_discount_value) - $order->advance_pay ?? 0}}</td>
                                                                        </tr>


                                                                        </tbody>
                                                                    </table>

                                                                    <div class="d-flex justify-content-between align-items-left my-5 px-3">
                                                                        <div class="">
                                                                        <h4 class="font-weight-bold">Payment Information</h4>

                                        <table>
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
                                        </table>
                                        </div>


                                                                        </div>

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
                                    @endif
                                @endif
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
{{--                                                        <a href="{{route('editFactoryOrder',$factory->id)}}" class="btn btn-sm rounded btn-outline-info" title="Edit Factory Order">--}}
{{--                                                            <i class="fas fa-pencil-alt"></i>--}}
{{--                                                        </a>--}}
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

    <input type="hidden" id="type" value="{{$type}}">
</div>

@endsection


@section('js')

<script type="text/javascript">

$(document).ready(function(){
	     const today = new Date();
         var dd = today.getDate();
         var mm = today.getMonth()+1;
         var yyyy= today.getFullYear();
	    $('#export_from').val(yyyy+'-'+mm+'-'+dd);
	    $('#export_to').val(yyyy+'-'+mm+'-'+dd);
	    $('#export_customer').val(0);
	    $('#export_sales').val('All');
	    $('#export_data_type').val(1);
	    $("#export_type").val(1);
	});

     function setFrom(value){
        $("#exportForm :input[name=export_from]").val(value);
    }

     function setTo(value){
        $("#exportForm :input[name=export_to]").val(value);
    }

     function setCustomer(value){
        $("#exportForm :input[name=export_customer]").val(value);
    }

    function setSales(value){
        $("#exportForm :input[name=export_sales]").val(value);
    }

    function exportForm(){

        //var form = document.getElementById("exportForm");
        //var data = new URLSearchParams(form).toString();
        var from = $("#exportForm :input[name=export_from]").val();
        var to = $("#exportForm :input[name=export_to]").val();
        var id =  $("#exportForm :input[name=export_customer]").val();
        var order_by = $("#exportForm :input[name=export_sales]").val();
        var order_type = $('#type').val();
        var data_type = $("#exportForm :input[name=export_data_type]").find(":selected").val();
        var type = $("#exportForm :input[name=export_type]").find(":selected").val();
        console.log(from,to,id,order_by,order_type,data_type,type);



         let url = `/export-totalorderhistory/${from}/${to}/${id}/${order_by}/${order_type}/${data_type}/${type}`;
         window.location.href= url;

    //      const today = new Date();
    //      var dd = today.getDate();
    //      var mm = today.getMonth()+1;
    //      var yyyy= today.getFullYear();
    //      if(dd <10){
    //          dd = '0' + dd;
    //      }
    //      if(mm < 10){
    //          mm = '0' + mm;
    //      }
    //       $('#export_from').val(yyyy+'-'+mm+'-'+dd);
	   // $('#export_to').val(yyyy+'-'+mm+'-'+dd);
	   // $('#export_customer').val(0);
	   // $('#export_sales').val('All');
    //      $('#export_data_type').val(1);
	   // $("#export_type").val(1);
        return false;
    };

    function search_table(){
            var input, filter, table,tr,td,i;
            input = document.getElementById("table_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("order_table");
            tr = table.getElementsByTagName("tr");

            var searchColumn = [1,2,3,4,5,6,7,8,9,10];

            for(i = 0; i < tr.length; i++){
                if($(tr[i]).parent().attr('class') == 'head' ){
                    continue;
                }

                var found = false;

                for(var k=0; k < searchColumn.length; k++){
                    td = tr[i].getElementsByTagName("td")[searchColumn[k]];
                    if(td){
                        if(td.innerHTML.toUpperCase().indexOf(filter) > -1){
                            found=true;
                        }
                    }
                }
                if(found == true){
                    tr[i].style.display = "";
                }else{

                    tr[i].style.display = "none";
                }
            }
        }

        $("#do_print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };


            $("div.printableArea").printArea(options);
        });

    $('#search_orders').click(function(){
        // let current_Date = $('#current_Date').val();
        // let fb_page = $('#fb_pages').val();
        // let order_type = $('#order_type').val();
        // let url = `/arrived-orders/${current_Date}/${fb_page}/${order_type}`;
        // window.location.href= url;


        var from = $('#from').val();
        var to = $('#to').val();
        var customer = $("#customer").find(":selected").val();
        var sales = $("#sales_person").find(":selected").val();
        var type = $('#type').val();
        var order_ids = [];
        console.log(from,to,customer,sales);
        $.ajax({

            type: 'POST',



            url: '{{ route('search_ajaxorder_history') }}',

            data: {
                "_token": "{{ csrf_token() }}",

                "from" : from,
                "to" : to,
                "customer" : customer,
                "sales" : sales,
                "type" : type
            },

            success: function(data) {
                if (data.length >0) {
                    console.log(data);
                    var html = '';
                    $.each(data, function(i, order) {

                       order_ids.push(order.id);
                        var url1 = '{{ route('order_details', ':order_id') }}';

                        url1 = url1.replace(':order_id', order.id);

                        var status = '';
                        var badge_type = 'badge-info';
                        if(order.status == 1){
                            status = "Incoming Order";

                        }else if(order.status == 2){
                            status = "Confirm Order";

                        }else if(order.status == 3){
                            status = "Change Order";

                        }else if(order.status == 4){
                            status = "Delivered Order";
                            badge_type = "badge-success";
                        }else{
                            status = "Accepted Order";
                        }
                        html += `
                           <tr>
                                    <td>${++i}</td>
                                	<td>${order.order_number}</td>
                                    <td>${order.name}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">${order.address}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">${order.order_date}</td>
                                    @if($order->status == 5)
                                    <td style="overflow:hidden;white-space: nowrap;">{{date('d-m-Y h:i A' , strtotime($order->accepted_date))}}</td>
                                    @endif
                                	<td>${order.total_quantity}</td>
                                	<td>${order.est_price}</td>
                                    <td>${order.advance_pay}</td>
                                    <td>${order.collect_amount}</td>
                                    <td>${order.order_by}</td>
                                	<td><span class="badge badge-pill ${badge_type} font-weight-bold">${status}</span></td>

                                	<td class="text-center">
                                        <a href="${url1}" class="btn rounded btn-sm btn-outline-info">Details</a>
                                    </td>
                                    <td class="text-center">
                                                <div class="d-flex align-items-center">
                    `;

                    if(order.status != 4){
                    if(order.status == 1){
                        var url2 = '{{ route('addFactoryOrder', ':order_id') }}';

                        url2 = url2.replace(':order_id', order.id);

                        html +=`
                                                    <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#collapse_factory_order${order.id}" aria-expanded="false" aria-controls="collapseExample">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                    <a href="${url2}" class="btn mx-1 rounded btn-sm btn-outline-info" title="New Factory Order"><i class="fas fa-plus-circle"></i></a>
                                                    <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_${order.id}">Confirm</a>
                                                </div>

                        `;
                    }else if(order.status == 2){
                        html += `
                            <button title="Show Factory Order Lists" class="btn rounded btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#deliver_factory_order${order.id}" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                                <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_${order.id}">Deliver Order</a>
                                                </div>

                        `;
                    }else if(order.status == 3){
                        html += `
                            <a href="#" class="btn rounded btn-sm btn-outline-info" data-toggle="modal" data-target="#confirm_${order.id}">Approve</a>
                                                </div>
                        `;
                    }
                    else{
                        html += `</tr>`;
                    }


                    html += `
                        <div class="modal fade" id="confirm_${order.id}" role="dialog" aria-hidden="true">
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
                                                            <form class="form" method="post" action="{{route('update_order_status')}}">
                                                                @csrf
                                                                <input type="hidden" name="order_id" value="${order.id}">
                                                                <input type="hidden" name="order_status" value="${order.status}">
                    `;

                    if(order.status == 1){
                        html += `
                            <div class="form-group row">
                                                                        <label for="example-text-input" class="col-12 col-form-label">
                                                                            <h3 class="font-weight-bold">Are You Sure to Confirm this Order?</h3>
                                                                        </label>
                            </div>
                        `;
                    }else if(order.status == 2){
                        html += `
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
                        `;
                    }else if(order.status == 3){
                        html += `
                            <div class="form-group row">
                                                                        <label for="example-text-input" class="col-12 col-form-label">
                                                                            <h3 class="font-weight-bold">Do you want to approve the changes in this order?</h3>
                                                                        </label>

                                                                    </div>
                        `;
                    }

                    html += `
                        <div class="d-flex justify-content-around align-items-center">
                                                                    <button class="btn btn-sm rounded btn-danger" data-dismiss="modal" aria-label="Close">
                                                                        No
                                                                    </button>
                                                                    <button class="btn btn-sm rounded btn-primary">Yes</button>
                                                                </div>

                                                                </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        </tr>
                        <tr>
                                    <td colspan="10">
                                        <div class="collapse" id="collapse_factory_order${order.id}">
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
                                `;

                                var factoryorder_count = 0;
                                $.each(order.factory_orders, function(i, factory_order) {
                                        if(factory_order.status == 1 || factory_order.status == 3){
                                            factoryorder_count +=1;
                                        var url3 = '{{ route('updateFactoryOrderItem', ':factoryorder_id') }}';

                                        url3 = url3.replace(':factoryorder_id', factory_order.id);

                                        var url4 = '{{ route('factoryOrderDetail', ':factoryorder_id') }}';

                        url4 = url4.replace(':factoryorder_id', factory_order.id);

                                         html +=`       <tr class="text-center">
                                                    <td>${factory_order.factory_order_number}</td>
                                                    <td>${factory_order.department_name ?? '-'}</td>
                                                    <td>${factory_order.plan_date ?? '-'}</td>
                                                    <td>${factory_order.remark ?? '-'}</td>
                                                    <td>${factory_order.showroom}</td>
                                                    <td>${factory_order.total_quantity}</td>
                                                    <td>
                                                        <a href="${url3}" class="btn btn-sm rounded btn-outline-info" title="Show Factory Order Item">
                                                            <i class="fas fa-list-alt"></i>
                                                        </a>

                                                        <a href="${url4}" class="btn btn-sm rounded btn-outline-info" title="Factory Order Detail">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                `;
                                        }
                                        });

                                if(factoryorder_count == 0){
                                    html+=`
                                        <tr class="text-center">
                                                        <td colspan="10"><p class="alert alert-warning">There is no data yet, please add factory order!</p></td>
                                                    </tr>
                                    `;
                                }

                            html += `
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10">
                                        <div class="collapse" id="deliver_factory_order${order.id}">
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
                    `;

                    var deliverorder_count = 0;
                    $.each(order.factory_orders, function(i, factory_order) {
                                        if(factory_order.status == 2){
                                            deliverorder_count += 1;
                                        var url5 = '{{ route('factoryOrderDetail', ':factoryorder_id') }}';

                        url5 = url5.replace(':factoryorder_id', factory_order.id);

                                         html +=`       <tr class="text-center">
                                                    <td>${factory_order.factory_order_number}</td>
                                                    <td>${factory_order.department_name ?? '-'}</td>
                                                    <td>${factory_order.delivery_date ?? '-'}</td>
                                                    <td>${factory_order.delivery_remark ?? '-'}</td>
                                                    <td>${factory_order.showroom}</td>
                                                    <td>${factory_order.total_quantity}</td>
                                                    <td>
                                                        <a href="${url5}" class="btn btn-sm rounded btn-outline-info" title="Factory Order Detail">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                `;
                                        }
                                        });

                        if(deliverorder_count == 0){
                            html += `
                                <tr class="text-center">
                                                        <td colspan="10"><p class="alert alert-warning">There is no delivered factory Order!</p></td>
                                                    </tr>
                            `;
                        }

                        html += `
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            `;
                    }else{
                        html += `
                                            <button class="btn btn-sm rounded btn-danger" type="button"
                                                    data-toggle="modal" data-target="#orderVoucher{{$order->id}}">
                                                <span>Voucher</span>
                                            </button>
                                        </div>
                                        </td>
                                        </tr>
                        `;
                    }

                        $('#order_list').empty();
                       $('#order_list').html(html);
                    });



                  // $('#item_table').DataTable().clear().draw();


                    // swal({
                    //     toast:true,
                    //     position:'top-end',
                    //     title:"Success",
                    //     text:"Orders Changed!",
                    //     button:false,
                    //     timer:500,
                    //     icon:"success"
                    // });

                } else {
                    var html = `

                    <tr>
                        <td colspan="9" class="text-danger text-center">No Data Found</td>
                    </tr>

                    `;
                    $('#order_list').empty();
                    $('#order_list').html(html);

                }
            },
            });

            //$('#order_table').DataTable().clear().draw();







    })

</script>



@endsection
