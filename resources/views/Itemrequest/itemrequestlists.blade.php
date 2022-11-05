@extends('master')

@section('title','Item Request')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('itemrequest') @lang('lang.list')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('itemrequest') @lang('lang.list')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">Item request lists</h4>
    </div>

    @if(session()->get('user')->role == "Counter")
    <div class="col-md-7 col-4 align-self-center">
        <div class="d-flex m-t-10 justify-content-end">
            <a href="{{route('create_itemrequest')}}" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i>                   
                 Item Request
            </a>
        </div>
    </div>  
    @endif
   
</div>

<div class="row justify-content-center">
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive text-black">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Due @lang('lang.date')</th>
                            <th>@lang('lang.total') @lang('lang.quantity')</th>
                            <th>Request By</th>
                            <th>From</th>
                            <th>
                                status
                            </th>
                            <th class="text-center">@lang('lang.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;?>
                        @foreach($request_lists as $list)
                            <tr>
                                <th>{{$i++}}</th>
                                <th>{{date('d-m-Y', strtotime($list->date))}}</th>
                                <th>{{$list->total_quantity}}</th>
                                <th>{{$list->user->name}}</th>
                                <th>{{$list->from->name}}</th>
                                <th>
                                    @if ($list->status)
                                    <span class="badge badge-success">Send</span>
                                    @else
                                    <span class="badge badge-danger">pending</span>
                                    
                                    @endif

                                </th>
                                <th class="text-center">
                                    <a href="{{route('request_details',$list->id)}}" class="btn btn-outline-primary">
                                        <i class="fas fa-check"></i>                   
                                        Check Details
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection