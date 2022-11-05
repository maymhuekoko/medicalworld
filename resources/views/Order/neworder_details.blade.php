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
            font-weight: bold;
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
    <div class="row justify-content-center pl-4 mt-5"  style="font-weight: 500">
            <div class="col-md-8 text-left font14">
                <div class="row mb-2">
                    <div class="col-md-6">
                            Customer Name :
                         {{$orders->name}}
                    </div>
                    <div class="col-md-6">
                            Total  :
                        {{$orders->est_price}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Customer Phone : {{$orders->phone}}

                    </div>
                    <div class="col-md-6">
                        Prepaid amount : {{$orders->advance_pay}}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Customer Address : {{$orders->address}}

                    </div>
                    <div class="col-md-6">
                        Discount : {{$orders->total_discount_value}}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Order Date : {{$orders->order_date}}

                    </div>
                    <div class="col-md-6">
                        Payment Type :
                         @if ($orders->payment_type==1)
                            COD
                            @elseif($orders->payment_type==2)
                            Prepaid Full
                            @else
                            Prepaid Partial
                        @endif
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Order No : {{$orders->order_number}}
                    </div>
                    <div class="col-md-6">
                        Order Status : <span class="badge badge-info font-weight-bold">
                        @if ($orders->status==1)
                            Incoming
                            @elseif($orders->status==2)
                            Confirmed
                            @elseif($orders->status==3)
                            Changed Order
                            @elseif($orders->status==4)
                            Delivered
                            @elseif($orders->status==5)
                            Canceled
                            @else
                            Prepaid Partial
                        @endif

                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Showroom:
                         {{$orders->showroom}}
                    </div>
                    <div class="col-md-6 btn-group">

                        <a href="{{route('transaction_list',$orders->id)}}" type="button" class="btn btn-sm btn-warning w-30">Transaction</a>

                    </div>
                </div>
            </div>
    </div>
    <div class="row justify-content-center">
        <ul class="nav nav-pills m-t-30 m-b-30 container offset-md-2">
            <li class="nav-item">
                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                Item Detail
                </a>
            </li>
            <li class="nav-item">
                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">
                Transaction List
                </a>
            </li>
        </ul>
        <div class="col-md-8">
        <!-- Begin navpill -->
        <div class="tab-content br-n pn">
        <div id="navpills-1" class="tab-pane active">
            <div class="card card-body">
            <h4 class="">Item Detail</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive text-black" style="clear: both;">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr class="text-black">
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th class="text-center">Action</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="text-black">

                                    @php
                                        $j=1;
                                    @endphp

                                    @foreach($customUnitOrders as $customUnitOrder)
                                    <tr>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$j++}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$customUnitOrder->item_name}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$customUnitOrder->order_qty}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$customUnitOrder->selling_price}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$customUnitOrder->order_qty * $customUnitOrder->selling_price}}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#spec{{$customUnitOrder->id}}">Spec
                                            </a>
                                        </td>
                                        {{--                                        Modal--}}
                                        <div class="modal fade" id="spec{{$customUnitOrder->id}}" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title text-primary font-weight-bold">Specification</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body p-5">
                                                        @if($customUnitOrder->design_id)
                                                            <div class="mb-2">
                                                                <h3 class="font-bold">Design</h3>
                                                                <ul class="list-group">
                                                                    @foreach(\App\Design::where("id",$customUnitOrder->design_id)->get() as $d)
                                                                        <li class="list-group-item"> {{ucfirst($d->design_name)}}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>

                                                            @endif

                                                        @if($customUnitOrder->fabric_id)
                                                                <div class="mb-2">
                                                                    <h3 class="font-bold">Fabric</h3>
                                                                    <ul class="list-group">
                                                                        @foreach(\App\Fabric::where("id",$customUnitOrder->fabric_id)->get() as $f)
                                                                            <li class="list-group-item"> {{ucfirst($f->fabric_name)}}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                        @if($customUnitOrder->colour_id)
                                                                <div class="mb-2">
                                                                    <h3 class="font-bold">Colour</h3>
                                                                    <ul class="list-group">
                                                                        @foreach(\App\Colour::where("id",$customUnitOrder->colour_id)->get() as $c)
                                                                            <li class="list-group-item"> {{ucfirst($c->colour_name)}}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                        @if($customUnitOrder->size_id)
                                                                <div class="mb-2">
                                                                    <h3 class="font-bold">Size</h3>
                                                                    <ul class="list-group">
                                                                        @foreach(\App\Size::where("id",$customUnitOrder->size_id)->get() as $s)
                                                                            <li class="list-group-item"> {{ucfirst($s->size_name)}}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                        @if($customUnitOrder->gender_id)
                                                                <div class="mb-2">
                                                                    <h3 class="font-bold">Gender</h3>
                                                                    <ul class="list-group">
                                                                        @foreach(\App\Gender::where("id",$customUnitOrder->gender_id)->get() as $g)
                                                                            <li class="list-group-item"> {{ucfirst($g->gender_name)}}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end navpil -1 -->
        <div id="navpills-2" class="tab-pane">
            <div class="card mt-1">
            <div class="card-body">
                <h3>Transaction List</h3>
                <!-- Begin Table -->
                    <div class="table-responsive text-black">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transaction Date and Time</th>
                                    <th style="overflow:hidden;white-space: nowrap;">Bank Account</th>
                                    <th style="overflow:hidden;white-space: nowrap;">Pay Amount</th>
                                    <th style="overflow:hidden;white-space: nowrap;">Remark</th>
                                    <th style="overflow:hidden;white-space: nowrap;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @foreach($transaction as $tran)
                                <tr>
                                <td style="font-size:16px">{{$i++}}</td>
                                <td style="font-size:16px">{{$tran->tran_date}}-{{$tran->tran_time}}</td>
                                <td style="font-size:16px">{{$tran->bank_account->bank_name}}-{{$tran->bank_account->account_number}}</td>
                                <td style="font-size:16px">{{$tran->pay_amount}}</td>
                                <td style="font-size:16px">{{$tran->remark}}</td>
                                <td><a href="" class="btn btn-danger btn-sm w-10" style="border-radius: 25px;">Delete</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                <!-- End table -->
                </div>
            </div>
        </div><!-- end navpil -2 -->
        </div><!-- all navpill end -->
        </div><!-- all col-md-8 end -->
    </div>




    <div class="row">
        <div class="col-md-12 mb-3 text-center">
            <button id="print" class="btn btn-success" type="button" data-id="{{$orders->id ?? 0}}">
                <span><i class="fa fa-print"></i> Print</span>
            </button>
            <button id="edit" class="btn btn-warning" data-status="{{$orders->status ?? 0}}" data-updatetimes="{{$orders->update_times ?? 0}}" type="button">
                <span><i class="fa fa-edit"></i> Edit</span>
            </button>
            {{-- //TODO Payment Delete --}}
            <button id="delete" class="btn btn-danger" data-id="{{$orders->id ?? 0}}" data-status="{{$orders->status ?? 0}}" type="button">
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
                // var mode = 'iframe'; //popup
                // var close = mode == "popup";
                // var options = {
                //     mode: mode,
                //     popClose: close
                // };
                // $(".tab-pane.active div.printableArea").printArea(options);
                var order_id = $(this).data('id');
                var url1 = '{{ route('order_voucher_print', ':order_id') }}';

                url1 = url1.replace(':order_id', order_id);
                
                window.location.href = url1;
            });
            $('#edit').click(function(){
                localStorage.clear();
                let customUnitOrders = @json($customUnitOrders);
                let order = @json($orders);
                localStorage.removeItem('order_detail');
                localStorage.removeItem('myOrderCart');
                localStorage.removeItem('orderGrandTotal');
                var item_count = 0;
                console.log(order);
                
                var updateTimes = $(this).data('updatetimes');
                
                if(updateTimes >= 3){
                    swal({
                            title: "Order Update Failed!",
                            text: "Order already updated 2 times!",
                            icon: "error",
                        });
                }else{
                
                let orderDetail = {
                    orderNumber: order.order_number,
                    showroom: order.showroom,
                    customerName: order.name,
                    customerPhone: order.phone,
                    address: order.address,
                    orderDate: order.order_date,
                    paymentType: order.payment_type,
                    advancePay: order.advance_pay,
                    deliveryFee: order.delivery_fee,
                    logoFee: order.logo_fee
                }
                localStorage.setItem('order_detail', JSON.stringify(orderDetail));
                $.each(customUnitOrders,function (i,customUnit){
                    console.log(customUnit);
                    item_count +=1;
                    let localCustomUnit = {
                        id: item_count,
                        oldunit_flag : true,
                        oldunit_id: customUnit.id,
                        item_name: customUnit.item_name,
                        order_qty: customUnit.order_qty,
                        selling_price: customUnit.selling_price,
                        each_sub: customUnit.order_qty * customUnit.selling_price,
                        design_id: customUnit.design_id,
                        design_name: customUnit.design_name,
                        fabric_id: customUnit.fabric_id,
                        fabric_name: customUnit.fabric_name,
                        color_id: customUnit.colour_id,
                        color_name: customUnit.colour_name,
                        gender_id: customUnit.gender_id,
                        gender_name: customUnit.gender_name,
                        size_id: customUnit.size_id,
                        size_name: customUnit.size_name,
                        discount_type: customUnit.discount_type,
                        discount_value: customUnit.discount_value,
                    }
                    let myOrderCart = localStorage.getItem('myOrderCart');
                    if (myOrderCart == null) {
                        myOrderCart = '[]';
                        let myOrderCartObj = JSON.parse(myOrderCart);
                        myOrderCartObj.push(localCustomUnit);
                        localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                    } else {
                        let myOrderCartObj = JSON.parse(myOrderCart);

                        myOrderCartObj.push(localCustomUnit);

                        localStorage.setItem('myOrderCart', JSON.stringify(myOrderCartObj));
                    }
                })

                let myOrderCart = localStorage.getItem('myOrderCart');
                //let orderDiscount = localStorage.getItem('order_detail');
                let myOrderCartObj = JSON.parse(myOrderCart);
               // let orderDiscountObj = JSON.parse(orderDiscount);
                let total_qty = myOrderCartObj.reduce((pv, cv) => pv + cv.order_qty, 0);
                let sub_total = myOrderCartObj.reduce((pv, cv) => pv + cv.each_sub, 0);
               // let vou_discount = orderDiscountObj.total_discount_value;
                //let vou_discount_type = orderDiscountObj.total_discount_type;
                let orderGrandTotal = localStorage.getItem('orderGrandTotal');
                let total_amount = {
                    sub_total: sub_total,
                    total_qty: total_qty,
                    total_discount_type: order.total_discount_type,
                    total_discount_value: order.total_discount_value,
                    };
                localStorage.setItem('orderGrandTotal', JSON.stringify(total_amount));
                localStorage.setItem('editvoucher', JSON.stringify(order.id));
                localStorage.setItem('item_count', JSON.stringify(item_count));
                window.location.href = "{{ route('neworder_page')}}";
                }
            });



                {{--localStorage.setItem('orderGrandTotal', JSON.stringify(total_amount));--}}

                // var totalPrice = 0;
                // var totalQty = 0;
                // localStorage.removeItem('mycart');
                // localStorage.removeItem('grandTotal');
                // $.each(unit.items,function(i,item){
                //
                //         var realPrice = item.pivot.price;
                //
                //     var item = {
                //         id: item.id,
                //         item_name: item.item_name,
                //         unit_name: item.item_name,
                //         current_qty: item.stock,
                //         order_qty: item.pivot.quantity,
                //         selling_price: item.pivot.price,
                //         each_sub: (parseInt(realPrice) * item.pivot.quantity),
                //         discount: 0,
                //     };
                //
                //     var mycart = localStorage.getItem('mycart');
                //
                //     if (mycart == null) {
                //
                //     mycart = '[]';
                //
                //     var mycartobj = JSON.parse(mycart);
                //
                //     mycartobj.push(item);
                //
                //     localStorage.setItem('mycart', JSON.stringify(mycartobj));
                //
                //     } else {
                //
                //     var mycartobj = JSON.parse(mycart);
                //
                //     mycartobj.push(item);
                //
                //     localStorage.setItem('mycart', JSON.stringify(mycartobj));
                //     }
                //
                //     totalPrice += (parseInt(realPrice) * item.pivot.quantity);
                //     totalQty +=  item.pivot.quantity;
                // })
                //     var total_amount = {
                //         sub_total: totalPrice,
                //         total_qty: totalQty,
                //         vou_discount: null
                //     };
                //     console.log("grand",total_amount);
                //
                //     var grand_total = localStorage.getItem('grandTotal');
                //
                //     localStorage.setItem('grandTotal', JSON.stringify(total_amount));
                //
                //     localStorage.setItem('editvoucher', JSON.stringify(unit.id));
                {{--    window.location.href = "{{ route('neworder_page')}}";--}}



        $('#delete').click(function(){

                var order_id = $(this).data('id');
                var status = $(this).data('status');
                console.log(order_id,status);
                if(status != 1){
                    swal({
                            title: "Failed!",
                            text: "Order ဖျက်မရပါ !",
                            icon: "error",
                        });
                }else{
                
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

                url: '/order-delete',

                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id,
                    "admin_code": result,
                },

                success: function(data) {
                    if(data==1){
                        swal({
                            title: "Success",
                            text: "Order ဖျက်ပြီးပါပြီ!",
                            icon: "info",
                        });

                        setTimeout(function() {
                            window.location.href = "{{ route('order_history')}}";
                            }, 600);
                    }else{
                        swal({
                            title: "Failed!",
                            text: "Order ဖျက်မရပါ !",
                            icon: "error",
                        });

                    }
                },


                });
                });
                }
            })
        });
    </script>
@endsection
