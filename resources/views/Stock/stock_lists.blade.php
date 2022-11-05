@extends('master')

@section('title','Stock Lists')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.total_inventory_value')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.total_inventory_value')</li>
    </ol>
</div> --}}

@endsection

@section('content')
@php
$from_id = session()->get('from')
@endphp
<input type="hidden" id="isowner" value="{{session()->get('user')->role}}">
<input type="hidden" id="isshop" value="{{session()->get('from')}}">
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="font-weight-black">@lang('lang.total_inventory_value')</h4>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">

        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">@lang('lang.counting_unit') @lang('lang.list')</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive text-black printableArea">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>@lang('lang.item') @lang('lang.code')</th>
                                <th>@lang('lang.item') @lang('lang.name')</th>
                                <th>@lang('lang.current') @lang('lang.quantity')</th>
                                <th>@lang('lang.purchase_price')</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="units_table">
                        @php
                            $allTotal = 0;
                            $stockTotal = 0;
                            $i=1;
                        @endphp
                            

                                @foreach ($counting_units as $unit)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$unit->unit_code ?? ''}}</td>
                                    <td>{{$unit->unit_name ?? ''}}</td>
                                    
                                    <td>
                                      {{$unit->current_quantity ?? 0}}
                                      @php
                                            $allTotal+= $unit->purchase_price * $unit->current_quantity;
                                            $stockTotal+= $unit->current_quantity;
                                      @endphp
                                    </td>
                                    <td>{{$unit->purchase_price}}</td>
                                    <td class="text-right">{{$unit->purchase_price * $unit->current_quantity}}</td>
                                </tr>

                                @endforeach

                           
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-info">Stock Total</td>
                                <td class="font-bold">{{$stockTotal}}</td>
                                <td class="text-info">Total</td>
                                <td class="text-right font-bold">{{$allTotal}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script>

    $(document).ready(function(){

        $(".select2").select2();
        $("#item_list").select2({
            placeholder:"ကုန်ပစ္စည်း ရှာရန်",
        });
    });

    function getItems(value){

        var shop_id = value;

        $.ajax({

            type:'POST',

            url:'{{route('AjaxGetItem')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "shop_id": shop_id,
            },

            success:function(data){
                console.log(data);
                $('#item_list').empty();

                $('#item_list').append($('<option>').text("ရှာရန်").attr('value', ""));
                var html = "";
                var allTotal = 0 ;
                var stockTotal = 0 ;
                $.each(data, function(i, value) {

                $('#item_list').append($('<option>').text(value.item_name).attr('value', value.id));

                $.each(value.counting_units,function(j,unit){
                    var stockcountt=0;
                    $.each(unit.stockcount,function(k,stock){
                        if(stock.from_id==shop_id){
                             stockcountt= unit.stockcount[k].stock_qty;
                        }
                    })

                    allTotal += unit.purchase_price * stockcountt;
                    stockTotal += stockcountt;
                    html += `
                    <tr>
                                    <td>${unit.unit_code ?? ""}</td>
                                    <td>${value.item_name}</td>
                                    <td>${unit.unit_name}</td>
                                    <td>${stockcountt}
                                        </td>
                                    <td>${unit.purchase_price}</td>
                                    <td class="text-right">${unit.purchase_price * stockcountt}</td>
                                </tr>
                    `;
                });


            }),
            html+= `
                <tr>
                                <td></td>
                                <td></td>
                                <td class="text-info">Stock Total</td>
                                <td>${stockTotal}</td>
                                <td class="text-info">Total</td>
                                <td class="text-right font-bold">${allTotal}</td>
                            </tr>
                `;
            $('#units_table').empty();
            $('#units_table').html(html);
            swal({
                toast:true,
                position:'top-end',
                title:"Success",
                text:"Shop Changed!",
                button:false,
                timer:500
            });
        }

    })
}



$("#print").click(function() {

    var mode = 'iframe'; //popup
    var close = mode == "popup";
    var options = {
        mode: mode,
        popClose: close
    };

    $("div.printableArea").printArea(options);

    });

</script>
@endsection
