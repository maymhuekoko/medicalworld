@extends('master')

@section('title','Order Details')

@section('place')
{{-- 
<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.order') @lang('lang.details')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.order') @lang('lang.details')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.order') @lang('lang.details') @lang('lang.page')</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="font-weight-bold mt-2">@lang('lang.order') @lang('lang.details')</h4>
            </div>
            <div class="card-body">
            	@if($order->status == 1)
            	<h4 class="font-weight-bold mt-2 text-center">
            		<span class="badge badge-info font-weight-bold">@lang('lang.incoming_order')</span>
            	</h4>
            	@elseif($order->status == 2)
            	<h4 class="font-weight-bold mt-2 text-center">
            		<span class="badge badge-info font-weight-bold">@lang('lang.confirm_order')</span>
            	</h4>
            	@elseif($order->status == 3)
            	<h4 class="font-weight-bold mt-2 text-center">
            		<span class="badge badge-info font-weight-bold">@lang('lang.changes_order')</span>
            	</h4>
            	@elseif($order->status == 4)
            	<h4 class="font-weight-bold mt-2 text-center">
            		<span class="badge badge-info font-weight-bold">@lang('lang.delivered_order')</span>
            	</h4>	
            	@elseif($order->status == 5)
            	<h4 class="font-weight-bold mt-2 text-center">
            		<span class="badge badge-info font-weight-bold">@lang('lang.accepted_order')</span>
            	</h4>
            	@endif


            	<div class="row">
            		<div class="col-md-6">

            			<div class="row">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.order') @lang('lang.number')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$order->order_number}}</h5>
				        </div> 

            			<div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.order') @lang('lang.date')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{date('d-m-Y', strtotime($order->order_date))}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.order') @lang('lang.address')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$order->address}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.order') @lang('lang.total') @lang('lang.quantity')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$order->total_quantity}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.order_est_price')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$order->est_price}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.customer') @lang('lang.name')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$order->name}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.customer') @lang('lang.level')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">@lang('lang.level') - 1</h5>
				        </div>

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.customer') @lang('lang.phone')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$order->phone}}</h5>
				        </div>

				        @if($order->status == 5)
				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4" style="overflow:hidden;white-space: nowrap;">@lang('lang.accepted_date')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{date('d-m-Y h:i A' , strtotime($order->accepted_date))}}
			              	</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-4">@lang('lang.customer') @lang('lang.remark')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$order->remark}}</h5>
				        </div>                   
            			@endif
            		</div>

            		<div class="col-md-6">
            			<h4 class="font-weight-bold mt-2 text-primary text-center"></h4>@lang('lang.order') @lang('lang.unit') @lang('lang.list')
            			<div class="table-responsive text-black">
		                    <table class="table" id="example23">
		                        <thead>
		                            <tr>
		                                <th>@lang('lang.item') @lang('lang.name')</th>
		                                <th>@lang('lang.counting_unit') @lang('lang.name')</th>
		                                <th>@lang('lang.order') @lang('lang.quantity')</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            @foreach($order->counting_unit as $unit)
		                                <tr>
		                                	<td>{{$unit->item->item_name}}</td>
		                                	<td>{{$unit->unit_name}}</td>
		                                	<td>{{$unit->pivot->quantity}}</td>			                                   
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

@endsection