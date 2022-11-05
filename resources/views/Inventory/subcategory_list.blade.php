@extends('master')

@section('title','SubCategory List')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.subcategory') @lang('lang.list')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h2 class="font-weight-bold">@lang('lang.subcategory') @lang('lang.list')</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm rounded">
            <div class="card-header">
                <div class="d-flex">
                    <form action="{{route('subCategoryImport')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="file" name="import_file" required>
                        <button type="submit" class="btn btn-danger">Import</button>
                    </form>
                    {{--                    <a href="{{ route('colourExport') }}" class="btn btn-primary mx-2">Export</a>--}}
                    
                        <a href="{{ route('subCategoryExport') }}" class="btn btn-primary mx-2">Export</a>
                   
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive text-black">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.subcategory') @lang('lang.code')</th>
                                <th>@lang('lang.related_category')</th>
                                <th>@lang('lang.subcategory') @lang('lang.name')</th>
                                <th>Type</th>
                                <th class="text-center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>
                            @foreach($sub_categories as $sub_category)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$sub_category->subcategory_code}}</td>
                                <td>{{$sub_category->category->category_name}}</td>
                                <td>{{$sub_category->name}}</td>
                                @if($sub_category->type_flag == 1)
                                <td>Sales</td>
                                @else
                                <td>Factory</td>
                                @endif
                                <td class="text-center">
                                    <a href="#" class="btn btn-outline-warning" data-toggle="modal" data-target="#edit_subcategory{{$sub_category->id}}"><i class="far fa-edit"></i>
                                        <i class="fas fa-edit"></i></a>
                                </td>

                                <div class="modal fade" role="dialog" id="edit_subcategory{{$sub_category->id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">@lang('lang.edit_subcategory_form')</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>

                                    <div class="modal-body">
                                        <form class="form-material m-t-40" method="post" action="{{route('sub_category_update', $sub_category->id)}}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.code')</label>
                                                <input type="number" name="sub_category_code" class="form-control" value="{{$sub_category->subcategory_code}}">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.name')</label>
                                                <input type="text" name="sub_category_name" class="form-control" value="{{$sub_category->name}}">
                                            </div>
                                            <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save')">
                                        </form>
                                    </div>

                              </div>
                                    </div>
                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.create_subcategory_form')</h3>
                <form class="form-material m-t-40" method="post" action="{{route('sub_category_store')}}">
                    @csrf

                    <div class="form-group">
                    <div class="row">
                <div class="form-check form-check-inline offset-3">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="0">
                    <label class="form-check-label" for="inlineRadio1">Sales</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="1">
                    <label class="form-check-label" for="inlineRadio2">Factory</label>
                  </div>
                </div>
                    </div>


                    <div class="form-group">
                        <label class="font-weight-bold">@lang('lang.code')</label>
                        <input type="number" name="sub_category_code" class="form-control @error('category_code') is-invalid @enderror" placeholder="@lang('lang.enter_subcategory_code')" required>

                        @error('sub_category_code')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">@lang('lang.category')</label>
                        <select class="form-control" name="category" required>
                            <option value="">@lang('lang.select')</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>

                        @error('sub_category_code')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">@lang('lang.name')</label>
                        <input type="text" name="sub_category_name" class="form-control @error('sub_category_name') is-invalid @enderror" placeholder="@lang('lang.enter_subcategory_name')" required>

                        @error('sub_category_name')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>
                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save_subcategory')">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
