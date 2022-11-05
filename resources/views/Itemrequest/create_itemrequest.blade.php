@extends('master')

@section('title','Create itemrequest')

@section('place')
@php
$from_id = session()->get('from')
@endphp 
{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.itemrequest') @lang('lang.create')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Create itemrequest</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.itemrequest') @lang('lang.create')</h4>
    </div>
</div>

<div class="row">
    <div class="col-7">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">@lang('lang.itemrequest') @lang('lang.create')</h4>

                <form class="form-material m-t-40" method="post" action="{{route('store_itemrequest')}}">
                    @csrf

                    <div class="form-group">    
                        <label class="font-weight-bold">Due @lang('lang.date')</label>
                        <input type="date" name="itemrequest_date" class="form-control"> 
                    </div>

                    <div id="unit_place">
                        <div class="row">
                        <label class="font-weight-bold">Item</label>
                        <label class="font-weight-bold">Units</label>
                        <label class="font-weight-bold">Qty</label>
                        <label class="font-weight-bold">Price</label>
                        <label class="font-weight-bold">Amount</label>
                        <label class="font-weight-bold">Remark</label>
                        </div>
                    </div>                

                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="Save Unit">
                </form>
            </div>
        </div>
    </div>

    <div class="col-5">
        <div class="card shadow">
            <div class="form-group m-2">  
                <label class="font-weight-bold">@lang('lang.item')</label>
                <select class="p-4 select form-control" name="item" id="counting_unit_select" >
                    <option></option>
                    @foreach ($items as $item)
                        @if ($item->counting_units)
                            @foreach ($item->counting_units as $counting_unit)
                                @foreach ($counting_unit->stockcount as $stock)
                                    @php
                                        if($stock->from_id== $from_id){
                                         $stockcountt= $stock->stock_qty;
                                        }
                                    @endphp
                                @endforeach
                                <option data-unitname="{{$counting_unit->unit_name}}" data-id="{{$counting_unit->id}}" data-itemname="{{$item->item_name}}" value="{{ $counting_unit->id }}">{{ $counting_unit->unit_code }}&nbsp; &nbsp; -{{ $counting_unit->unit_name }}&nbsp;&nbsp; {{$stockcountt}}ခု</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group m-2">    
                <label class="font-weight-bold">@lang('lang.quantity')</label>
                <input type="number" id="qty" class="form-control" > 
            </div>

            <div class="form-actions m-2">
              <button type="submit" class="btn btn-success float-right" id="add"> 
                <i class="fa fa-check"> </i> @lang('lang.add')
            </button>
              
            </div>
                       
        </div>
    </div>
</div>
@endsection


@section('js')

<script type="text/javascript">

    $(document).ready(function(){

        $(".select2").select2();
        $(".select").select2({
            placeholder:"ရှာရန်",
        });
    });

    var count = 0

    $('#add').click(function(event){

        event.preventDefault();

        var counting_unit_select=  $( "#counting_unit_select option:selected" ).data('unitname');
        var html = "";
        
        count + 1;
   
        var qty = $('#qty').val();

        var unit_id =  $( "#counting_unit_select option:selected" ).data('id');

        var unit_name =   $( "#counting_unit_select option:selected" ).data('unitname');
        
        var item =$( "#counting_unit_select option:selected" ).data('itemname');

        if($.trim(qty) == '' || $.trim(unit_id) == '')
        {
            swal({
                title:"Failed!",
                text:"Please fill all basic unit field",
                icon:"info",
                timer: 3000,
            });
            
        }else{

            html+=`<div class="form-group" id="removeclass_${count}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="${item}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="unit[]" value="${unit_id}">
                                    <input type="text" class="form-control" value="${unit_name}" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="qty[]" value="${qty}">
                                </div>
                            </div>

                            <div class="col-md-1">
                                <button class="btn-outline-danger" type="button" onclick="remove_education_fields(${count});"> 
                                    <i class="fa fa-minus"></i> 
                                </button>
                            </div>
                        </div>
                   </div>`

            $("#unit_place").append(html);   

            formClear(); 
        }   
    });

    function remove_education_fields(rid) {

        console.log(rid);
        
        $('#removeclass_' + rid).remove();
    }

    function formClear() {

        $('#item').empty();

        $('#unit').empty();

        $( "#item" ).prop( "disabled", true );

        $( "#unit" ).prop( "disabled", true );

        $("#qty").val("");

        $("#price").val("");   
    }

    
</script>


@endsection