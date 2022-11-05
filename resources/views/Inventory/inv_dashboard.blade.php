@extends('master')

@section('title','Inventory Dashboard')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.inventory_dashboard')</li>
    </ol>
</div> --}}

@endsection


@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.inventory_dashboard')</h4>
    </div>
</div>


<div class="row justify-content-center">    
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('category_list')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/92801377_877091472805605_68878940281765888_n.png')}}">
                    </div>                  
                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.category')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>
    
    <div class="col-lg-5 col-md-5">
        <a href="{{route('subcategory_list')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/92801377_877091472805605_68878940281765888_n.png')}}">
                    </div>                  
                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.subcategory')</h4>
                </div>
            </div>               
        </a>        
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-5 col-md-5">
        <a href="{{route('item_list')}}">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="{{asset('image/93544808_221607162457745_5859617280568066048_n.png')}}">
                    </div>                  
                    <h4 class="text-center text-dark font-weight-bold mt-3">@lang('lang.item')</h4>
                    
                </div>
            </div>               
        </a>        
    </div>
    <div class="col-lg-5 col-md-5"></div>
</div>

@endsection