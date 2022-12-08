@extends('master')

@section('title', 'Voucher Details')

@section('place')

    {{-- <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Sale Page</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Back to Dashborad</a></li>
            <li class="breadcrumb-item active">Sale Page</li>
        </ol>
    </div> --}}

@endsection

@section('content')

    <style>
        td {

            text-align: left;
            font-size: 20px;

            overflow: hidden;
            white-space: nowrap;
        }

        th {
            text-align: left;
            font-size: 15px;
        }

        h6 {
            font-size: 15px;
            font-weight: 600;
        }

        .btn {
            width: 130px;
            overflow: hidden;
            white-space: nowrap;
        }

    </style>



@php
    $from_id = session()->get('from');
@endphp

<input type="hidden" id="from_id" value="{{$from_id}}">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-7">
                    <ul class="nav nav-pills m-t-30 m-b-30">
                        <li class="nav-item">
                            <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                                SLIP
                            </a>
                        </li>
                        <li class=" nav-item">
                            <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">
                                A5
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content br-n pn">
        <div id="navpills-1" class="tab-pane active">
            <div class="row justify-content-center">
                <div class="col-md-12 printableArea" style="width:55%;">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <address>
                                        <h5> &nbsp;<b class="text-center text-black">Medical World</b></h5>

                                        <h6 class="text-black">No.28, 3rd Street, Hlaing Yadanar Mon Avenue,</h6>
                                        <h6 class="text-black">Hlaing Township, Yangon</h6>
                                        <h6 class="text-black"><i class="fas fa-mobile-alt"></i>09777005861,09777005862</h6>
                                    </address>
                                </div>
                                <div class="pull-right text-left">

                                    <h6 class="text-black">Voucher Number : {{ $unit->voucher_code }} </h6>
                                    <h6 class="text-black">Date : <i class="fa fa-calendar"></i>{{$unit->voucher_date}}</h6>
                                    <h6 class="text-black">Customer Name : {{$unit->sales_customer_name}} </h6>
                                    <h6 class="text-black">Customer Phone : {{$unit->sales_customer_phone}} </h6>
                                    <h6 class="text-black">Cashier : {{$unit->sale_by}} </h6>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive text-black" style="clear: both;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="text-black">
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>Qty*Price(Discount)</th>

                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-black" id="slip_live">
                                            @php
                                                $j=1;
                                            @endphp
                                            @foreach ($unit->counting_unit as  $key => $countingunit)
                                            @php
                                                if($countingunit->pivot->discount_value){
                                                    $price_wif_discount = $countingunit->pivot->price - (int)$countingunit->pivot->discount_value;
                                                }else{
                                                    $price_wif_discount = $countingunit->pivot->price;

                                                }
                                            @endphp
                                            <tr>
                                                <td style="font-size:15px;">{{$j++}}</td>
                                                <td style="font-size:15px;">{{ $countingunit->unit_name }}</td>
                                                <td style="font-size:15px;">{{ $countingunit->pivot->quantity }} * {{ $countingunit->pivot->price }} ({{$countingunit->pivot->discount_value}})</td>

                                                <td style="font-size:15px;" id="subtotal">{{ $countingunit->pivot->quantity *  $price_wif_discount}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="text-black">
                                            <tr>
                                                <td></td>
                                                <td></td>

                                                <td class="text-right" style="font-size:15px;">Total</td>
                                                <td id="total_charges" class="font-weight-bold" style="font-size:15px;">
                                                    <span id="slip_total"></span>{{$unit->total_price}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>

                                                <td class="text-right" style="font-size:15px;">Discount</td>
                                                <td id="discount" class="font-weight-bold" style="font-size:15px;">
                                                    <span id="slip_discount"></span>{{$unit->discount_value}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>

                                                <td class="text-right" style="font-size:15px;">Net</td>
                                                <td id="net" class="font-weight-bold" style="font-size:15px;">
                                                    <span id="slip_net"></span>{{$unit->total_price - $unit->discount_value}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>

                                                <td class="text-right" style="font-size:15px;">Pay</td>
                                                <td id="pay" class="font-weight-bold" style="font-size:15px;">{{$unit->pay}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>

                                                <td class="text-right" style="font-size:15px;">Change</td>
                                                <td id="changes" class="font-weight-bold" style="font-size:15px;">{{$unit->change}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <h6 class="text-center font-weight-bold text-black">**ကျေးဇူးတင်ပါသည်***</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="navpills-2" class="tab-pane ">
            <div class="row justify-content-center">
                <div class="col-md-12 printableArea">

                        <div class="card card-body ">
                            <div class="row justify-content-center" id="a5_voucher">
                                <div class="col-md-12">


                                        <div style="display:flex;justify-content:space-around">
                                            <div class="col-md-12 text-center">
                                                <div>
                                                    <img src="{{ asset('image/medical_world_logo_update.jpg') }}">
                                                </div>

                                                <div >

                                                    <p class="mt-2" style="font-size: 18px;">No.28, 3rd Street, Hlaing Yadanar Mon Avenue, Hlaing Township, Yangon
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
                                                        class="vou_code">{{$voucher->voucher_code}}</span>
                                                </h3>

                                                <h3 class=" mt-2 "
                                                    style="font-size : 15px;">@lang('lang.invoice')
                                                    @lang('lang.date')
                                                    :  {{$voucher->voucher_date}}</h3>

                                                <h3 class=" mt-2 "
                                                    style="font-size : 15px;">Cashier :  {{$voucher->sale_by}}</h3>


                                            </div>
                                            <div class="">
                                                <h3 class=" mt-2 " style="font-size : 15px">Customer Name: <span id="cus_name">{{$voucher->sales_customer_name}}</span>
                                                </h3>

                                                <h3 class=" mt-2 " style="font-size : 15px">Customer Phone :
                                                    <span id="cus_phone">{{$voucher->sales_customer_phone}}</span>
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
                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.number')</th>
                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.item')</th>
                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Color</th>
                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Size</th>
                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.order_voucher_qty')</th>
                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.price')</th>

                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">Discount</th>

                                                        <th style="font-size:15px; font-weight: normal; height: 15px; border: 1px solid black;" class="text-center">@lang('lang.total') Charge</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="text-center" id="a5_body">
                                                    @php
                                                    $i = 1;
                                                    @endphp
                                                    @foreach($unit->counting_unit as $item)
                                                    <tr>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{$i++}}</td>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{$item->unit_name}}</td>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{$item->colour->colour_name}}</td>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{$item->size->size_name}}</td>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{$item->pivot->quantity}}</td>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{$item->pivot->price}}</td>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{$item->pivot->discount_value}}</td>
                                                        <td class="text-center" style="font-size:13px;height: 15px; border: 1px solid black;">{{($item->pivot->price * $item->pivot->quantity) - $item->pivot->discount_value}}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td class="text-center" colspan="2" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">Total Amount</td>
                                                        <td colspan="2" class="text-center" style="font-size:15px;height: 15px; border: 1px solid black;">{{$voucher->total_price}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"></td>

                                                        <td class="text-center" colspan="2" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">Discount</td>
                                                        <td colspan="2" class="text-center" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">{{$voucher->discount_value}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td class="text-center" colspan="2" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">Net Amount</td>
                                                        <td colspan="2" class="text-center" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">{{$voucher->total_price - $voucher->discount_value}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-left" style="font-weight:normal;font-size:15px;height: 15px; border: none;">Remark : {{$voucher->sales_remark}}</td>
                                                        <td colspan="2" style="font-weight:normal;font-size:15px;height: 15px; border: none;">
                                                            <span id="total_charges_a5"></span>
                                                        </td>
                                                        <td class="text-center" colspan="2" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">Pay</td>
                                                        <td colspan="2" class="text-center" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">
                                                        {{$voucher->pay}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-left" style="font-weight:normal;font-size:15px;height: 15px; border: none;">Customer Address :</td>
                                                        <td colspan="2" style="font-weight:normal;font-size:15px;height: 15px; border: none;">

                                                        </td>
                                                        <td class="text-center" colspan="2" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">Change</td>
                                                        <td colspan="2" class="text-center" style="font-weight:normal;font-size:15px;height: 15px; border: 1px solid black;">
                                                            {{$voucher->change}}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-between align-items-center my-5 px-3">
                                                    <div class="">
                                                        <h5 class="font-weight-bold">PAID BY</h5>
                                                        <p style="font-size: 13px">Signature:</p>
                                                        <p style="font-size: 13px">Name :</p>
                                                        <p style="font-size: 13px">Position :</p>
                                                    </div>
                                                    <div class="">
                                                        <h5 class="font-weight-bold">RECEIVED BY</h5>
                                                         <p style="font-size: 13px">Signature:</p>
                                                        <p style="font-size: 13px">Name : {{$voucher->sale_by}}</p>
                                                        <p style="font-size: 13px">Position :</p>
                                                    </div>
                                                    <div class="">
                                                        <h5 class="font-weight-bold">APPROVED BY</h5>
                                                        <p style="font-size: 13px">Signature:</p>
                                                        <p style="font-size: 13px">Name :</p>
                                                        <p style="font-size: 13px">Position :</p>
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
    </div>










    <div class="row">
        <div class="col-md-12 mb-3 text-center">
            <button id="print" class="btn btn-success" type="button">
                <span><i class="fa fa-print"></i> Print</span>
            </button>
            <button id="edit" class="btn btn-warning" type="button">
                <span><i class="fa fa-edit"></i> Edit</span>
            </button>
            <button id="delete" class="btn btn-danger" data-id="{{$unit->id}}" type="button">
                <span><i class="fa fa-trash"></i> Delete</span>
            </button>
        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>

    <script>


        $(document).ready(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $(".tab-pane.active div.printableArea").printArea(options);

            });
            $('#edit').click(function(){
                var unit = @json($unit);
                clearLocalstorage(0);
                console.log(unit);


                localStorage.removeItem('voucher_details');
                localStorage.removeItem('mycart');
                localStorage.removeItem('grandTotal');

                var voucher_details = {
                    voucher_code: unit.voucher_code,
                    voucher_date: unit.voucher_date,
                    customer_id: unit.sales_customer_id,
                    customer_name: unit.sales_customer_name,
                    customer_phone: unit.sales_customer_phone,
                    remark: unit.sales_remark
                };

                localStorage.setItem('voucher_details', JSON.stringify(voucher_details));


                $.each(unit.counting_unit,function(i,countingUnit){

                    var item = {
                        id: countingUnit.id,
                        unit_name: countingUnit.unit_name,
                        current_qty: countingUnit.current_quantity,
                        order_qty: countingUnit.pivot.quantity,
                        selling_price: countingUnit.pivot.price,
                        each_sub: countingUnit.pivot.quantity * countingUnit.pivot.price,
                        discount: 0,
                        design_name: countingUnit.design ? countingUnit.design.design_name : '',
                        fabric_name: countingUnit.fabric ? countingUnit.fabric.fabric_name : '',
                        colour_name: countingUnit.colour ? countingUnit.colour.colour_name : '',
                        size_name: countingUnit.size ? countingUnit.size.size_name : '',
                        discount_type: countingUnit.pivot.discount_type,
                        discount_value: countingUnit.pivot.discount_value
                    };
                    console.log(item);

                    var mycart = localStorage.getItem('mycart');

                    if (mycart == null) {

                    mycart = '[]';

                    var mycartobj = JSON.parse(mycart);

                    mycartobj.push(item);

                    localStorage.setItem('mycart', JSON.stringify(mycartobj));

                    } else {

                    var mycartobj = JSON.parse(mycart);

                    mycartobj.push(item);

                    localStorage.setItem('mycart', JSON.stringify(mycartobj));
                    }

                })
                    var total_amount = {
                        sub_total: unit.total_price,
                        total_qty: unit.total_quantity,
                        vou_discount: 0,
                        total_discount_type: unit.discount_type,
                        total_discount_value: unit.discount_value
                    };
                    console.log("grand",total_amount);

                    var grand_total = localStorage.getItem('grandTotal');

                    localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                    localStorage.setItem('editvoucher', JSON.stringify(unit.id));

                    window.location.href = "{{ route('sale_page')}}";

            })
            $('#delete').click(function(){

                var voucher_id = $(this).data('id');
                swal(
                    {
                      title: "Voucher Delete",
                      text: "Enter Admin Code to delete voucher!",
                      content: "input",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      animation: "slide-from-top",
                      inputPlaceholder: "Admin Code"
                    }

                ).then((result)=> {
                     $.ajax({

                            type: 'POST',

                            url: '/voucher-delete',

                             data: {
                                 "_token": "{{ csrf_token() }}",
                                "voucher_id": voucher_id,
                                "admin_code": result,
                             },

                            success: function(data) {
                                if(data==1){
                                    swal({
                                        title: "Success",
                                        text: "Voucher ဖျက်ပြီးပါပြီ!",
                                        icon: "info",
                                    });

                                    setTimeout(function() {
                                        window.location.href = "{{ route('sale_history')}}";
                                    }, 600);
                                }else{
                                    swal({
                                        title: "Failed!",
                                        text: "Voucher ဖျက်မရပါ !",
                                        icon: "error",
                                    });

                                }
                             },


                        });
                });

            })
        });
    </script>


@endsection
