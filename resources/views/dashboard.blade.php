@extends('master')

@section('title','Dashboard')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h4 class="text-themecolor m-b-0 m-t-0">@lang('lang.dashboard')</h4>
</div>

@endsection

@section('content')

<div class="row">    
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('inven_dashboard')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-warehouse-100.png')}}">
                    </div>                  
                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.inventory')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('stock_dashboard')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-sell-stock-100.png')}}">
                    </div>                  
                        

                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.stock')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('sale_panel')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-payment-history-100.png')}}">
                    </div>                  
                        

                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.sale')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('order_panel')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-list-100.png')}}">
                    </div>                  
                        

                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.order')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>

    <div class="col-lg-5 col-md-5">
        <a href="{{route('admin_dashboard')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/icons8-admin-settings-male-100.png')}}">
                    </div>                  
                        

                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.admin')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>
</div>

@endsection