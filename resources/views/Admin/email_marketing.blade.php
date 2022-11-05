@extends('master')

@section('title','Email Marketing')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.item') @lang('lang.list')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<h2 class="text-center">Email Marketing</h2>
@if(session()->has('success'))<p  class="text-center text-success">{{ session('success') }}</p>@endif
<div class="w-100 d-flex justify-content-center p-4">
  <div class="w-50">
  <form method="POST" action="sendingemail" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label for="subject">Subject</label>
    <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" id="subject" placeholder="">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="title">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="">
    </div>
    <div class="form-group col-md-6">
      <label for="subtitle">Subtitle</label>
      <input type="text" name="subtitle" class="form-control" id="subtitle" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="">Description</label>
    <textarea class="form-control" name="description" rows="4" id="comment"></textarea>
  </div>
  <div class="form-group">
      <label for="link">Link</label>
      <input type="text" name="link" class="form-control" id="link" placeholder="">
    </div>
    <div class="form-row">
    <div class="form-group col-md-6">
      <label for="photo">Photo</label>
      <input type="file" name="photo" class="form-control" id="photo" placeholder="">
    </div>
    <div class="form-group col-md-6">
      <label for="attach">Attachment</label>
      <input type="file" name="attach" class="form-control" id="attach" placeholder="">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Send Mail</button>
</form>

  </div>
</div>

@endsection

@section('js')

<script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/plugins/bootstrap-select/bootstrap-select.min.js')}}"  type="text/javascript"></script>

<script type="text/javascript" src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}"></script>

<script>
    
    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $('#mdate1').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $('#mdate2').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    
    $( document ).ready(function() {
        
        $('#expense').hide();
    });
    
    function hideExpenseType(value){
        
        if(value == 1){
            
            $('#expense').hide();
        }
        
        else if(value == 2){
            
            $('#expense').show();
        }
        
        else{
            
            $('#expense').hide();
        }
    
    }
    
</script>

@endsection