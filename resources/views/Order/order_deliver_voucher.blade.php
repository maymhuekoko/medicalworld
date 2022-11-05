@extends('master')

@section('title', 'Factory Order Details')

@section('place')
@endsection
@section('content')
    @php
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="my-3">
                <div class="card printableArea px-5">
                    <div style="display:flex;justify-content:space-around">

                        <div class="col-md-12 text-center">
                            <div>
                                <img src="{{ asset("image/medicalWorld.png") }}" width="500px">
                            </div>

                            <div>
                                <p class="mt-2" style="font-size: 15px;">No.28, Hlaing Yadanar Mon 3rd Street, Hlaing Yadanar Mon Avenue, Hlaing Township, Yangon
                                    <br /><i class="fas fa-mobile-alt" style="font-size: 15px;"></i> 09 777 00 5861, 09 777 00 5862
                                </p>
                            </div>
                            <div>
                                <h2 class="text-center text-secondary font-weight-bold">Order Voucher</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="text-left">
                                    <h3 class="text-black mt-3" style="font-size : 15px">@lang('lang.invoice') @lang('lang.number') : {{$order->order_number}} </h3>
                                    <h3 class="text-black mt-3" style="font-size : 15px">@lang('lang.invoice') @lang('lang.date') : @if($order->status == 4){{$orderVoucher->voucher_date}}@else-@endif </h3>
                                    <h3 class="text-black mt-3" style="font-size : 15px">Order @lang('lang.date') : {{$order->order_date}} </h3>
                                </div>
                                <div class="text-left">
                                    <h3 class="text-black mt-3" style="font-size : 15px">Customer Name : {{ $order->name }} </h3>
                                    <h3 class="text-black mt-3" style="font-size : 15px">Customer Phone : {{  $order->phone }}</h3>
                                    <h3 class="text-black mt-3" style="font-size : 15px">Delivered By : {{  $order->delivered_by }}</h3>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <table style="width: 100%;">
                            <thead>
                            <tr>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.number')</th>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.item')</th>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Colour</th>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Size</th>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.order_voucher_qty')</th>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.price')</th>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Discount</th>
                                <th style="font-size:17px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.total')</th>
                            </tr>
                            </thead>
                            <tbody>


                            @php

                                $i = 1 ;
                            @endphp

                            @foreach(\App\CustomUnitOrder::where('order_id',$order->id)->get() as $custom_unit)
                                @php
                                    @endphp
                                <tr>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $i++}}</td>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->design_name}} {{ $custom_unit->fabric_name}}</td>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->colour_name?? "-" }} </td>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->size_name ?? "-" }} </td>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->order_qty ?? 0}}</td>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->selling_price ?? 0}} </td>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ $custom_unit->discount_value ?? 0}} </td>
                                    <td class="text-center" style="font-size:13px;height: 45px; border: 1px solid black;">{{ ($custom_unit->order_qty * $custom_unit->selling_price) - $custom_unit->discount_value ?? 0}} </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td style="border: none;" colspan="4"></td>
                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Total Amount</td>
                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                    {{$order->est_price ?? 0}}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border: none;"></td>

                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Discount</td>
                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                    {{$order->total_discount_value ?? 0}}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border: none;"></td>
                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Net Amount</td>
                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">
                                    {{ $order->est_price - $order->total_discount_value ?? 0}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left" style="font-size:15px;height: 45px; border: none;">Remark :</td>
                                <td class="text-left" colspan="2" style="font-size:15px;height: 45px; border: none;">
                                    {{ $order->delivered_remark??""}}
                                </td>
                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Advance</td>
                                <td colspan="2" class="text-center" style="font-size:15px;height: 10px; border: 1px solid black;">
                                    <span>{{ $order->advance_pay }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left" style="font-size:15px;height: 45px; border: none;">Address :</td>
                                <td class="text-left" colspan="2" style="font-size:15px;height: 45px; border: none;">
                                    {{$order->address}}
                                </td>
                                <td class="text-center" colspan="2" style="font-size:15px;height: 45px; border: 1px solid black;">Balance</td>
                                <td colspan="2" class="text-center" style="font-size:15px;height: 45px; border: 1px solid black;">
                                    {{ ($order->est_price - $order->total_discount_value) - $order->advance_pay ?? 0}}
                                </td>
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


                <div class="d-flex justify-content-center mb-5">
                    <button id="print" class="btn btn-sm rounded btn-outline-info mr-2">
                        <i class="fas fa-print mr-1"></i>Print
                    </button>
                    @if($order->status == 4)
                    <a href="{{route('order_page','4')}}" class="btn btn-sm rounded btn-outline-primary">
                        <i class="fas fa-arrow-circle-right mr-1"></i>Go to Deliver Order
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endsection
        @section('js')
            <script>
                $(document).ready(function() {
                    $("#print").click(function() {
                        var mode = 'iframe'; //popup
                        var close = mode == "popup";
                        var options = {
                            mode: mode,
                            popClose: close
                        };
                        $("div.printableArea").printArea(options);
                    });
                });
            </script>
@endsection




