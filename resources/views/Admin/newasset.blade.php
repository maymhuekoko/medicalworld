@extends('master')

@section('title','New Asset')

@section('place')
{{-- 
<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">New Asset</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">Create New Asset</h4>
    </div>
</div>


<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-body">
                <form class="form-material m-t-40" method="post" action="{{route('deliveryorderreceive.store')}}" id="delivery_receive_store">
                    @csrf
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2"> @lang('lang.name')</label>
                        <input type="text" name="name" class="form-control col-md-6 @error('name') is-invalid @enderror">

                        @error('name')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2"> @lang('lang.description')</label>
                        <input type="text" name="description" class="form-control col-md-6 @error('description') is-invalid @enderror">

                        @error('description')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">@lang('lang.type')</label>
                        <select class="form-control col-md-6" name="type" >
                            <option value="1">Home</option>
                            <option value="2">Vehicle</option>
                            <option value="3">Mechine</option>
                        </select>

                        @error('type')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Purchase Initial Price</label>
                        <input type="text" name="initial_price" class="form-control col-md-6 @error('initial_price') is-invalid @enderror">

                        @error('initial_price')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Salvage Value</label>
                        <input type="text" name="salvagevalue" class="form-control col-md-6 @error('salvagevalue') is-invalid @enderror">

                        @error('salvagevalue')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Used Life (Year)</label>
                        <input type="text" name="usedlifeyear" class="form-control col-md-6 @error('usedlifeyear') is-invalid @enderror">

                        @error('usedlifeyear')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Year Description</label>
                        <input type="text" name="yeardescription" class="form-control col-md-6 @error('yeardescription') is-invalid @enderror">

                        @error('yeardescription')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Existing Asset</label>
                        <div class="col-md-6 row">
                            <div class="form-check col-md-3">
                                <input class="form-check-input" type="radio" name="exitasset" id="exitassetYes" value="0" checked>
                                <label class="form-check-label" for="exitassetYes">
                                Yes 
                                </label>
                            </div>
                            <div class="form-check col-md-3">
                                <input class="form-check-input" type="radio" name="exitasset" id="exitassetNo" value="1">
                                <label class="form-check-label" for="exitassetNo">
                                No
                                </label>
                            </div>
                        </div>

                        @error('exitasset')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Used Year</label>
                        <input type="number" name="usedyear" class="form-control col-md-6 @error('usedyear') is-invalid @enderror">

                        @error('usedyear')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Depreciation Total</label>
                        <input type="number" name="depreciation_total" class="form-control col-md-6 @error('depreciation_total') is-invalid @enderror">

                        @error('depreciation_total')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Current Value</label>
                        <input type="number" name="current_value" class="form-control col-md-6 @error('current_value') is-invalid @enderror">

                        @error('current_value')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Start Date</label>
                        <input type="number" name="start_date" class="form-control col-md-6 @error('start_date') is-invalid @enderror">

                        @error('start_date')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-4 offset-md-5 offset-sm-4">
                        <input type="submit" name="btnsubmit"  class="btnsubmit  btn btn-danger" value="Cancle">
                        <input type="submit" name="btnsubmit" class="btnsubmit btn btn-primary" value="Submit">
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')

<script type="text/javascript">

</script>

@endsection