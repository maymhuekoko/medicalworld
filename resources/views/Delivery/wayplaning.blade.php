@extends('master')

@section('title','Way Planning Form')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Way Planning Form</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Way Planning Form</li>
    </ol>
</div> --}}

@endsection

@section('content')
<section id="plan-features">
 
    <div class="row ml-4 mt-3">
        <form action="{{route('search_sale_history')}}" method="POST" class="form">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label class="control-label font-weight-bold">Way No</label>
                    <input type="text" name="from" class="form-control" required>
                </div>
                
                <div class="col-md-3">
                    <label class="font-weight-bold">Delivery Person</label>
                    <select class="form-control" name="category" required>
                        <option value="1">@lang('lang.select')</option>
                        <option value="2">Delivery One</option>
                        <option value="3">Delivery One</option>
                        <option value="4">Delivery One</option>
                        <option value="5">Delivery One</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Township</label>
                    <select class="form-control" name="category" required>
                        <option value="1">@lang('lang.select')</option>
                        <option value="2">Township One</option>
                        <option value="3">Township One</option>
                        <option value="4">Township One</option>
                        <option value="5">Township One</option>
                    </select>
                </div>


            </div>
        </form>

    </div>

    <br/>

    <div class="container">
        <div class="card">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive text-black" id="slimtest2">
                            <table class="table" id="item_table">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold text-themecolor">#</th>
                                        <th class="font-weight-bold text-themecolor">@lang('lang.voucher') @lang('lang.number')</th>
                                        <th class="font-weight-bold text-themecolor">@lang('lang.customer') @lang('lang.name')</th>
                                        <th class="font-weight-bold text-themecolor">@lang('lang.customer') @lang('lang.phone')</th>
                                        <th class="font-weight-bold text-themecolor">Pickup/Delivery @lang('lang.details')</th>
                                        <th class="font-weight-bold text-themecolor">Packge @lang('lang.details')</th>
                                        <th class="font-weight-bold text-themecolor">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="item_list">
                                    @php
                                        $j=1;
                                    @endphp
                                    @foreach ($deliverorder as $do)
                                        <tr>
                                            <td class="ddd">
                                                <div class="form-check">
                                                    <input class="form-check-input" data-id="3" type="checkbox" name="deliverycheck" value="{{$do->id}}" id="check{{$j}}" >
                                                    <label class="form-check-label" for="check{{$j}}">
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="font-weight-bold">{{$j++}}</td>
                                            <td class="font-weight-bold">null</td>
                                            <td class="font-weight-bold">{{$do->customer_name}}</td>
                                            <td class="font-weight-bold">
                                                {{$do->customer_phone}}
                                            </td>
                                            <td class="font-weight-bold">
                                                <a href="" class="btn btn-primary" style="color: white;">Show</a>
                                            </td>
                                            <td class="font-weight-bold">
                                                <a href="" class="btn btn-primary" style="color: white;">Show</a>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="" class="btn btn-primary" style="color: white;"><i class="fas fa-plus"></i> Add</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                     
                                
                                </tbody>
                            </table>
                                    <button type="button"  class="btn btn-success ml-5" onclick="add_delivery_order()">@lang('lang.submit')</button>
                                    <button type="button" class="btn btn-inverse ml-2" data-dismiss="modal">@lang('lang.cancel')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')

<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>

<script type="text/javascript">

	$('#item_table').DataTable( {

            "paging":   false,
            "ordering": true,
            "info":     false

    });
        
    $('#slimtest2').slimScroll({
        color: '#00f',
        height: '600px'
    });
    function add_delivery_order(){
        console.log("pk");
        console.log($('.form-check .form-check-input').data('id'));

    };
	
</script>

@endsection