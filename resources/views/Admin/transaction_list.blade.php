@extends('master')

@section('title','Transaction Page')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h4 class="text-themecolor m-b-0 m-t-0">@lang('lang.sale_history')</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.sale_history')</li>
    </ol>
</div>

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
                        
                        <a href="{{route('order_details',$orders->id)}}" type="button" class="btn btn-sm btn-info w-30">Order Details</a>
                         
                    </div> 
                    
                </div>
            </div>
    </div>
    <div class="col-md-12 mt-3 offset-md-2">
        <input type="hidden" id="total_charges" value="{{$orders->est_price}}">
        <input type="hidden" id="prepaid" value="{{$orders->advance_pay}}">
        <input type="hidden" id="collect" value="{{$orders->collect_amount}}">
         <input type="hidden" id="discount" value="{{$orders->total_discount_value}}">
    <div class="row">
        <div class="col-md-6">
            <div class="badge badge-primary p-4" style="width:750px;border-radius:10px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                            <span class="font-weight-bold" style="font-size:14px;">Advance Payment</span> = <span style="font-size:13px;">{{$orders->advance_pay}}</span>
                            </div>
                            <div class="col-md-4">
                            <span class="font-weight-bold" style="font-size:14px;">Last Payment Date</span> = <span style="font-size:13px;">{{$orders->last_payment_date}}</span>
                            </div>
                            <div class="col-md-4">
                            <span class="font-weight-bold" style="font-size:14px;">Collect Amount</span> = <span style="font-size:13px;">{{$orders->collect_amount}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3" style="padding-left: 150px;">
        
            <button class="btn btn-info rounded" data-toggle="modal" data-target="#paid_vou">Pay</button>
            <!-- Begin Paid Modal -->
            <div class="modal fade"  id="paid_vou" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="border-radius:25px;" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title font-weight-bold text-white" id="exampleModalLabel">Pay Information</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('store_transaction')}}" method="post">
                        @csrf
                        <input type="hidden" name="ord_id" value="{{$orders->id}}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 ml-3">
                            <label class="font-weight-bold">Pay Date</label></br>
                            <input type="date" style="border-radius: 25px;width: 200px;height: 35px;" class="from-control border border-success pl-3" name="pay_date" id="pay_date">
                            </div>
                            <!--<div class="col-md-4">-->
                            <!--<label class="font-weight-bold">Pay Time</label></br>-->
                            <!--<input type="time" style="border-radius: 25px;width: 200px;height: 35px;" class="from-control border border-success pl-3" name="pay_time" >-->
                            <!--</div>-->
                        </div><hr>
                        <div class="from-group">
                            <label class="font-weight-bold">Pay Amount</label>
                            <input type="number" class="form-control border border-info" name="pay_amt" onkeyup="collect_cal(this.value)">
                        </div>
                        <div class="from-group">
                            <label class="font-weight-bold">Remark</label>
                            <textarea  cols="3" class="form-control border border-info" name="remark"></textarea>
                        </div>
                        <div class="from-group">
                            <label class="font-weight-bold">Bank Account</label>
                            <select  class="form-control border border-info" name="bank_info">
                                <option>Choose Bank Account</option>
                                @foreach($bank as $acc)
                                <option value="{{$acc->id}}">{{$acc->bank_name}}-{{$acc->account_number}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="from-group">
                            <label class="font-weight-bold">Collect Amount</label>
                            <input type="number" id="result" class="form-control border border-info" name="collect_amt" readonly>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Pay</button>
                    </div>
                    </div>
                    </form>
                </div>
            </div>

            <!-- End Paid Modal -->
        </div>
    </div>
    
    </div>
    <div class="card mt-1">
        <div class="card-body">
            <h3>Transaction List</h3>
            <!-- Begin Table -->
                <div class="table-responsive text-black">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Transaction Date</th>
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
                            <td><a href="" class="btn btn-danger">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <!-- End table -->
        </div>
    </div>

@endsection
@section('js')
<script>
function collect_cal(value)
{
    var tot = parseInt($('#total_charges').val());
    var prepaid = parseInt($('#prepaid').val());
    var discount = parseInt($('#discount').val());
    prepaid += parseInt(value);
    console.log(prepaid);
    tot = tot - (parseInt(prepaid) + discount) ;
    var result = tot;
    $('#result').val(tot);
}
</script>
@endsection