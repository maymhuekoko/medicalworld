@extends('master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

@section('title','Product Instock Preorder Quantity')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Product Instock Preorder Quantity</h3>
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
        <h4 class="font-weight-normal">Product Instock Preorder Quantity</h4>
    </div>
</div>
@if(session()->has('success'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong>{{session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
<!-- <div class="row">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-black">@lang('lang.select_item')</label>
                            <select class="form-control select2" id="item_list">
                                <option></option>
                                    @foreach ($counting_units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->id??"id"}}. {{$unit->item_code??"unit code"}} - {{$unit->item_name ?? "name"}}</option>
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
</div> -->

<div class="row">
    <div class="col-lg-12">

        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Products List</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive text-black">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Code</th>
                                <th>@lang('lang.item') @lang('lang.name')</th>
                                <th style="padding-left: 30px;">Instock</th>
                                <th style="padding-left: 20px;">Preorder</th>
                                <th>Photo Path Name</th>
                                <th>Product Photos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="units_table">

                                @foreach ($counting_units as $unit)
                                <tr>
                                    <td style="max-width: 30px">{{$unit->id}}</td>
                                    <td style="max-width: 100px">{{$unit->item_code}}</td>
                                    <td>{{$unit->item_name}}</td>

                                    <td>
                                        @if($unit->instock == '1')
                                        <input type="checkbox" class="instock" style="width: 50px; position: relative; left: 0; opacity: 1;" data-instockid="instock{{$unit->id}}" id="instock{{$unit->id}}" data-id="{{$unit->id}}" value='0' checked>
                                        @else
                                        <input type="checkbox" class="instock" style="width: 50px; position: relative; left: 0; opacity: 1;" data-instockid="instock{{$unit->id}}" id="instock{{$unit->id}}" data-id="{{$unit->id}}" value='1'>
                                        @endif
                                    </td>
                                    <td>
                                        @if($unit->preorder == '1')
                                        <input type="checkbox" class="preorder" style="width: 50px; position: relative; left: 0; opacity: 1;" data-preorderid="preorder{{$unit->id}}" id="preorder{{$unit->id}}" data-id="{{$unit->id}}" value='0' checked>
                                        @else
                                        <input type="checkbox" class="preorder" style="width: 50px; position: relative; left: 0; opacity: 1;" data-preorderid="preorder{{$unit->id}}" id="preorder{{$unit->id}}" data-id="{{$unit->id}}" value='1'>
                                        @endif
                                    </td>
                                    <form method="post" action="uploadingphotos" enctype="multipart/form-data">
                                    @csrf
                                    <td>
                                        <input type='hidden' name="unit_id" value="{{$unit->id}}" />
                                        <input type='text' class="form-control" name="photo_path" value="{{old('photo_path')}}"/>
                                    </td>
                                    <td>
                                        <input type="file" name="photos[]" class="form-control" style="min-width: 144.633px; max-width: 144.633px; height: 40px;" multiple/>
                                    </td>
                                    
                                    @if(session()->get('user')->role == "Owner")

                                    <td>
                                        <div class="row">
                                            <button type='submit' class="btn btn-primary delete_stock">Add Photo</button>
                                        </div>
                                    </td>
                                    @endif
                                    </form>
                                </tr>
                                @endforeach

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

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

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

                $.each(value.items,function(j,unit){
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

                    let inputstock = `<input type="number" class="form-control w-50 stockinput text-black" data-stockinputid="stockinput${value.id}" id="stockinput${value.id}" data-id="${value.id}" value="${value.current_quantity}">`;

                    let inputsaleprice = `<input type="number" class="form-control w-50 spriceinput text-black" data-spriceinputid="spriceinput${value.id}" id="spriceinput${value.id}" data-id="${value.id}" value="${value.order_price}">`;

                    let inputpurchaseprice = `<input type="number" class="form-control w-50 ppriceinput text-black" data-ppriceinputid="ppriceinput${value.id}" id="ppriceinput${value.id}" data-id="${value.id}" value="${value.purchase_price}">`;
                    // if(isowner == "Owner"){
                        $('#units_table').append($('<tr>')).append($('<td>').text(1)).append($('<td>').text(value.unit_code)).append($('<td>').text(value.unit_name)).append($('<td>').append(inputstock)).append($('<td>').append(inputsaleprice)).append($('<td>').append(inputpurchaseprice)).append($('<td>').append($(button)));
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

    // Instock Flag

    $('#units_table').on('keypress','.instock',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            // if ($('.instock').is(":checked"))
            // {
            //     var chek_value = 1;
            // } else {
            //     var chek_value = 0;
            // }
            var chek_value = $(this).val();
            var unit_id= $(this).data('id');
            var instockid = $(this).data('instockid');
            swal(
                    {
                      title: "Flag Change",
                      text: "Instock Flag Change!",
                      content: "input",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      animation: "slide-from-top",
                      inputPlaceholder: "Remark"
                    }    
                    
                ).then((result)=> {
            
            $.ajax({

                type:'POST',

                url:'{{route('instockcheckon-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "chek_value": chek_value,
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
                            text:"Instock Flag Change!",
                            button:false,
                            timer:500,
                            icon:"success"
                        });
                        $(`#${instockid}`).addClass("is-valid");
                        $(`#${instockid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500
                        });
                        $(`#${instockid}`).addClass("is-invalid");
                    }
                },
                });
                });
        }
    })

    // Preorder

    $('#units_table').on('keypress','.preorder',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            // if ($('.preorder').is(":checked"))
            // {
            //     var chek_value = 1;
            // } else {
            //     var chek_value = 0;
            // }
            var chek_value = $(this).val();
            var unit_id= $(this).data('id');
            var preorderid = $(this).data('preorderid');
            swal(
                    {
                      title: "Flag Change",
                      text: "Preorder Flag Change!",
                      content: "input",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      animation: "slide-from-top",
                      inputPlaceholder: "Remark"
                    }    
                    
                ).then((result)=> {
            
            $.ajax({

                type:'POST',

                url:'{{route('preordercheckon-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "chek_value": chek_value,
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
                            text:"Preorder Flag Change!",
                            button:false,
                            timer:500,
                            icon:"success"
                        });
                        $(`#${preorderid}`).addClass("is-valid");
                        $(`#${preorderid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500
                        });
                        $(`#${preorderid}`).addClass("is-invalid");
                    }
                },
                });
                });
        }
    })

    $('#units_table').on('keypress','.newarrck',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            if ($('.newarrck').is(":checked"))
            {
                var chek_value = 1;
            } else {
                var chek_value = 0;
            }
            // var chek_value = $(this).val();
            var unit_id= $(this).data('id');
            var newarrckid = $(this).data('newarrckid');
            swal(
                    {
                      title: "Flag Change",
                      text: "New Arrival Flag Change!",
                      content: "input",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      animation: "slide-from-top",
                      inputPlaceholder: "Remark"
                    }    
                    
                ).then((result)=> {
            
            $.ajax({

                type:'POST',

                url:'{{route('newarrcheckon-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "chek_value": chek_value,
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
                            text:"New Arrival Flag Change!",
                            button:false,
                            timer:500,
                            icon:"success"
                        });
                        $(`#${newarrckid}`).addClass("is-valid");
                        $(`#${newarrckid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500
                        });
                        $(`#${newarrckid}`).addClass("is-invalid");
                    }
                },
                });
            });
        }


    })

    $('#units_table').on('keypress','.promock',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            if ($('.promock').is(":checked"))
            {
                var chek_value = 1;
            } else {
                var chek_value = 0;
            }
            // var chek_value = $(this).val();
            var unit_id= $(this).data('id');
            var promockid = $(this).data('promockid');
            $.ajax({

                type:'POST',

                url:'{{route('promocheckon-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "chek_value": chek_value,
                    "shop_id":shop_id,
                    "unit_id":unit_id
                },

                success:function(data){
                    if(data){
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Success",
                            text:"Promotion Flag Changed!",
                            button:false,
                            timer:500,
                            icon:"success"
                        });
                        $(`#${promockid}`).addClass("is-valid");
                        $(`#${promockid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500
                        });
                        $(`#${promockid}`).addClass("is-invalid");
                    }
                },
                });
        }


    })

    $('#units_table').on('keypress','.hotck',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var shop_id = $('#shop_id').val() ?? $('#isshop').val();
            if ($('.hotck').is(":checked"))
            {
                var chek_value = 1;
            } else {
                var chek_value = 0;
            }
            // var chek_value = $(this).val();
            var unit_id= $(this).data('id');
            var hotckid = $(this).data('hotckid');
            $.ajax({

                type:'POST',

                url:'{{route('hotsalecheckon-ajax')}}',

                data:{
                    "_token":"{{csrf_token()}}",
                    "chek_value": chek_value,
                    "shop_id":shop_id,
                    "unit_id":unit_id
                },

                success:function(data){
                    if(data){
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Success",
                            text:"Hotsale Flag Changed!",
                            button:false,
                            timer:500,
                            icon:"success"
                        });
                        $(`#${hotckid}`).addClass("is-valid");
                        $(`#${hotckid}`).blur();
                    }
                    else{
                        swal({
                            toast:true,
                            position:'top-end',
                            title:"Error",
                            button:false,
                            timer:1500
                        });
                        $(`#${hotckid}`).addClass("is-invalid");
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
                                    <td>${++i}</td>
                                    <td>${v.unit_code}</td>
                                    <td>${v.unit_name}</td>
                                    <td>
                                        <input type="number" class="form-control w-50 stockinput text-black" data-stockinputid="stockinput${v.id}" id="stockinput${v.id}" data-id="${v.id}" value="${v.current_quantity}">
                                        </td>
                                    <td>
                                        <input type="number" class="form-control w-50 spriceinput text-black" data-spriceinputid="spriceinput${v.id}" id="spriceinput${v.id}" data-id="${v.id}" value="${v.order_price}">
                                        </td>
                                        <td>
                                        <input type="number" class="form-control w-50 ppriceinput text-black" data-ppriceinputid="ppriceinput${v.id}" id="ppriceinput${v.id}" data-id="${v.id}" value="${v.purchase_price}">
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
