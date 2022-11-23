@extends('master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>


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

                            <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 100%;">
                                <li class="nav-item" role="presentation" style="width: 50%;">
                                    <button class="nav-link active" style="width: 100%;" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Instock</button>
                                </li>
                                <li class="nav-item" role="presentation" style="width: 50%;">
                                    <button class="nav-link" style="width: 100%;" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Preorder</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <table class="table table-striped text-black">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Order Code</th>
                                            <th>Order Status</th>
                                            <th>Total Qty</th>
                                            <th>Total Amount</th>
                                            <th>Delivery Fee</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Payment Channel</th>
                                            <th>Delivery Address</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $j=1;
                                        ?>
                                        @foreach($instock_orders as $instock)
                                        
                                        <tr>
                                            <td>{{$j++}}</td>
                                            <td>{{$instock->order_code}}</td>
                                            <td>{{$instock->order_status}}</td>
                                            <td>{{$instock->total_quantity}}</td>
                                            <td>{{$instock->total_amount}}</td>
                                            <td>{{$instock->delivery_fee}}</td>
                                            <td>{{$instock->discount_amount}}</td>
                                            <td>{{$instock->payment_type}}</td>
                                            <td>{{$instock->payment_channel}}</td>
                                            <td>{{$instock->deliver_address}}</td>
                                            <td><a href="{{route('item_detail', [$instock->id])}}" class="btn btn-primary">Detail</a></td>
                                        </tr>
            
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <table class="table table-striped text-black">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Order Code</th>
                                            <th>Order Status</th>
                                            <th>Total Qty</th>
                                            <th>Total Amount</th>
                                            <th>Delivery Fee</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Payment Channel</th>
                                            <th>Delivery Address</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $j=1;
                                        ?>
                                        @foreach($preorder_orders as $pre)
                                        
                                        <tr>
                                            <td>{{$j++}}</td>
                                            <td>{{$pre->order_code}}</td>
                                            <td>{{$pre->order_status}}</td>
                                            <td>{{$pre->total_quantity}}</td>
                                            <td>{{$pre->total_amount}}</td>
                                            <td>{{$pre->delivery_fee}}</td>
                                            <td>{{$pre->discount_amount}}</td>
                                            <td>{{$pre->payment_type}}</td>
                                            <td>{{$pre->payment_channel}}</td>
                                            <td>{{$pre->deliver_address}}</td>
                                            <td><a href="{{route('item_detail', [$pre->id])}}" class="btn btn-primary">Detail</a></td>
                                        </tr>
            
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
@endsection











 

