@extends('master')

@section('title','Item Adjust')

@section('place')

@endsection

@section('content')
@php
$from_id = session()->get('from')
@endphp 
<input type="hidden" id="isowner" value="{{session()->get('user')->role}}">
<input type="hidden" id="isshop" value="{{session()->get('from')}}">
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">@lang('lang.item_adjust') @lang('lang.list')</h4>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">               
                <div class="row">
                    @if(session()->get('user')->role == "Owner")
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-black">ဆိုင်ရွေးရန်</label>
                            <select class="form-control select2" onchange="getItems(this.value)" id="shop_id">
                                @foreach($shops as $shop)
                                <option value="{{$shop->id}}"
                                @if ($from_id==$shop->id)
                                    selected
                                @endif
                                >{{$shop->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-black">@lang('lang.select_item')</label>
                            <select class="form-control select2" id="item_list">
                                <option></option>
                                @foreach ($items as $item)
                                @if ($item->counting_units)
                                    @foreach ($item->counting_units as $unit)
                                    @foreach ($unit->stockcount as $key=>$stockcount)
                                  
                                    @endforeach
                                        <option value="{{$unit->id}}"
                                            >{{$unit->unit_code}} - {{$unit->unit_name}}</option>
                                        
                                    @endforeach
                                @endif
                                @endforeach
                            </select>                            
                        </div>
                    </div>
                </div>
    
            </div>        
        </div>
    </div>
</div>

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
                                <th></th>
                                <th>Item Code</th>
                                <th>@lang('lang.item') @lang('lang.name')</th>
                                <th>@lang('lang.current') @lang('lang.quantity')</th>
                                <th>+/-</th>
                                <th>@lang('lang.item_adjust')</th>
                                <th>@lang('lang.new_qty')</th>
                                <th>@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody id="units_table">

                        </tbody>
                    </table>
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
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection

@section('js')

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
                $('#item_list').empty();             

                $('#item_list').append($('<option>').text("ရှာရန်").attr('value', ""));
                var html = "";
                $.each(data, function(i, value) {

                $('#item_list').append($('<option>').text(value.item_name).attr('value', value.id));
                
                $.each(value.counting_units,function(j,unit){
                    var stockcountt=0;
                    $.each(unit.stockcount,function(k,stock){
                        if(stock.from_id==shop_id){
                             stockcountt= unit.stockcount[k].stock_qty;
                        }
                    })
                    html += `
                    <tr>
                                    <td>${unit.unit_code}</td>
                                    <td>${unit.unit_name}</td>
                                    <td>
                                        <input type="number" class="form-control w-25 stockinput text-black" data-stockinputid="stockinput${unit.id}" id="stockinput${unit.id}" data-id="${unit.id}" value="${stockcountt}">
                                        </td>
                                    <td>${unit.reorder_quantity}</td>
                                    <td> 
                                        <div class="row">
                                            <a href="#" class="btn btn-warning unitupdate" 
                                            data-unitid="${unit.id}" data-code="${unit.unit_code}" data-unitname="${unit.unit_name}"

                                            >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger delete_stock" data-id="${unit.id}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    
                                    </td>
                                </tr>
                    `;
                });    
                

            }),
            // $('#units_table').empty();
            $('#units_table').append(html); 
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
    $('.delete_stock').click(function(){
        var id = $(this).data('id');
        var idArray= [];
        $("input:checkbox[name=assign_check]:checked").each(function(){
        idArray.push(parseInt($(this).val()));
        });
        if(idArray.length >0){
            var unit_ids = idArray;
            var multi_delete = 1;
        }else{
            var unit_ids = id;
            var multi_delete = 0;
        }
        $.ajax({

            type:'POST',

            url:'{{route('delete_units')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "unit_ids": unit_ids,
                "multi_delete":multi_delete
            },

            success:function(data){
                swal({
                    title: "@lang('lang.success')!",
                    text : "@lang('lang.successfully_deleted')!",
                    icon : "success",
                        });

                setTimeout(function(){
                window.location.reload();
            }, 1000);
                
            },
            });
    })

    $('#item_list').change(function(){

        //shop id for owner . isshop for counter
        let shop_id = $('#shop_id').val() ?? $('#isshop').val();

        let unit_id = $('#item_list').val();
        console.log(unit_id);
        var isowner = $('#isowner').val();

        // $('#units_table').empty();

        $.ajax({

            type:'POST',

            url:'{{route('AjaxGetCountingUnit')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "unit_id": unit_id,
                "shop_id":shop_id
            },

            success:function(data){
                    var value = data;
                    var stockcountt=0;
                    $.each(value.stockcount,function(k,stock){
                        if(stock.from_id==shop_id){
                             stockcountt= stock.stock_qty;
                            console.log('stockcount',stock.stock_qty);
                        }
                    })
                    let plus_minus= `
                    <select class="form-select form-control" id="plusminus${value.id}">
                    <option value="plus" class="text-success font-weight-bold">+</option>
                    <option value="minus" class="text-danger font-weight-bold">-</option>
                    </select>
                    `;
                    let button = `
                    <div class="row">
                        <a  href="#" class="btn btn-warning unitupdate" 
                        
                        data-unitid="${value.id}" data-code="${value.unit_code}" data-unitname="${value.unit_name}"

                        >Edit</a>
                        <button class="btn btn-danger delete_stock" data-id="${value.id}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                        </div>
            
                    
                    `;
                    
                    // let inputstock = `<input type="number" class="form-control w-25 stockinput text-black" data-stockinputid="stockinput${value.id}" id="stockinput${value.id}" data-id="${value.id}" value="${stockcountt}">`;

                    let item_adjust = `<input type="number" class="form-control w-25 stockinput text-black" data-stockinputid="stockinput${value.id}" id="stockinput${value.id}" data-id="${value.id}"
                    data-currentqty="${stockcountt}" value="0">`;

                    let new_qty = `
                    <p id="new_qty${value.id}">${stockcountt}</p>
                    `;
                    // if(isowner == "Owner"){
                        $('#units_table').append($('<tr>')).append($('<td>').text(1)).append($('<td>').text("")).append($('<td>').text(value.unit_code)).append($('<td>').text(value.unit_name)).append($('<td>').text(stockcountt)).append($('<td>').append(plus_minus)).append($('<td>').append(item_adjust)).append($('<td>').append(new_qty)).append($('<td>').append($(button)));
                    // }
                    // else{
                    //     $('#units_table').append($('<tr>')).append($('<td>').text(value.item.category.category_name)).append($('<td>').text(value.item.item_name)).append($('<td>').text(value.unit_name)).append($('<td>').append(stockcountt)).append($('<td>').append(value.reorder_quantity));
                    // }
         


                
            },
        });

    })
    
        $('.row').on('click','.unitupdate',function(){
              event.preventDefault()
        var id = $(this).data('unitid');
        var code = $(this).data('code');
        var name = $(this).data('unitname');
        console.log(id,code,name);
        $("#unit_id").val(id);   
        $("#unique_unit_code").val(code);   
        $("#unique_unit_name").val(name);   
        $("#edit_unit_qty").modal("show");  
        })
    
  
    
    
    $('#units_table').on('keypress','.stockinput',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            var adjust_qty = $(this).val();
            var unit_id= $(this).data('id');
            var stockinputid = $(this).data('stockinputid');
            var currentqty = $(this).data('currentqty');
            var plusminus = $(`#plusminus${unit_id}`).val();

            console.log(adjust_qty,unit_id,stockinputid,plusminus);
            $.ajax({

                type:'POST',

                url:'{{route('itemadjust-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "adjust_qty": adjust_qty,
                    "shop_id":shop_id,
                    "unit_id":unit_id,
                    "plusminus" :plusminus,
                    "currentqty" : currentqty
                },

                success:function(data){
                    console.log(data.counting_unit_id);
                    if(data){
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Success",
                            text:"Stock Changed!",
                            button:false,
                            timer:500,
                            icon:"success"  
                        });
                        $(`#new_qty${data.counting_unit_id}`).text(data.stock_qty);
                        $(`#${stockinputid}`).addClass("is-valid");
                        $(`#${stockinputid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500  
                        });
                        $(`#${stockinputid}`).addClass("is-invalid");
                    }
                },
                });
        }
    })
  

</script>
@endsection