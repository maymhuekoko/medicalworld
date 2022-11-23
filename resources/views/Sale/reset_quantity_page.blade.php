@extends('master')

@section('title','Result Quantity')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Result Quantity</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
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
        <h4 class="font-weight-normal">Result Quantitye</h4>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mt-4">
                <select name="category" class="form-control" id="category" onchange="searchSubCategory(this.value)">
                    <option value="">Category</option>
                    @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mt-4">
                <select style="width: 250px" name="subcategory" class="form-control" id="subcategory" onchange="searchCountingUnit(this.value)">
                    <option value="">Subcategory</option>
                    @foreach($sub_categories as $sub_category)
                        <option value="{{$sub_category->id}}">
                            {{$sub_category->name}}
                        </option>
                    @endforeach
                </select>
            </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-black">@lang('lang.select_item')</label>
                            <select class="form-control select2" id="item_list">
                                <option></option>
                                    @foreach ($counting_units as $unit)
                                        <option value="{{$unit->id}}"
                                            >{{$unit->unit_code??"unit code"}} - {{$unit->unit_name ?? "name"}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>


{{--
                <div class="row justify-content-end">
                    <button class="btn btn-success" onclick="checkUnit()">
                        <i class="fa fa-check"></i> @lang('lang.check_unit')
                    </button>
                </div> --}}

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
                                <th>Item Code</th>
                                <th>@lang('lang.item') @lang('lang.name')</th>
                                <th>Result Quantity</th>
                                @if(session()->get('user')->role == "Owner")
                                <th>@lang('lang.action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="units_table">
                            @php
                            $jj=1;
                            @endphp


                                @foreach ($counting_units as $unit)
                                <tr>
                                    <td>{{$unit->id}}</td>

                                    <td>{{$unit->unit_code}}</td>
                                    <td>{{$unit->unit_name}}</td>

                                    <td>
                                        <input type="number" class="form-control w-50 resetinput text-black" data-resetinputid="resetinput{{$unit->id}}" id="resetinput{{$unit->id}}" data-id="{{$unit->id}}" value="{{$unit->reset_quantity}}">
                                    </td>

                                    @if(session()->get('user')->role == "Owner")

                                    <td>
                                        <div class="row">
                                            <a href="#" class="btn btn-warning unitupdate"
                                            data-unitid="{{$unit->id}}" data-code="{{$unit->unit_code}}" data-unitname="{{$unit->unit_name}}"
                                                >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger delete_stock" data-id="{{$unit->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                    </td>
                                    @endif
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

        $('#units_table').empty();

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

                    
                    let inputreset = `<input type="number" class="form-control w-50 resetinput text-black" data-resetinputid="resetinput${value.id}" id="resetinput${value.id}" data-id="${value.id}" value="${value.reset_quantity}">`;

                    // if(isowner == "Owner"){
                        $('#units_table').append($('<tr>')).append($('<td>').text(1)).append($('<td>').text(value.unit_code)).append($('<td>').text(value.unit_name)).append($('<td>').append(inputreset)).append($('<td>').append(inputsaleprice)).append($('<td>').append(inputpurchaseprice)).append($('<td>').append($(button)));
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
            var stock_qty = $(this).val();
            var unit_id= $(this).data('id');
            var stockinputid = $(this).data('stockinputid');
            swal(
                    {
                      title: "Stock Change",
                      text: "Enter Remark for Stock Count Change!",
                      content: "input",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      animation: "slide-from-top",
                      inputPlaceholder: "Remark"
                    }    
                    
                ).then((result)=> {
            
            $.ajax({

                type:'POST',

                url:'{{route('stockupdate-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "stock_qty": stock_qty,
                    "shop_id":shop_id,
                    "unit_id":unit_id,
                    "remark" : result
                },

                success:function(data){
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
                });
        }


    })

    $('#units_table').on('keypress','.resetinput',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            var reset_quantity = $(this).val();
            var unit_id= $(this).data('id');
            var resetinputid = $(this).data('resetinputid');
            $.ajax({

                type:'POST',

                url:'{{route('resetquantityupdate-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "reset_quantity": reset_quantity,
                    "shop_id":shop_id,
                    "unit_id":unit_id
                },

                success:function(data){
                    if(data){
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Success",
                            text:"Result quantity Changed!",
                            button:false,
                            timer:500,
                            icon:"success"
                        });
                        $(`#${resetinputid}`).addClass("is-valid");
                        $(`#${resetinputid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500
                        });
                        $(`#${resetinputid}`).addClass("is-invalid");
                    }
                },
                });
        }


    })


    $('#units_table').on('keypress','.ppriceinput',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            var purchase_price = $(this).val();
            var unit_id= $(this).data('id');
            var ppriceinputid = $(this).data('ppriceinputid');
            $.ajax({

                type:'POST',

                url:'{{route('purchasepriceupdate-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "purchase_price": purchase_price,
                    "shop_id":shop_id,
                    "unit_id":unit_id
                },

                success:function(data){
                    if(data){
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Success",
                            text:"Purchase Price Changed!",
                            button:false,
                            timer:500,
                            icon:"success"
                        });
                        $(`#${ppriceinputid}`).addClass("is-valid");
                        $(`#${ppriceinputid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500
                        });
                        $(`#${ppriceinputid}`).addClass("is-invalid");
                    }
                },
                });
        }


    })

             function searchSubCategory(value){
                let cat_id = value;
                // alert(cat_id);

                $('#subcategory').empty();

                $.ajax({
                    type: 'POST',
                    url: '/subcategory_search',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "category_id": cat_id,
                    },

                    success: function(data) {
                        console.log(data);
                        if(data.length > 0){
                            $('#subcategory').append($('<option>').text('Subcategory'));
                            $.each(data, function(i, value) {
                            $('#subcategory').append($('<option>').text(value.name).attr('value', value.id));
                            });
                        }else{
                            $('#subcategory').append($('<option>').text('No Subcategory'));
                        }
                    },

                    error: function(status) {
                        swal({
                            title: "Something Wrong!",
                            text: "Error in subcategory search",
                            icon: "error",
                        });
                    }

                });

            }

            function searchCountingUnit(value){

                let sub_id = value;
                let cat_id = $('#category').val();
                $('#item_list').empty();
                $.ajax({
                    type: 'POST',
                    url: '/unit_search',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "category_id" : cat_id,
                        "subcategory_id": sub_id,
                    },


                    success: function(data) {
                        console.log(data);
                        var html="";
                        $('#item_list').append($('<option>').text('units'));
                        $.each(data,function(i,v){
                            $('#item_list').append($('<option>').text(v.unit_code +"-"+
                                v.unit_name).attr('value', v.id));

                            html += `
                    <tr>
                                    <td>${v.id}</td>
                                    <td>${v.unit_code}</td>
                                    <td>${v.unit_name}</td>
                                    <td>
                                        <input type="number" class="form-control w-50 resetinput text-black" data-resetinputid="resetinput${v.id}" id="resetinput${v.id}" data-id="${v.id}" value="${v.reset_quantity}">
                                    </td>
                                    <td>
                                        <div class="row">
                                            <a href="#" class="btn btn-warning unitupdate"
                                            data-unitid="${v.id}" data-code="${v.unit_code}" data-unitname="${v.unit_name}"

                                            >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger delete_stock" data-id="${v.id}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                    </td>
                                </tr>
                    `;
                        })
                        $('#units_table').empty();
            $('#units_table').html(html);

                    },
                    error: function(status) {
                        console.log(status);
                        swal({
                            title: "Something Wrong!",
                            text: "Error in searching units",
                            icon: "error",
                        });
                    }
                });
            }


</script>
@endsection
