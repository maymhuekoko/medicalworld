@extends('master')

@section('title','Sale Panel')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.sales') @lang('lang.panel')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.sales') @lang('lang.panel')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.sales') @lang('lang.panel')</h4>
    </div>
</div>



<div class="row">    
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('sale_page')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-transaction-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.sale')</h4>
	            		
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('sale_history')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-total-sales-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.sale_history')</h4>
	            	
	            </div>
	        </div>               
        </a>        
    </div>
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('voucher_summary_main')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-order-history-100.png')}}">
                    </div>
                    <h4 class="text-center text-dark font-weight-bold mt-3">Voucher Summary</h4>
                </div>
            </div>
          </a>
    </div>
    <div class="col-lg-5 col-md-5">
        <a href="{{route('voucher_summary_main')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-order-history-100.png')}}">
                    </div>
                    <h4 class="text-center text-dark font-weight-bold mt-3">Sale Customer Lists</h4>
                </div>
            </div>
          </a>
    </div>
    
    
</div>

@endsection