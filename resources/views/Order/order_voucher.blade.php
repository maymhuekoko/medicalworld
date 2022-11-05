@extends('master')

@section('title','Order Voucher')

@section('place')
<style>

</style>

@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="my-3">
            <div class="card card-body printableArea">


                <div style="display:flex;justify-content:space-around">

                    <div class="col-12 text-center">
                        <div>
                            <img src="{{ asset("image/medicalWorld.png") }}" width="800px">
                        </div>

                        <div>
                            <p class="mt-2" style="font-size: 25px;">No.28, 3rd Street, Hlaing Yadanar Mon Avenue, Hlaing Township, Yangon
                                <br /><i class="fas fa-mobile-alt" style="font-size: 25px;"></i> 09 777 00 5861, 09 777 00 5862
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
                            <div>
                                <h3 class="text-black mt-3" style="font-size : 20px">@lang('lang.invoice') @lang('lang.number') : {{$orderVoucher->voucher_number}}  </h3>
                                <h3 class="text-black mt-3" style="font-size : 20px">@lang('lang.invoice') @lang('lang.date') :  {{$orderVoucher->voucher_date}}</h3>
                            </div>
                            <div>
                                <h3 class="text-black mt-3" style="font-size : 20px">Customer Name : {{$order->name}}</h3>
                                <h3 class="text-black mt-3" style="font-size : 20px">Customer Phone : {{$order->phone}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table style="width: 100%;">
                            <thead>
                            <tr>
                                <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">@lang('lang.number')</th>
                                <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">@lang('lang.item')</th>
                                <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">Colour</th>
                                <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">Size</th>
                                <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">@lang('lang.order_voucher_qty')</th>
                                <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">@lang('lang.price')</th>
                                 <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">Discount</th>
                                <th style="font-size:20px; font-weight: normal; height: 20px; border: 1px solid black;" class="text-center">@lang('lang.total')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1 ;
                            @endphp
                            @foreach(\App\CustomUnitOrder::where('order_id',$order->id)->get() as $custom_unit)
                                <tr>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ $i++}}</td>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ $custom_unit->design_name}} {{$custom_unit->fabric_name}} </td>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ $custom_unit->colour_name ?? "-" }} </td>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ $custom_unit->size_name ?? "-"}} </td>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ $custom_unit->order_qty ?? 0}}</td>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ $custom_unit->selling_price ?? 0}} </td>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ $custom_unit->discount_value ?? 0}} </td>
                                    <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">{{ ($custom_unit->order_qty * $custom_unit->selling_price) - $custom_unit->discount_value ?? 0}} </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5"></td>
                                <td class="text-center" colspan="2" style="font-size:20px;height: 45px; border: 1px solid black;">Total Amount</td>
                                <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">
                                    {{$order->est_price ?? 0}}</td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>

                                <td class="text-center" colspan="2" style="font-size:20px;height: 45px; border: 1px solid black;">Discount</td>
                                <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">
                                    {{$order->total_discount_value ?? 0}}</td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                                <td class="text-center" colspan="2" style="font-size:20px;height: 45px; border: 1px solid black;">Net Amount</td>
                                <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">
                                {{ $order->est_price - $order->total_discount_value ?? 0}}
                            </tr>
                            <tr>
                                <td colspan="3" class="text-left" style="font-size:20px;height: 45px; border: none;">Remark :</td>
                                <td class="text-left" colspan="2" style="font-size:20px;height: 45px; border: none;">


                                </td>
                                <td class="text-center" colspan="2" style="font-size:20px;height: 45px; border: 1px solid black;">Advance</td>
                                <td  class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">
                                    {{$order->advance_pay ?? 0}}
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3" class="text-left" style="font-size:20px;height: 45px; border: none;">Customer Address :</td>
                                <td class="text-left" colspan="2" style="font-size:20px;height: 45px; border: none;">
                                    {{ $order->address }}
                                </td>
                                <td class="text-center" colspan="2" style="font-size:20px;height: 45px; border: 1px solid black;">Balance</td>
                                <td class="text-center" style="font-size:20px;height: 45px; border: 1px solid black;">
                                    {{ ($order->est_price - $order->total_discount_value) - $order->advance_pay ?? 0}}
                                </td>
                            </tr>


                            </tbody>


                        </table>
                        <div class="d-flex justify-content-between align-items-center my-5 px-3">
                            <div class="">
                                <h4 class="font-weight-bold">PAID BY</h4>
                                <p class="text-left" style="font-size: 15px">Sign :</p>
                                <p class="text-left" style="font-size: 15px">Name :</p>
                                <p class="text-left" style="font-size: 15px">Position :</p>
                            </div>
                            <div class="">
                                <h4 class="font-weight-bold">RECEIVED BY</h4>
                                <p class="text-left" style="font-size: 15px">Sign : </p>
                                <p class="text-left" style="font-size: 15px">Name : {{session()->get('user')->name}}</p>
                                <p class="text-left" style="font-size: 15px">Position :</p>
                            </div>
                            <div class="">
                                <h4 class="font-weight-bold">APPROVED BY</h4>
                                <p class="text-left" style="font-size: 15px">Sign :</p>
                                <p class="text-left" style="font-size: 15px">Name :</p>
                                <p class="text-left" style="font-size: 15px">Position :</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="d-flex justify-content-center mb-3">
            <a href="{{route('order_history')}}" class="btn btn-outline-info rounded mr-3">
                <i class="fas fa-arrow-left mr-1"></i>Back
            </a>
            <button id="print" class="btn btn-outline-info rounded">
                <i class="fas fa-print mr-1"></i>Print
            </button>
        </div>
</div>
</div>


@endsection


@section('js')

<script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

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
