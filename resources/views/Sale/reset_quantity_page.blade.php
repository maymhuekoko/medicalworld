@extends('master')

@section('title','Reset Quantity Page')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Reset Quantity</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Reset quantity</li>
    </ol>
</div> --}}

@endsection

@section('content')
@php
$from_id = session()->get('from')
@endphp

<div class="row">
    <div class="col-lg-12">

        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">@lang('lang.counting_unit') @lang('lang.list')</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive text-black">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Code</th>
                                <th>@lang('lang.item') @lang('lang.name')</th>
                                <th>Reset Quantity</th>
                                @if(session()->get('user')->role == "Owner")
                                <th>@lang('lang.action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="units_table">


                                @foreach ($counting_units as $unit)
                                <tr>

                                    <td>{{$unit->id}}</td>
                                    <td>{{$unit->unit_code}}</td>
                                    <td>{{$unit->unit_name}}</td>

                                    <form method="POST" action="resettingquantity">
                                        @csrf
                                    <td>
                                        <input type="hidden" name="unit_id" value="{{$unit->id}}"/>
                                        <input type="number" class="form-control w-50 text-black" name="reset_quantity" value="{{$unit->reset_quantity}}">
                                    </td>

                                    <td>
                                        <div class="row">
                                            <input type="submit" class="btn btn-danger" value="Change">
                                        </div>
                                    </td>
                                    </form>
                                </tr>
                                @endforeach



                            <div class="modal fade" id="edit_unit_qty" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('lang.update_counting_unit_quantity') @lang('lang.form')</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                        </div>

                                        <div class="modal-body">
                                            <form class="form-horizontal m-t-40" method="post" action="{{route('update_stock_count')}}">
                                                @csrf
                                                <input type="hidden" name="unit_id" id="unit_id">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-6 text-black">Code </label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="unique_unit_code" name="unit_code">

                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-6 text-black">ပစ္စည်း အမည်</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="unit_name" id="unique_unit_name">

                                                    </div>
                                                </div>

                                                <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save')">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')


@endsection
