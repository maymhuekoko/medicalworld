@extends('master')

@section('title','Change Password')

@section('content')
{{-- 
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Change Password</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Back to Dashborad</a></li>
            <li class="breadcrumb-item active">Change Password</li>
        </ol>
    </div>
</div> --}}

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">Change Password</h4>
    </div>
</div>

<div class="row">

    <div class="card">
        <div class="card-body">
            <form action="{{route('update_pw')}}" method="post">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Old password</label>
                        <input type="password" class="form-control" name="current_pw">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>New password</label>
                        <input type="password" class="form-control @error('new_pw') is-invalid @enderror" name="new_pw">

                        @error('new_pw')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" class="form-control" name="new_pw_confirmation">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center m-t-20">
                    <button type="submit" class="btn btn-primary submit-btn">Update Password</button>
                </div>
            </div>
        </form>

        </div>
    </div>
</div>


@endsection