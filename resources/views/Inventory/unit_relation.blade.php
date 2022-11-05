@extends('master')

@section('title','Unit Relations')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a><</li>
        <li class="breadcrumb-item active">{{$item->item_name}}'s @lang('lang.unit_relation_list')</li>
    </ol>
</div> --}}

@endsection


@section('content')
<div class="row">
	<div class="col-md-9">
		<div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">{{$item->item_name}}'s @lang('lang.unit_relation_list')</h4>
                <div class="table-responsive text-black">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.from_unit')</th>
                                <th>@lang('lang.to_unit')</th>
                                <th>@lang('lang.relation_quantity')</th>
                                <th>@lang('lang.unit_converter')</th>
                                <th>@lang('lang.edit')</th>
                                
                            </tr>
                        </thead>
                        <tbody id="category_table">
                        	<?php $i=1;?>
                        	@foreach($unit_relation as $unit)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$unit->from_unit_detail->unit_name}}</td>
                                <td>{{$unit->to_unit_detail->unit_name}}</td>
                                <td>{{$unit->quantity}}</td>
                                <td>
                                    <a href="{{route('convert_unit', $unit->id)}}" class="btn btn-primary">
                                        <i class="fa fa-calculator"></i> @lang('lang.unit_converter')
                                    </a>
                                </td>
                                <td>
                                    t_item{{$unit->id}}">@lang('lang.edit')</a>
                                </td>
                                
                                <div class="modal fade" id="edit_item{{$unit->id}}" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('lang.edit_unit_relation') @lang('lang.form')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form class="form-material" method="post" action="{{route('unit_relation_update', $unit->id)}}">
                                                	@csrf
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">@lang('lang.from_unit')</label>
                                                        <select class="select2" name="from_unit" style="width: 100%">
                                                        @foreach($counting_units as $count_unit)
                                                        
                                                         <option value="{{ $count_unit->id }}" @if($unit->from_unit === $count_unit->id) selected='selected' @endif > {{$count_unit->unit_name}}</option>  
                                                        
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">@lang('lang.to_unit')</label>
                                                        <select class="select2" name="to_unit" style="width: 100%">
                                                        @foreach($counting_units as $count_unit)
                                                        
                                                         <option value="{{ $count_unit->id }}" @if($unit->to_unit === $count_unit->id) selected='selected' @endif > {{$count_unit->unit_name}}</option>  
                                                        
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>@lang('lang.quantity')</label>
                                                        <input type="number" name="qty" class="form-control" value={{$unit->quantity}}> 
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

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.unit') @lang('lang.create') @lang('lang.form')</h3>
                <form class="form-material m-t-40" method="post" action="{{route('unit_relation_store')}}">
                	@csrf
                	<input type="hidden" value="{{$item->id}}" name="item_id">
                	
            
                    
                    <div class="form-group">	
                        <label class="font-weight-bold">@lang('lang.from_unit')</label>
                        <select class="select2" name="to_unit" style="width: 100%">
                            <option>@lang('lang.select')</option>
                            @foreach($counting_units as $unit)
                               
                            <option value="{{ $unit->id }}">{{$unit->unit_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">	
                        <label class="font-weight-bold">@lang('lang.to_unit')</label>
                        <select class="select2" name="from_unit" style="width: 100%">
                            <option>@lang('lang.select')</option>
                            @foreach($counting_units as $unit)
                               
                            <option value="{{ $unit->id }}">{{$unit->unit_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>@lang('lang.quantity')</label>
                        <input type="number" name="qty" class="form-control" placeholder="@lang('lang.enter_relation_quantity')"> 
                    </div>
                    
                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save')">
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@section('js')

<script type="text/javascript">
    
    $(".select2").select2(); 
    
</script>

@endsection