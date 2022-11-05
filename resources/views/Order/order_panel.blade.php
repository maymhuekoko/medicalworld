@extends('master')

@section('title','Order Panel')

@section('place')


{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.order') @lang('lang.panel')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.order') @lang('lang.panel')</li>
    </ol>
</div> --}}
     

@endsection

@section('content')
    

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.order') @lang('lang.panel')</h4>
    </div>
</div>



<div class="row">    
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('order_page','1')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-list-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.incoming_order')</h4>
	            		
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('order_page','2')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-check-file-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.confirm_order')</h4>
	            	
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('order_page','3')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-edit-property-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.changes_order')</h4>
	            	
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('order_page','4')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-purchase-order-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.delivered_order')</h4>
	            	
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('order_history')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-order-history-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.order_voucher_history')</h4>
	            	
	            </div>
	        </div>               
        </a>        
    </div>
</div>

@endsection