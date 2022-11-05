@extends('master')

@section('title','Admin Panel')

@section('place')
{{-- 
<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.admin') @lang('lang.panel')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.admin') @lang('lang.panel')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.admin') @lang('lang.panel')</h4>
    </div>
</div>



<div class="row justify-content-center">    
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('employee_list')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-user-group-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.employee')</h4>
	            		
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('customer_list')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-user-account-100.png')}}">
	            	</div>	                
	                	

	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.customer')</h4>
	            	
	            </div>
	        </div>               
        </a>        
    </div>
</div>

<div class="row justify-content-center">    
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('expenses')}}">
            <div class="card card-success">
	            <div class="card-body">
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/icons8-user-group-100.png')}}">
	            	</div>	                
	                <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.expenses')</h4>
	            </div>
	        </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
  
    </div>
</div>

@endsection