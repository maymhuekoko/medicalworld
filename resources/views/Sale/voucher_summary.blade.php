@extends('master')

@section('title','Voucher Summary')

@section('content')

<style>
    td{
        text-align:left;
        font-size:17px;
        font-weight:bold; 
    }
    th{
        text-align:left;
        font-size:15px;
        overflow:hidden;
        white-space: nowrap;
    }
    h6{
        font-size:17px;
        font-weight:600;
    }
</style>

<div class="page-wrapper">
    <div class="container-fluid">
        {{-- <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Voucher Summary</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Main Dashboard</a></li>
                    <li class="breadcrumb-item active">Voucher Summary</li>
                </ol>
            </div>
        </div> --}}
        <div class="row justify-content-center">
            <div class="col-md-8 printableArea" style="width:49%;">
                <div class="card">
                    <div class="card-header">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5 class="text-themecolor font-weight-bold">Total Sales - {{$total_sales}} MMK</h5>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-themecolor font-weight-bold">Total Quantity - {{$total_quantity}}</h5>
                                <h5 class="text-themecolor font-weight-bold">Date &nbsp; {{$date}}</h5>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="table-responsive text-black" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold text-themecolor">Item Name</th>
                                        <th class="font-weight-bold text-themecolor">Unit Name</th>
                                        <th class="font-weight-bold text-themecolor">Quantity</th>
                                        <th class="font-weight-bold text-themecolor">Price Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topTens as $topTen)
                                    dd($topTen)
                                        <tr>
                                            <td>
                                                {{$topTen['item_name']}}
                                            </td>
                                            <td>{{$topTen['counting_unit_name']}}</td>
                                            <td>{{$topTen['quantity']}}</td>
                                            <td>{{$topTen['price']}}</td>
                                            
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button id="print" class="btn btn-info" type="button"> <span><i class="fa fa-print"></i> Print Slip</span> </button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('master/js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script type="text/javascript">

    $("#print").click(function() {

            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);

           
    });

</script>

@endsection