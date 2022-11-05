@extends('master')

@section('title','Order Page')

@section('place')
  
@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h4 class="text-themecolor m-b-0 m-t-0">Order Customer Lists</h4>
               
            </div>
            
            <a href="{{route('collect_ordercustomer_data')}}" class="btn btn-outline-info">
                                                        Run</a>
        </div>
        <section id="plan-features">
            <div class="container">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                            <table class="table table-striped text-black">
                                <thead>
                                <tr>
                                <th>No</th>
                                    
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Purchase Amount</th>
                                    <th>Purchase Quantity</th>
                                    <th>Purchase Times</th>
                                    <th>Last Purchase Date</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $j=1;
                                ?>
                                @foreach($order_customer as $list)
                                
                                <tr>
                                <td>{{$j++}}</td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->phone}}</td>
                                <td>{{$list->total_purchase_amount}}</td>
                                <td>{{$list->total_purchase_quantity}}</td>
                                <td>{{$list->total_purchase_times}}</td>
                                <td>{{$list->last_purchase_date ?? '-'}}</td>
                                

                                </tr>
       
                                @endforeach
                                </tbody>
                            </table>
                            @endsection


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>











 

