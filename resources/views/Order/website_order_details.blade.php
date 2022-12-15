@extends('master')

@section('title', 'Website Order Details')

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


    <div class="row justify-content-center pl-4 mt-5"  style="font-weight: 500">
            <div class="col-md-8 text-left font14">
                <div class="row mb-2">
                    <div class="col-md-6">
                            Customer Name :
                         {{$orders->customer_name}}
                    </div>
                    <div class="col-md-6">
                            Total  :
                        {{$orders->total_amount}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Customer Phone : {{$orders->phone}}

                    </div>
                    <div class="col-md-6">
                        Prepaid amount : {{$orders->advance}}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Customer Address : {{$orders->deliver_address}}

                    </div>
                    <div class="col-md-6">
                        Discount : {{$orders->discount_amount}}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Order Date : {{$orders->order_date}}

                    </div>
                    <div class="col-md-6">
                        Payment Type :{{$orders->payment_type}}
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        Order No : {{$orders->order_code}}
                    </div>
                    <div class="col-md-6">
                        Order Status : <span class="badge badge-info font-weight-bold">
                        <!--@if ($orders->status==1)-->
                        <!--    Incoming-->
                        <!--    @elseif($orders->status==2)-->
                        <!--    Confirmed-->
                        <!--    @elseif($orders->status==3)-->
                        <!--    Changed Order-->
                        <!--    @elseif($orders->status==4)-->
                        <!--    Delivered-->
                        <!--    @elseif($orders->status==5)-->
                        <!--    Canceled-->
                        <!--    @else-->
                        <!--    Prepaid Partial-->
                        <!--@endif-->
                            Incoming
                        </span>
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
                            @if (!empty($customAttachOrders))
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr class="text-black">
                                        <th>No.</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Description</th>

                                    </tr>
                                </thead>
                                <tbody class="text-black">

                                    @php
                                        $k=1;
                                    @endphp

                                    @foreach($customAttachOrders as $attach)
                                    <tr>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$k++}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;"><img src="{{asset('preorder/'.$attach->item_photo)}}" width="100px" height="auto"></td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$attach->quantity}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$attach->price}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$attach->description}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            @else
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
                                    @foreach($counting as $unit)
                                    @if($unit->id == $customUnitOrder->counting_unit_id)
                                    <tr>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$j++}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$unit->unit_name}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$customUnitOrder->quantity}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$unit->order_price}}</td>
                                        <td class="font-weight-normal" style="font-size:15px;">{{$customUnitOrder->quantity * $unit->order_price}}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#spec{{$customUnitOrder->id}}">Spec
                                            </a>
                                        </td>


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


                        <div class="mb-2">
                            <h3 class="font-bold">Design</h3>
                            <ul class="list-group">
                                    @foreach(\App\Design::where("id",$unit->design_id)->get() as $d)
                                        <li class="list-group-item"> {{ucfirst($d->design_name)}}</li>
                                    @endforeach
                                <!--<li class="list-group-item">{{$unit->design_id}} // updated_this_line_with_above_@foreach_code </li>-->
                            </ul>
                        </div>


                            <div class="mb-2">
                                <h3 class="font-bold">Fabric</h3>
                                <ul class="list-group">
                                    @foreach(\App\Fabric::where("id",$unit->fabric_id)->get() as $f)
                                        <li class="list-group-item"> {{ucfirst($f->fabric_name)}}</li>
                                    @endforeach
                                    <!--<li class="list-group-item"> {{$unit->fabric_id}}</li>-->
                                </ul>
                            </div>

                            <div class="mb-2">
                                <h3 class="font-bold">Colour</h3>
                                <ul class="list-group">
                                    @foreach(\App\Colour::where("id",$unit->colour_id)->get() as $c)
                                        <li class="list-group-item"> {{ucfirst($c->colour_name)}}</li>
                                    @endforeach
                                    <!--<li class="list-group-item">{{$unit->colour_id}} </li>-->
                                </ul>
                            </div>

                            <div class="mb-2">
                                <h3 class="font-bold">Size</h3>
                                <ul class="list-group">
                                    @foreach(\App\Size::where("id",$unit->size_id)->get() as $s)
                                        <li class="list-group-item"> {{ucfirst($s->size_name)}}</li>
                                    @endforeach
                                    <!--<li class="list-group-item">{{$unit->size_id}}</li>-->
                                </ul>
                            </div>

                            <div class="mb-2">
                                <h3 class="font-bold">Gender</h3>
                                <ul class="list-group">
                                    @foreach(\App\Gender::where("id",$unit->gender_id)->get() as $g)
                                        <li class="list-group-item"> {{ucfirst($g->gender_name)}}</li>
                                    @endforeach
                                    <!--<li class="list-group-item">{{$unit->gender_id}}</li>-->

                                </ul>
                            </div>

                </div>

            </div>
        </div>
    </div>


                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
</table>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end navpil -1 -->
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

        // Print
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

        // Edit
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

    </script>
@endsection
