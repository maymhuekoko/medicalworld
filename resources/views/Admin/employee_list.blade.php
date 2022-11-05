@extends('master')

@section('title','Employee List')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.employee') @lang('lang.list')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.employee') @lang('lang.list')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.employee') @lang('lang.list')</h4>
    </div>

    <div class="col-md-7 col-4 align-self-center">

        <div class="d-flex m-t-10 justify-content-end">
             <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#create_item">
                <i class="fas fa-plus"></i>                   
                @lang('lang.add_employee')
            </a>
        </div>

        <div class="modal fade" id="create_item" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('lang.employee') @lang('lang.create') @lang('lang.form')</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>

                    <div class="modal-body">
                        <form class="form-material" method="post" action="{{route('employee_store')}}" enctype='multipart/form-data'>
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label class="control-label">@lang('lang.employee') @lang('lang.name')</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.email')</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.password')</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.employee') @lang('lang.phone')</label>
                                            <input type="text" name="phone" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Shop</label>
                                            <select class="form-control select2" name="from_id" style="width: 100%" >
                                                <option value="">@lang('lang.select')</option>
                                                @foreach ($froms as $from)
                                                <option value="{{$from->id}}">{{$from->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div> 

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lang.employee') @lang('lang.role')</label>
                                            <select class="form-control select2" name="role" style="width: 100%" >
                                                <option value="">@lang('lang.select')</option>
                                                <option value="Sale_Person">Sale</option>
                                                <option value="Counter">Counter</option>
                                                <option value="Casher">Casher</option>
                                                <option value="Store_Keeper">Store Keeper</option>
                                                <option value="Delivery_Person">Delivery Person</option>                              
                                            </select>
                                        </div>
                                    </div> 


                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class=" col-md-9">
                                            <button type="submit" class="btn btn-success">@lang('lang.submit')</button>
                                            <button type="button" class="btn btn-inverse" data-dismiss="modal">@lang('lang.cancel')</button>
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
    @foreach($employee as $emp)
    <div class="col-md-6 col-lg-6 col-xlg-4">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-lg-3 text-center">
                    <a href="#">
                        <img src="{{asset('image/'. $emp->user->photo_path)}}" alt="user" class="img-circle img-responsive">
                    </a>
                </div>
                
                <div class="col-md-8 col-lg-9 m-l-3">
                    <h4 class="box-title m-b-0">{{$emp->user->name}}</h4> 
                        <span>User Code -> <span class="text-info">{{$emp->user->user_code}}</span> </span><br/>
                        <span>Role -> <span class="text-info"> {{$emp->user->role}}</span> </span><br>
                        <span>Shop -> <span class="text-info">{{$emp->user->from->name ?? null}}</span>  </span><br>


                    <address>
                        {{$emp->user->email}}
                        <br/>
                        <br/>
                        <abbr title="Phone"><i class="fas fa-2x fa-phone-square"> {{$emp->phone}}</i></abbr> 
                    </address>

                     <a href="{{route('employee_details',$emp->id)}}" class="btn btn-sm btn-outline-primary float-right">
                        <i class="fas fa-check-circle"></i>                   
                        Check Employee Details
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- /.col -->
</div>

@endsection