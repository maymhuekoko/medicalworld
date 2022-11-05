@extends('master')

@section('title','Fixed Asset List')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Fixed Asset Lists</li>
    </ol>
</div> --}}

@endsection

@section('content')
@php
$from = session()->get('from');
@endphp
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="font-weight-normal">Fixed Asset Lists</h4>
    </div>
</div>


<div class="row">
    <div class="col-2 offset-md-9 mb-2">
        <button type="button" class="btn btn-primary">@lang('lang.assign_item')</button>
    </div>
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="font-weight-bold mt-2">Fixed Asset Lists</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content br-n pn">
                                <div class="table-responsive text-black">
                                    <table class="table" id="example23">
                                        <thead>
                                            <tr>
                                                <th>name</th>
                                                <th>@lang('lang.item') @lang('lang.code')</th>
                                                <th>@lang('lang.item') @lang('lang.name')</th>
                                                <th>@lang('lang.related_category')</th>
                                                <th>@lang('lang.related_subcategory')</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody id="item">
                                            <tr>
                                                <td>skd</td>
                                                <td>sdkf</td>
                                                <td>skdfj</td>
                                                <td>safkj</td>                                      
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-outline-warning" data-toggle="modal" data-target="#edit_item">
                                                        <i class="fas fa-edit"></i></a>
                                                </td>
                    
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit_item" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('lang.edit_category_form')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="form-material m-t-40" method="post" action="" enctype='multipart/form-data'>
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('lang.code')</label>
                            <input type="text" name="item_code" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('lang.name')</label>
                            <input type="text" name="item_name" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label class="control-label">@lang('lang.item_photo')</label>
                            <input type="file" name="photo_path" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('lang.related_category')</label>
                            <select class="form-control select2 m-b-10" name="category_id" style="width: 100%">
 
                                <option value="" >dd</option>
                             
                            </select>
                        </div>
                        <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save')">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('js')
    <script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

    <script>
        $(document).ready(function() {
                //print button
             
               
        });


            $(".select2").select2();

            $('#example23').DataTable({

                "paging": false,
                "ordering": true,
                "info": false,

            });

    </script>
    @endsection
