@extends('master')

@section('title','Order Detail')

@section('place')
  
@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h4 class="text-themecolor" style="margin-left: 70px;">Order Details</h4>
            </div>
        </div>
        <section id="plan-features">
            <div class="container">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">

                            <ul class="nav nav-tabs" style="width: 100%;">
                                <li class="active"><a class="" data-toggle="pill" href="#instock">Instock</a></li>
                                <li><a data-toggle="pill" href="#preorder">Preorder</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="instock" class="tab-pane fade in active">
                                        <table class="table table-striped text-black">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Order Code</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Total Qty</th>
                                            <th>Total Amount</th>
                                            <th>Delivery Fee</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Payment Channel</th>
                                            <th>Delivery Address</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $j=1;
                                        ?>
                                        @foreach($instock_orders as $instock)
                                        
                                        <tr>
                                            <td>{{$j++}}</td>
                                            <td>{{$instock->customer_name}}</td>
                                            <td>{{$instock->customer_phone}}</td>
                                            <td>{{$instock->order_code}}</td>
                                            <td>{{$instock->order_date}}</td>
                                            <td>{{$instock->order_status}}</td>
                                            <td>{{$instock->total_quantity}}</td>
                                            <td>{{$instock->total_amount}}</td>
                                            <td>{{$instock->delivery_fee}}</td>
                                            <td>{{$instock->discount_amount}}</td>
                                            <td>{{$instock->payment_type}}</td>
                                            <td>{{$instock->payment_channel}}</td>
                                            <td>{{$instock->deliver_address}}</td>
                                        </tr>
            
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="preorder" class="tab-pane">
                                    <table class="table table-striped text-black">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Order Code</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Total Qty</th>
                                            <th>Total Amount</th>
                                            <th>Delivery Fee</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Payment Channel</th>
                                            <th>Delivery Address</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $j=1;
                                        ?>
                                        @foreach($preorder_orders as $pre)
                                        
                                        <tr>
                                            <td>{{$j++}}</td>
                                            <td>{{$pre->customer_name}}</td>
                                            <td>{{$pre->customer_phone}}</td>
                                            <td>{{$pre->order_code}}</td>
                                            <td>{{$pre->order_date}}</td>
                                            <td>{{$pre->order_status}}</td>
                                            <td>{{$pre->total_quantity}}</td>
                                            <td>{{$pre->total_amount}}</td>
                                            <td>{{$pre->delivery_fee}}</td>
                                            <td>{{$pre->discount_amount}}</td>
                                            <td>{{$pre->payment_type}}</td>
                                            <td>{{$pre->payment_channel}}</td>
                                            <td>{{$pre->deliver_address}}</td>
                                        </tr>
            
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endsection


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>











 

