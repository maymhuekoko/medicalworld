@extends('master')

@section('title','Stock Panel')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.stock') @lang('lang.panel')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.stock') @lang('lang.panel')</li>
    </ol>
</div> --}}

@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="font-weight-normal">@lang('lang.stock') @lang('lang.panel')</h4>
    </div>
</div>



<div class="row">

    <div class="col-lg-5 col-md-5">
        <a href="{{route('admin_sale_page', $from->id)}}">
            <div class="card card-success">
	            <div class="card-body" style="position: relative">
                    <button style="position: absolute;" type="button" class="btn btn-warning editshopname" data-id="{{$from->id}}" data-name="{{$from->name}}">Edit</button>
	            	<div class="row justify-content-center">
	            		<img src="{{asset('image/new_shop.png')}}">
	            	</div>
	                <h4 class="text-center text-dark font-weight-bold mt-3">{{$from->name}}</h4>

	            </div>
	        </div>
        </a>
    </div>


    <div class="modal fade" id="editshopnameModal" tabindex="-1" role="dialog" aria-labelledby="editshopnameModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editshopnameModalLabel">Edit Shop Name</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('shopnameEdit')}}">
                  @csrf
                  <input type="hidden" name="shopID" id="shopID">
                <div class="form-group">
                  <label for="shopname" class="col-form-label">Name:</label>
                  <input type="text" class="form-control" name="shopname" id="shopname">
                </div>
                <button type="submit" class="btn btn-info float-right">Send message</button>
              </form>
            </div>
          </div>
        </div>
      </div>



</div>

@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('.scroll-sidebar').hide();
        })
        $('.editshopname').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#shopID').val(id);
            $('#shopname').val(name);
            $('#editshopnameModal').modal('show');
        })
    </script>
@endsection
