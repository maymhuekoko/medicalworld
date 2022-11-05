@extends('master')

@section('title','Customer List')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.customer') @lang('lang.list')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.customer') @lang('lang.list')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.customer') @lang('lang.list')</h4>
    </div>

    <div class="col-md-7 col-4 align-self-center">

        <div class="d-flex m-t-10 justify-content-end">
            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#create_item">
                <i class="fas fa-plus"></i>                   
                @lang('lang.add_customer')
            </a>
        </div>

        <div class="modal fade" id="create_item" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('lang.customer') @lang('lang.create') @lang('lang.form')</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>

                    <div class="modal-body">
                        <form class="form-material" method="post" action="{{route('store_customer')}}" enctype='multipart/form-data'>
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label class="control-label">@lang('lang.customer') @lang('lang.name')</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.email')</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.password')</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.customer') @lang('lang.phone')</label>
                                            <input type="text" name="phone" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">@lang('lang.customer') @lang('lang.level')</label>
                                        <select class="form-control" name="level">
                                            <option value="">@lang('lang.select')</option>
                                            <option value="1">Level One</option>
                                            <option value="2">Level Two</option>
                                            <option value="3">Level Three</option>                              
                                        </select>
                                    </div>

                                    <div class="col-md-4 mt-2">
                                        <label class="control-label">@lang('lang.allow_credit')</label>
                                        <div class="switch">
                                            <label>@lang('lang.off')
                                                <input type="checkbox" name="allow_credit"><span class="lever"></span>@lang('lang.on')</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.customer') @lang('lang.address')</label>
                                            <textarea name="address" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class=" col-md-9">
                                            <button type="submit" class="btn btn-success">@lang('lang.submit')</button>
                                            <button type="button" class="btn btn-inverse">@lang('lang.cancel')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>           
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row">
    <!-- .col -->
    @foreach($customer_lists as $customer)
    <div class="col-md-6 col-lg-6 col-xlg-4">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-lg-3 text-center">
                    <a href="#">
                        <img src="{{asset('photo/Customer/'. $customer->user->photo_path)}}" alt="user" class="img-circle img-responsive">
                    </a>
                </div>
                <div class="col-md-8 col-lg-9 m-l-3">
                    <h3 class="box-title m-b-0">{{$customer->user->name}}</h3> 
                        <small>User Code -> {{$customer->user->user_code}}</small><br/>
                        <small>Role -> {{$customer->user->role}} </small><br/>

                        @if($customer->allow_credit == 0)
                        <span class="badge-pill badge-danger">No Credit Allow</span>
                        @else
                        <span class="badge-pill badge-success">Credit Allow</span>
                        @endif

                        @if($customer->customer_level == 1)
                        <span class="badge-pill badge-success">Level One</span>
                        @elseif($customer->customer_level == 2)
                        <span class="badge-pill badge-info">Level Two</span>
                        @else
                        <span class="badge-pill badge-danger">Level Three</span>
                        @endif

                    <address>
                        {{$customer->user->email}}
                        <br/>
                        <br/>
                        <abbr title="Phone"><i class="fas fa-2x fa-phone-square"> {{$customer->phone}}</i></abbr> 
                    </address>

                     <a href="#" class="btn btn-sm btn-outline-info float-right ml-2" data-toggle="modal" data-target="#change_lvl_{{$customer->id}}">
                        <i class="fas fa-exchange-alt"></i>                   
                        Change Customer Level
                    </a>

                    <div class="modal fade" id="change_lvl_{{$customer->id}}" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Change Customer Level</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                </div>

                                <div class="modal-body">
                                    <form class="form-horizontal" method="post" action="{{route('change_customer_level')}}" enctype='multipart/form-data'>
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{$customer->id}}">

                                    
                                        <div class="form-body">

                                            <div class="form-group row">
                                                <label class="control-label col-md-6">Customer Level</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" name="level">
                                                        <option value="1" @if($customer->customer_level == 1) selected='selected' @endif>Level One</option>
                                                        <option value="2" @if($customer->customer_level == 2) selected='selected' @endif>Level Two</option>
                                                        <option value="3" @if($customer->customer_level == 3) selected='selected' @endif>Level Three</option>                              
                                                    </select>                                                
                                                </div>
                                            </div>

                                            <div class="form-actions mt-2">
                                                <div class="row">
                                                    <div class=" col-md-9">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                        <button type="button" class="btn btn-inverse">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>           
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{route('customer_details',$customer->id)}}" class="btn btn-sm btn-outline-primary float-right">
                        <i class="fas fa-check-circle"></i>                   
                        Check Customer Details
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- /.col -->
</div>

@endsection