@extends('master')

@section('title','Stock Panel')

@section('place')
{{-- 
<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.stock') @lang('lang.panel')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.stock') @lang('lang.panel')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-black">@lang('lang.stock') @lang('lang.panel')</h4>
    </div>
</div>



<div class="row">    
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('stock_count')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-scan-stock-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.stock_count')</h4>
	            		
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('stock_price_page')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-purchase-order-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.stock') @lang('lang.price')</h4>
	            	
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('stock_reorder_page')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-edit-property-100.png')}}">
                    </div>                  
                        

                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.reorder_item')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>
</div>

@endsection